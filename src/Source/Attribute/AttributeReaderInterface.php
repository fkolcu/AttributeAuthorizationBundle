<?php

namespace FK\Bundle\AttributeAuthorizationBundle\Source\Attribute;

use ReflectionException;

interface AttributeReaderInterface
{
    /**
     * If class or method has the expected attribute, it returns the instance of the attribute,
     * otherwise null
     *
     * @param string $attributeClassName
     * @param string $sourceClassName
     * @param string|null $sourceMethodName If method name is set, method's attribute is checked, otherwise,
     * attribute of source class is checked
     * @return object|false
     * @throws ReflectionException
     */
    public function has(string $attributeClassName, string $sourceClassName, string $sourceMethodName = null): object|false;
}