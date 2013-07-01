<?php
/**
 * (c) PSP UK Group Ltd. <hello@psp-group.co.uk>
 *
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */

namespace Guard\Condition;

use Guard\Exception\DomainException;
use Guard\Utility\DumpUtility;

class TypeOfCondition implements ConditionInterface
{
    /** {@inheritdoc} */
    public function evaluate($value, $type = null)
    {
        $actual = gettype($value);
        if (strcasecmp($actual, $type) !== 0) {
            throw new DomainException(
                strtr(
                    'The value "{value}" is expected to be of type "{type}", got "{actual}" instead.',
                    array(
                        '{value}' => DumpUtility::export($value),
                        '{type}' => $type,
                        '{actual}' => $actual,
                    )
                ),
                1372604324
            );
        }
    }
}
