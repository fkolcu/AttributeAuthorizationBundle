<?php

namespace FK\Bundle\AttributeAuthorizationBundle\Tests\Attribute;

use FK\Bundle\AttributeAuthorizationBundle\Source\Attribute\Authorize;

#[Authorize]
class TestWithAttributeClass
{
    public function methodNormal(): void
    {
        # No authorization
    }

    #[Authorize]
    public function methodAuthorize(): void
    {
        # Only ROLE_USER
    }

    #[Authorize('ROLE_ADMIN')]
    public function methodAuthorizeAdmin(): void
    {
        # Only ROLE_ADMIN
    }
}