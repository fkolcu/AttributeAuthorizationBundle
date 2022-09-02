<?php

namespace FK\Bundle\AttributeAuthorizationBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class AttributeAuthorizationBundle extends Bundle
{
    public const AUTH_HEADER_KEY = 'Authorization';

    public const BUNDLE_SERVICE_PREFIX = 'fk_attribute_authorization_bundle';
}