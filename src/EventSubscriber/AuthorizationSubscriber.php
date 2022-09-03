<?php

namespace FK\Bundle\AttributeAuthorizationBundle\EventSubscriber;

use FK\Bundle\AttributeAuthorizationBundle\Source\Attribute\AttributeServiceInterface;
use FK\Bundle\AttributeAuthorizationBundle\Source\Attribute\Authorize;
use FK\Bundle\AttributeAuthorizationBundle\Source\Exceptions\AuthorizationFailedException;
use FK\Bundle\AttributeAuthorizationBundle\Source\Exceptions\AuthorizationRequiredException;
use FK\Bundle\AttributeAuthorizationBundle\Source\Exceptions\InsufficientPermissionException;
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
    private JWTTokenValidationInterface $JWTTokenValidation;
    private TokenManagerServiceInterface $tokenManagerService;
    private AttributeServiceInterface $attributeService;

    public function __construct(
        JWTTokenValidationInterface  $JWTTokenValidation,
        TokenManagerServiceInterface $tokenManagerService,
        AttributeServiceInterface    $attributeService
    )
    {
        $this->JWTTokenValidation = $JWTTokenValidation;
        $this->tokenManagerService = $tokenManagerService;
        $this->attributeService = $attributeService;
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
     * @throws InsufficientPermissionException
     */
    public function onKernelController(ControllerEvent $event): void
    {
        $controllerClass = get_class($event->getController()[0]);
        $methodName = $event->getController()[1];

        /** @var Authorize $attribute */
        $attribute = $this->attributeService->getAttribute(Authorize::class, $controllerClass, $methodName);

        $request = $event->getRequest();

        if (!$this->JWTTokenValidation->supports($request)) {
            throw new AuthorizationRequiredException();
        }

        $token = $this->tokenManagerService->obtainToken($request);
        $user = $this->tokenManagerService->resolveToken($token);
        if (is_null($user)) {
            throw new AuthorizationFailedException();
        }

        if (!$user->hasAnyRoleIn($attribute->getRoles())) {
            throw new InsufficientPermissionException();
        }

        $event->getRequest()->attributes->set('authorizedUser', $user);
    }
}