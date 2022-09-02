<?php

namespace FK\Bundle\AttributeAuthorizationBundle\Source\Attribute;

use Attribute;

#[Attribute]
class Authorize
{
    /**
     * @var string[]
     */
    private array $roles;

    public function __construct(string ...$roles)
    {
        if (empty($roles)) {
            $roles = ['ROLE_USER'];
        }

        $this->roles = $roles;
    }

    /**
     * @return string[]
     */
    public function getRoles(): array
    {
        return $this->roles;
    }
}