<?php

namespace spec\FK\Bundle\AttributeAuthorizationBundle\Source\Attribute;

use PhpSpec\ObjectBehavior;
use FK\Bundle\AttributeAuthorizationBundle\Source\Attribute\AttributeReader;
use FK\Bundle\AttributeAuthorizationBundle\Source\Attribute\AttributeReaderInterface;
use FK\Bundle\AttributeAuthorizationBundle\Source\Attribute\Authorize;
use FK\Bundle\AttributeAuthorizationBundle\Tests\Attribute\TestWithAttributeClass;
use FK\Bundle\AttributeAuthorizationBundle\Tests\Attribute\TestWithoutAttributeClass;
use Prophecy\Argument;

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

    function it_should_read_attribute_of_methods_in_a_class_without_attribute()
    {
        $result = $this->has(Authorize::class, TestWithoutAttributeClass::class, 'methodAuthorize');
        $result->shouldHaveType(Authorize::class);

        $result = $this->has(Authorize::class, TestWithoutAttributeClass::class, 'methodNormal');
        $result->shouldBeBoolean();
        $result->shouldBe(false);
    }

    function it_should_read_attribute_of_methods_in_a_class_with_attribute()
    {
        $result = $this->has(Authorize::class, TestWithAttributeClass::class, 'methodAuthorize');
        $result->shouldHaveType(Authorize::class);

        $result = $this->has(Authorize::class, TestWithAttributeClass::class, 'methodNormal');
        $result->shouldBeBoolean();
        $result->shouldBe(false);
    }

    function it_should_read_attribute_of_class()
    {
        $result = $this->has(Authorize::class, TestWithAttributeClass::class);
        $result->shouldHaveType(Authorize::class);

        $result = $this->has(Authorize::class, TestWithoutAttributeClass::class);
        $result->shouldBeBoolean();
        $result->shouldBe(false);
    }

    function it_should_read_roles_of_attributes()
    {
        $result = $this->has(Authorize::class, TestWithoutAttributeClass::class, 'methodAuthorize');
        $result->shouldHaveType(Authorize::class);
        $result->getRoles()->shouldBeArray();
        $result->getRoles()->shouldHaveCount(1);
        $result->getRoles()->shouldHaveKeyWithValue(0, 'ROLE_USER');

        $result = $this->has(Authorize::class, TestWithoutAttributeClass::class, 'methodAuthorizeAdminManager');
        $result->shouldHaveType(Authorize::class);
        $result->getRoles()->shouldBeArray();
        $result->getRoles()->shouldHaveCount(2);
        $result->getRoles()->shouldHaveKeyWithValue(0, 'ROLE_MANAGER');
        $result->getRoles()->shouldHaveKeyWithValue(1, 'ROLE_ADMIN');
    }
}
