<?php

namespace FK\Bundle\AttributeAuthorizationBundle\EventSubscriber;

use FK\Bundle\AttributeAuthorizationBundle\Source\Attribute\AttributeReaderInterface;
use FK\Bundle\AttributeAuthorizationBundle\Source\Attribute\Authorize;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\User\UserInterface;

class AuthorizationSubscriber implements EventSubscriberInterface
{
    private AttributeReaderInterface $attributeReader;

    public function __construct(AttributeReaderInterface $attributeReader)
    {
        $this->attributeReader = $attributeReader;
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

    public function onKernelController(ControllerEvent $event): void
    {
        $controllerClassName = get_class($event->getController()[0]);
        $methodName = $event->getController()[1];

        $methodHasAuthAttribute = $this->attributeReader->has(Authorize::class, $controllerClassName, $methodName);
        $classHasAuthAttribute = $this->attributeReader->has(Authorize::class, $controllerClassName);
        if (!$classHasAuthAttribute && !$methodHasAuthAttribute) {
            return;
        }

        # TODO: validate token here

        /** @var UserInterface|null $user */
        $user = null;
        $event->getRequest()->attributes->set('authorizedUser', $user);
    }
}