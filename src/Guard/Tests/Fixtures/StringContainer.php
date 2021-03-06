<?php
/**
 * (c) PSP UK Group Ltd. <hello@psp-group.co.uk>
 *
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */

namespace Guard\Tests\Fixtures;

/**
 * A class used to test the DumpUtility.
 */
class StringContainer implements StringContainerInterface
{
    private $value;

    public function __construct($value)
    {
        $this->value = (string) $value;
    }

    public function __toString()
    {
        return $this->value;
    }
}
