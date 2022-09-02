<?php

namespace FK\Bundle\AttributeAuthorizationBundle\Tests\Attribute;

use FK\Bundle\AttributeAuthorizationBundle\Source\Attribute\Authorize;

class TestWithoutAttributeClass
{
    public function methodNormal(): void
    {
        # No authorization
    }

    #[Authorize]
    public function methodAuthorize(): void
    {
        # Only user
    }

    #[Authorize('ROLE_MANAGER', 'ROLE_ADMIN')]
    public function methodAuthorizeAdminManager(): void
    {
        # Only admin and manager
    }
}