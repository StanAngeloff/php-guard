<?php
/**
 * (c) PSP UK Group Ltd. <hello@psp-group.co.uk>
 *
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */

namespace Guard\Condition;

use Guard\Exception\InvalidArgumentException;

class IsNotNullCondition implements ConditionInterface
{
    /** {@inheritdoc} */
    public function evaluate($value)
    {
        if ($value === null) {
            throw new InvalidArgumentException(
                'The value is NULL.',
                1372704749
            );
        }
    }
}
