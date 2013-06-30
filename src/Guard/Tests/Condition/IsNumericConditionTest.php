<?php
/**
 * (c) PSP UK Group Ltd. <hello@psp-group.co.uk>
 *
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */

namespace Guard\Tests\Condition;

use Guard\Condition\IsNumericCondition;

final class IsNumericConditionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException Guard\Exception\InvalidArgumentException
     * @expectedExceptionCode 1372596983
     */
    public function testIsNumericConditionFailsWithStringValue()
    {
        $this->newCondition()->evaluate('value', array());
    }

    public function testIsNumericConditionSucceedsWithNumericValue()
    {
        $this->newCondition()->evaluate(123, array());
    }

    private function newCondition()
    {
        return new IsNumericCondition();
    }
}
