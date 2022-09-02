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
}