<?php

namespace FK\Bundle\AttributeAuthorizationBundle\Source\Attribute;

use ReflectionAttribute;
use ReflectionClass;
use ReflectionException;

class AttributeReader implements AttributeReaderInterface
{
    /**
     * @inheritDoc
     */
    public function has(string $attributeClassName, string $sourceClassName, string $sourceMethodName = null): bool
    {
        $attributes = $this->getAttributes($sourceClassName, $sourceMethodName);
        foreach ($attributes as $attribute) {
            if ($attribute->getName() === $attributeClassName) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return ReflectionAttribute[]
     * @throws ReflectionException
     */
    private function getAttributes(string $className, string $methodName = null): array
    {
        $reflection = new ReflectionClass("$className");

        if (isset($methodName)) {
            $method = $reflection->getMethod($methodName);
            return $method->getAttributes();
        }

        return $reflection->getAttributes();
    }
}
