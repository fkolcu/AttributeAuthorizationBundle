<?php

namespace FK\Bundle\AttributeAuthorizationBundle\Source\Attribute;

class AttributeService implements AttributeServiceInterface
{
    private AttributeReaderInterface $attributeReader;

    public function __construct(AttributeReaderInterface $attributeReader)
    {
        $this->attributeReader = $attributeReader;
    }

    public function getAttribute(string $attributeClass, string $sourceClass, string $methodName): object|false
    {
        $methodAttribute = $this->attributeReader->has($attributeClass, $sourceClass, $methodName);
        if ($methodAttribute) {
            return $methodAttribute;
        }

        $classAttribute = $this->attributeReader->has($attributeClass, $sourceClass);
        if ($classAttribute) {
            return $classAttribute;
        }

        return false;
    }
}
