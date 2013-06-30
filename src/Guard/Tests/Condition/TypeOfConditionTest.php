<?php
/**
 * (c) PSP UK Group Ltd. <hello@psp-group.co.uk>
 *
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */

namespace Guard\Tests\Condition;

use Guard\Condition\TypeOfCondition;

final class TypeOfConditionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException Guard\Exception\InvalidArgumentException
     * @expectedExceptionMessage expected to be of type "integer", got "string" instead
     * @expectedExceptionCode 1372604324
     */
    public function testTypeOfConditionFailsWithWrongValue()
    {
        $this->newCondition()->evaluate('123', 'integer');
    }

    public function testTypeOfConditionSucceedsWithCorrectValue()
    {
        $this->newCondition()->evaluate(null, 'NULL');
        $this->newCondition()->evaluate(false, 'boolean');
        $this->newCondition()->evaluate(123, 'integer');
        $this->newCondition()->evaluate(123.123, 'double');
        $this->newCondition()->evaluate('123', 'string');
        $this->newCondition()->evaluate(array(), 'array');
        $this->newCondition()->evaluate(new \stdClass(), 'object');
    }

    private function newCondition()
    {
        return new TypeOfCondition();
    }
}
