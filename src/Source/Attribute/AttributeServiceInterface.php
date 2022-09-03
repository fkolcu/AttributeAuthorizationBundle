<?php

namespace FK\Bundle\AttributeAuthorizationBundle\Source\Attribute;

use ReflectionException;

interface AttributeServiceInterface
{
    /**
     * @param string $attributeClass
     * @param string $sourceClass
     * @param string $methodName
     * @return object|false
     * @throws ReflectionException
     */
    public function getAttribute(string $attributeClass, string $sourceClass, string $methodName): object|false;
}