<?php
/**
 * (c) PSP UK Group Ltd. <hello@psp-group.co.uk>
 *
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */

namespace Guard\Utility;

final class DumpUtility
{
    /**
     * @codeCoverageIgnore
     */
    private function __construct()
    {
    }

    /**
     * Export a value suitable for use in exception messages.
     *
     * @var mixed $value
     * @return string
     */
    public static function export($value)
    {
        if (is_array($value)) {
            return '[Array]';
        } elseif (is_object($value)) {
            if (is_callable(array($value, '__toString'))) {
                return (string) $value;
            } else {
                return '[Object]';
            }
        }
        return var_export($value, true);
    }
}
