<?php
/**
 * (c) PSP UK Group Ltd. <hello@psp-group.co.uk>
 *
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */

namespace Guard\Tests\Utility;

use Guard\Tests\Fixtures\StringContainer;

use Guard\Utility\DumpUtility;

final class DumpUtilityTest extends \PHPUnit_Framework_TestCase
{
    public function testExport()
    {
        $this->assertEquals(
            DumpUtility::export('string'),
            var_export('string', true)
        );
        $this->assertEquals(
            DumpUtility::export(123),
            var_export(123, true)
        );
        $this->assertEquals(
            DumpUtility::export(array()),
            '[Array]'
        );
        $this->assertEquals(
            DumpUtility::export(new \stdClass),
            '[Object]'
        );
        $this->assertEquals(
            DumpUtility::export(new StringContainer('string')),
            'string'
        );
    }
}
