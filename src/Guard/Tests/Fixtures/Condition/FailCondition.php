<?php
/**
 * (c) PSP UK Group Ltd. <hello@psp-group.co.uk>
 *
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */

namespace Guard\Tests\Fixtures\Condition;

use Guard\Condition\ConditionInterface;

class FailCondition implements ConditionInterface
{
    /** {@inheritdoc} */
    public function evaluate($value)
    {
        throw new \RuntimeException('Failed.', 1372603373);
    }
}
