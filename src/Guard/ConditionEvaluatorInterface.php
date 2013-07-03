<?php
/**
 * (c) PSP UK Group Ltd. <hello@psp-group.co.uk>
 *
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */

namespace Guard;

interface ConditionEvaluatorInterface
{
    /**
     * Evaluate a condition by name with the given arguments.
     *
     * @param string $name The condition name.
     * @param array $arguments The condition arguments.
     * @return self
     *
     * @throws \Exception If the condition fails.
     */
    public function evaluateCondition($name, array $arguments = array());
}
