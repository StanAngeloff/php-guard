<?php
/**
 * (c) PSP UK Group Ltd. <hello@psp-group.co.uk>
 *
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */

namespace Guard;

interface ConditionEvaluatorContainerInterface
{
    /**
     * Set the ConditionEvaluatorInterface instance associated with this object.
     *
     * @param ConditionEvaluatorInterface $evaluator
     * @return void
     */
    public function setConditionEvaluator(ConditionEvaluatorInterface $evaluator);
}
