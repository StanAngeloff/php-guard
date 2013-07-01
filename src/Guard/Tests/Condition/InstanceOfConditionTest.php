<?php
/**
 * (c) PSP UK Group Ltd. <hello@psp-group.co.uk>
 *
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */

namespace Guard\Tests\Condition;

use Guard\Tests\Fixtures\StringContainer;

use Guard\Condition\InstanceOfCondition;

final class InstanceOfConditionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException Guard\Exception\DomainException
     * @expectedExceptionMessage expected to be of type "object", got "string" instead
     * @expectedExceptionCode 1372604324
     */
    public function testInstanceOfConditionFailsWithWrongValue()
    {
        $this->newCondition()->evaluate('123', 'A\\B\\C');
    }

    /**
     * @expectedException Guard\Exception\ClassNotFoundException
     * @expectedExceptionMessage class "A\B\C" does not exist
     * @expectedExceptionCode 1372703392
     */
    public function testInstanceOfConditionFailsWithMissingClass()
    {
        $this->newCondition()->evaluate(
            new \stdClass(),
            'A\\B\\C'
        );
    }

    /**
     * @expectedException Guard\Exception\DomainException
     * @expectedExceptionMessage class "stdClass" is not an instance of "Guard\Tests\Fixtures\StringContainer"
     * @expectedExceptionCode 1372702934
     */
    public function testInstanceOfConditionFailsWithWrongObject()
    {
        $this->newCondition()->evaluate(
            new \stdClass(),
            'Guard\\Tests\\Fixtures\\StringContainer'
        );
    }

    public function testInstanceOfConditionSucceedsWithCorrectObject()
    {
        $this->newCondition()->evaluate(
            new StringContainer('string'),
            'Guard\\Tests\\Fixtures\\StringContainer'
        );
    }

    public function testInstanceOfConditionSucceedsWithLeadingSlash()
    {
        $this->newCondition()->evaluate(
            new StringContainer('string'),
            '\\Guard\\Tests\\Fixtures\\StringContainer'
        );
    }

    private function newCondition()
    {
        return new InstanceOfCondition();
    }
}
