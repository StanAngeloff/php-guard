<?php
/**
 * (c) PSP UK Group Ltd. <hello@psp-group.co.uk>
 *
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */

namespace Guard\Tests\Condition;

use Guard\Condition\IsNotNullCondition;

final class IsNotNullConditionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException Guard\Exception\InvalidArgumentException
     * @expectedExceptionMessage value is NULL
     * @expectedExceptionCode 1372704749
     */
    public function testIsNotNullConditionFailsWithNullValue()
    {
        $this->newCondition()->evaluate(null);
    }

    public function testIsNotNullConditionSucceedsWithNotNullValues()
    {
        $this->newCondition()->evaluate(false);
        $this->newCondition()->evaluate(array());
        $this->newCondition()->evaluate('');
        $this->newCondition()->evaluate(new \stdClass());
    }

    private function newCondition()
    {
        return new IsNotNullCondition();
    }
}
