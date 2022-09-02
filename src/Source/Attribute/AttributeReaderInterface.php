<?php

namespace FK\Bundle\AttributeAuthorizationBundle\Source\Attribute;

use ReflectionException;

interface AttributeReaderInterface
{
    /**
     * @param string $attributeClassName
     * @param string $sourceClassName
     * @param string|null $sourceMethodName If method name is set, method's attribute is checked, otherwise,
     * attribute of source class is checked
     * @return bool
     * @throws ReflectionException
     */
    public function has(string $attributeClassName, string $sourceClassName, string $sourceMethodName = null): bool;
}