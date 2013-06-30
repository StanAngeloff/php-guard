<?php
/**
 * (c) PSP UK Group Ltd. <hello@psp-group.co.uk>
 *
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */

namespace Guard\Tests;

use Guard\Tests\Fixtures\Condition\NoOperationCondition;

use Guard\Conditions;

final class ConditionsTest extends \PHPUnit_Framework_TestCase
{
    public function testTemplates()
    {
        $templates = Conditions::getTemplates();
        $this->assertGreaterThan(
            0,
            sizeof($templates),
            'expect at least one condition class template to get registered by default'
        );

        Conditions::addTemplate($template = 'A\\B\\{class}C');
        $templates2 = Conditions::getTemplates();
        $this->assertGreaterThan(
            sizeof($templates),
            sizeof($templates2),
            'expect added template to change the length of the registed templates'
        );
        $this->assertContains(
            $template,
            $templates2,
            'expect added template to be in the list of registered templates'
        );

        Conditions::removeTemplate($template);
        $templates2 = Conditions::getTemplates();
        $this->assertEquals(
            sizeof($templates),
            sizeof($templates2),
            'expect removed template to change the length of the registed templates'
        );
        $this->assertNotContains(
            $template,
            $templates2,
            'expect removed template to no longer be present in the list of registered templates'
        );
    }

    public function testGettersSetters()
    {
        $condition = Conditions::requires($value = 'value', $argumentName = 'argument');
        $this->assertEquals($value, $condition->getValue());
        $this->assertEquals($argumentName, $condition->getArgumentName());

        $condition->setValue($value = 'value2');
        $condition->setArgumentName($argumentName = 'argument2');
        $this->assertEquals($value, $condition->getValue());
        $this->assertEquals($argumentName, $condition->getArgumentName());
    }

    public function testCreateConditionIsCached()
    {
        $mock = $this->getMockBuilder('Guard\\Conditions')
            ->disableOriginalConstructor()
            ->setMethods(array('createConditionFromTemplates'))
            ->getMock();

        $mock->expects($this->once())
            ->method('createConditionFromTemplates')
            ->will(
                $this->returnValue(
                    new NoOperationCondition()
                )
            );

        $mock->noOperation();
        $mock->noOperation();
    }

    /**
     * @expectedException Guard\Exception\NoSuchConditionException
     * @expectedExceptionCode 1372596521
     */
    public function testCreateConditionFailsWhenNoSuchCondition()
    {
        Conditions::requires('value', 'argument')->noSuchCondition();
    }

    /**
     * @expectedException Guard\Exception\LogicException
     * @expectedExceptionCode 1372596698
     */
    public function testCreateConditionFailsWhenConditionDoesNotImplementInterface()
    {
        $mock = $this->getMockBuilder('Guard\\Conditions')
            ->disableOriginalConstructor()
            ->setMethods(array('createConditionFromTemplates'))
            ->getMock();

        $mock->expects($this->any())
            ->method('createConditionFromTemplates')
            ->will(
                $this->returnValue(
                    new \stdClass()
                )
            );

        $mock->operation();
    }

    public function testExceptionsAreWrapped()
    {
        Conditions::addTemplate('Guard\\Tests\\Fixtures\\Condition\\{name}Condition');
        try {
            Conditions::requires('value', 'argument')->fail();
        } catch (\Exception $e) {
            $this->assertInstanceOf(
                'Guard\\Exception\\ConditionEvaluationException',
                $e,
                'expect exception to be wrapped'
            );
            $this->assertInstanceOf(
                'RuntimeException',
                $e->getPrevious(),
                'expect previous exception to be available'
            );
            return;
        }
        $this->fail('expect exception to be raised');
    }
}
