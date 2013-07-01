<?php
/**
 * (c) PSP UK Group Ltd. <hello@psp-group.co.uk>
 *
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */

namespace Guard\Tests\Fixtures;

/**
 * A StringContainer derived class used to test for inheritance in the InstanceOfCondition.
 */
final class FixedStringContainer extends StringContainer
{
    public function __construct()
    {
        parent::__construct('fixed');
    }
}
