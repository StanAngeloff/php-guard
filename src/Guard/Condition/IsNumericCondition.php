<?php
/**
 * (c) PSP UK Group Ltd. <hello@psp-group.co.uk>
 *
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */

namespace Guard\Condition;

use Guard\Exception\InvalidArgumentException;
use Guard\Utility\DumpUtility;

class IsNumericCondition implements ConditionInterface
{
    /** {@inheritdoc} */
    public function evaluate($value)
    {
        if (( ! is_numeric($value))) {
            throw new InvalidArgumentException(
                strtr(
                    'The value "{value}" is not numeric.',
                    array(
                        '{value}' => DumpUtility::export($value),
                    )
                ),
                1372596983
            );
        }
    }
}
