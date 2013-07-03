<?php
/**
 * (c) PSP UK Group Ltd. <hello@psp-group.co.uk>
 *
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */

namespace Guard\Tests\Condition;

use Guard\Condition\IsNotEmptyCondition;

final class IsNotEmptyConditionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException Guard\Exception\InvalidArgumentException
     * @expectedExceptionMessage value "false" is empty
     * @expectedExceptionCode 1372871402
     */
    public function testIsNotEmptyConditionFailsWithEmptyValue()
    {
        $this->newCondition()->evaluate(false);
    }

    public function testIsNotEmptyConditionSucceedsWithNonEmptyValues()
    {
        $this->newCondition()->evaluate(true);
        $this->newCondition()->evaluate(array(false));
        $this->newCondition()->evaluate('string');
        $this->newCondition()->evaluate(new \stdClass());
    }

    private function newCondition()
    {
        return new IsNotEmptyCondition();
    }
}
