<?php

namespace FK\Bundle\AttributeAuthorizationBundle\EventSubscriber;

use FK\Bundle\AttributeAuthorizationBundle\Source\Attribute\AttributeReaderInterface;
use FK\Bundle\AttributeAuthorizationBundle\Source\Attribute\Authorize;
use FK\Bundle\AttributeAuthorizationBundle\Source\Exceptions\AuthorizationFailedException;
use FK\Bundle\AttributeAuthorizationBundle\Source\Exceptions\AuthorizationRequiredException;
use FK\Bundle\AttributeAuthorizationBundle\Source\Exceptions\MissingConfigurationException;
use FK\Bundle\AttributeAuthorizationBundle\Source\Exceptions\UnsupportedTokenManagerException;
use FK\Bundle\AttributeAuthorizationBundle\Source\TokenManager\TokenManagerServiceInterface;
use FK\Bundle\AttributeAuthorizationBundle\Source\Validation\JWTTokenValidationInterface;
use ReflectionException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class AuthorizationSubscriber implements EventSubscriberInterface
{
    private AttributeReaderInterface $attributeReader;
    private JWTTokenValidationInterface $JWTTokenValidation;
    private TokenManagerServiceInterface $tokenManagerService;

    public function __construct(
        AttributeReaderInterface     $attributeReader,
        JWTTokenValidationInterface  $JWTTokenValidation,
        TokenManagerServiceInterface $tokenManagerService
    )
    {
        $this->attributeReader = $attributeReader;
        $this->JWTTokenValidation = $JWTTokenValidation;
        $this->tokenManagerService = $tokenManagerService;
    }

    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::CONTROLLER => [
                ['onKernelController', 0]
            ],
        ];
    }

    /**
     * @param ControllerEvent $event
     * @throws AuthorizationRequiredException
     * @throws ReflectionException
     * @throws MissingConfigurationException
     * @throws UnsupportedTokenManagerException
     * @throws AuthorizationFailedException
     */
    public function onKernelController(ControllerEvent $event): void
    {
        $controllerClassName = get_class($event->getController()[0]);
        $methodName = $event->getController()[1];

        $methodHasAuthAttribute = $this->attributeReader->has(Authorize::class, $controllerClassName, $methodName);
        $classHasAuthAttribute = $this->attributeReader->has(Authorize::class, $controllerClassName);
        if (!$classHasAuthAttribute && !$methodHasAuthAttribute) {
            return;
        }

        $request = $event->getRequest();

        if (!$this->JWTTokenValidation->supports($request)) {
            throw new AuthorizationRequiredException();
        }

        $token = $this->tokenManagerService->obtainToken($request);
        $user = $this->tokenManagerService->resolveToken($token);
        if (is_null($user)) {
            throw new AuthorizationFailedException();
        }

        $event->getRequest()->attributes->set('authorizedUser', $user);
    }
}