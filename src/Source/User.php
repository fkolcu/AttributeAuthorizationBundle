<?php

namespace FK\Bundle\AttributeAuthorizationBundle\Source;

use Symfony\Component\Security\Core\User\UserInterface;

class User implements UserInterface
{
    private string $identifier;
    private array $roles;

    public function __construct(string $identifier, array $roles)
    {
        $this->identifier = $identifier;
        $this->roles = $roles;
    }

    /**
     * @inheritDoc
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * @inheritDoc
     */
    public function getUserIdentifier(): string
    {
        return $this->identifier;
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {
        // Do nothing
    }

    public function hasAnyRoleIn(array $expectedRoles): bool
    {
        foreach ($expectedRoles as $expectedRole) {
            if (in_array($expectedRole, $this->roles)) {
                return true;
            }
        }

        return false;
    }
}