<?php
/**
 * (c) PSP UK Group Ltd. <hello@psp-group.co.uk>
 *
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */

namespace Guard\Condition;

use Guard\Exception\ClassNotFoundException;
use Guard\Exception\DomainException;

class InstanceOfCondition extends TypeOfCondition
{
    /** {@inheritdoc} */
    public function evaluate($value, $className = null)
    {
        parent::evaluate($value, 'object');
        try {
            $reflect = new \ReflectionClass($className);
        } catch (\ReflectionException $previous) {
            throw new ClassNotFoundException(
                strtr(
                    'The expected class "{class}" does not exist.',
                    array(
                        '{class}' => $className,
                    )
                ),
                1372703392,
                $previous
            );
        }
        if (( ! $reflect->isInstance($value))) {
            throw new DomainException(
                strtr(
                    'The object of class "{actual}" is not an instance of "{class}".',
                    array(
                        '{actual}' => get_class($value),
                        '{class}' => $className,
                    )
                ),
                1372702934
            );
        }
    }
}
