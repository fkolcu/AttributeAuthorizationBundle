<?php

namespace spec\FK\Bundle\AttributeAuthorizationBundle\Source\Attribute;

use PhpSpec\ObjectBehavior;
use FK\Bundle\AttributeAuthorizationBundle\Source\Attribute\AttributeReader;
use FK\Bundle\AttributeAuthorizationBundle\Source\Attribute\AttributeReaderInterface;
use FK\Bundle\AttributeAuthorizationBundle\Source\Attribute\Authorize;
use FK\Bundle\AttributeAuthorizationBundle\Tests\Attribute\TestWithAttributeClass;
use FK\Bundle\AttributeAuthorizationBundle\Tests\Attribute\TestWithoutAttributeClass;

class AttributeReaderSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(AttributeReader::class);
    }

    function it_should_implement_the_interface()
    {
        $this->shouldHaveType(AttributeReaderInterface::class);
    }

    function it_should_receive_boolean_from_has_method()
    {
        $result = $this->has(Authorize::class, TestWithoutAttributeClass::class, 'methodNormal');
        $result->shouldBeBoolean();
    }

    function it_should_read_attribute_of_methods_in_a_class_without_attribute()
    {
        $result = $this->has(Authorize::class, TestWithoutAttributeClass::class, 'methodAuthorize');
        $result->shouldBe(true);

        $result = $this->has(Authorize::class, TestWithoutAttributeClass::class, 'methodNormal');
        $result->shouldBe(false);
    }

    function it_should_read_attribute_of_methods_in_a_class_with_attribute()
    {
        $result = $this->has(Authorize::class, TestWithAttributeClass::class, 'methodAuthorize');
        $result->shouldBe(true);

        $result = $this->has(Authorize::class, TestWithAttributeClass::class, 'methodNormal');
        $result->shouldBe(false);
    }

    function it_should_read_attribute_of_class()
    {
        $result = $this->has(Authorize::class, TestWithAttributeClass::class);
        $result->shouldBe(true);

        $result = $this->has(Authorize::class, TestWithoutAttributeClass::class);
        $result->shouldBe(false);
    }
}
