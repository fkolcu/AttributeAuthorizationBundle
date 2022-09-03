<?php

namespace spec\FK\Bundle\AttributeAuthorizationBundle\Source\Attribute;

use FK\Bundle\AttributeAuthorizationBundle\Source\Attribute\AttributeReaderInterface;
use FK\Bundle\AttributeAuthorizationBundle\Source\Attribute\AttributeService;
use FK\Bundle\AttributeAuthorizationBundle\Source\Attribute\AttributeServiceInterface;
use FK\Bundle\AttributeAuthorizationBundle\Source\Attribute\Authorize;
use PhpSpec\ObjectBehavior;

class AttributeServiceSpec extends ObjectBehavior
{
    function let(AttributeReaderInterface $attributeReader)
    {
        $this->beConstructedWith($attributeReader);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(AttributeService::class);
    }

    function it_should_implement_the_interface()
    {
        $this->shouldHaveType(AttributeServiceInterface::class);
    }

    function it_should_get_attribute_of_authorize_for_controller(AttributeReaderInterface $attributeReader, Authorize $authorize)
    {
        $attributeReader->has('AuthorizeClass', 'ClassWithAttribute', 'method')
            ->shouldBeCalledOnce()
            ->willReturn(false);

        $attributeReader->has('AuthorizeClass', 'ClassWithAttribute')
            ->shouldBeCalledOnce()
            ->willReturn($authorize);

        $result = $this->getAttribute('AuthorizeClass', 'ClassWithAttribute', 'method');
        $result->shouldHaveType(Authorize::class);
    }

    function it_should_get_attribute_of_authorize_for_method(AttributeReaderInterface $attributeReader, Authorize $authorize)
    {
        $attributeReader->has('AuthorizeClass', 'ClassWithoutAttribute', 'methodAuthorizeAdmin')
            ->shouldBeCalledOnce()
            ->willReturn($authorize);

        $attributeReader->has('AuthorizeClass', 'ClassWithoutAttribute')
            ->shouldNotBeCalled();

        $result = $this->getAttribute('AuthorizeClass', 'ClassWithoutAttribute', 'methodAuthorizeAdmin');
        $result->shouldHaveType(Authorize::class);
    }

    function it_should_return_false_when_no_attribute_found_for_neither_class_nor_method(AttributeReaderInterface $attributeReader)
    {
        $attributeReader->has('AuthorizeClass', 'ClassWithoutAttribute', 'methodNormal')
            ->shouldBeCalledOnce()
            ->willReturn(false);

        $attributeReader->has('AuthorizeClass', 'ClassWithoutAttribute')
            ->shouldBeCalledOnce()
            ->willReturn(false);

        $result = $this->getAttribute('AuthorizeClass', 'ClassWithoutAttribute', 'methodNormal');
        $result->shouldBeBoolean();
        $result->shouldBe(false);
    }
}
