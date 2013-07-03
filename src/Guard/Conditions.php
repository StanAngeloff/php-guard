<?php
/**
 * (c) PSP UK Group Ltd. <hello@psp-group.co.uk>
 *
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */

namespace Guard;

use Guard\Condition\ConditionInterface;
use Guard\Exception\ConditionEvaluationException;
use Guard\Exception\LogicException;
use Guard\Exception\NoSuchConditionException;

/**
 * @SuppressWarnings(PHPMD.LongVariableNames)
 */
class Conditions implements ConditionEvaluatorInterface
{
    /**
     * A list of cached condition class instances by name.
     *
     * @var ConditionInterface[string]
     */
    protected static $conditions = array();

    /**
     * The templates used to create condition class instances.
     *
     * @var string[]
     */
    protected static $conditionClassTemplates = array(
        '\\{namespace}\\Condition\\{name}Condition'
    );

    /**
     * The argument value.
     *
     * @var mixed
     */
    protected $value;

    /**
     * The argument name.
     *
     * @var string
     */
    protected $argumentName;

    /**
     * Initialize a new instance of Conditions.
     *
     * @param mixed $value The argument value.
     * @param string $argumentName The argument name.
     */
    protected function __construct($value, $argumentName)
    {
        $this->setValue($value);
        $this->setArgumentName($argumentName);
    }

    /**
     * Initialize a new instance of Conditions.
     *
     * @param mixed $value The argument value.
     * @param string $argumentName The argument name.
     */
    public static function requires($value, $argumentName)
    {
        return new static($value, $argumentName);
    }

    /**
     * Get the registered condition class templates.
     *
     * @return string[]
     */
    public static function getTemplates()
    {
        return self::$conditionClassTemplates;
    }

    /**
     * Add a condition class template.
     *
     * @param string $classTemplate The class template to add.
     * @return void
     */
    public static function addTemplate($classTemplate)
    {
        self::$conditionClassTemplates[] = $classTemplate;
    }

    /**
     * Remove a condition class template.
     *
     * @param string $classTemplate The class template to remove.
     * @return void
     */
    public static function removeTemplate($classTemplate)
    {
        $result = array();
        foreach (self::$conditionClassTemplates as $existingTemplate) {
            if (strcmp($existingTemplate, $classTemplate) !== 0) {
                $result[] = $existingTemplate;
            }
        }
        self::$conditionClassTemplates = $result;
    }

    # {{{ Getters/Setters

    /**
     * Get the argument value.
     *
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set the argument value.
     *
     * @param mixed $value
     * @return void
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * Get argument name.
     *
     * @return string
     */
    public function getArgumentName()
    {
        return $this->argumentName;
    }

    /**
     * Set argument name.
     *
     * @param string $argumentName
     * @return self
     */
    public function setArgumentName($argumentName)
    {
        $this->argumentName = $argumentName;
        return $this;
    }

    # }}}

    /**
     * Invoke a condition when a missing method is called on this object.
     *
     * @param string $name The missing method name, i.e., the condition.
     * @param array $arguments The condition arguments.
     * @return self
     *
     * @throws \Exception If the condition fails.
     *
     * @see ConditionEvaluatorInterface::evaluateCondition()
     */
    public function __call($name, array $arguments)
    {
        return $this->evaluateCondition($name, $arguments);
    }

    # {{{ ConditionEvaluatorInterface

    /** {@inheritdoc} */
    public function evaluateCondition($name, array $arguments = array())
    {
        $condition = $this->createCondition($name);
        try {
            call_user_func_array(
                array($condition, 'evaluate'),
                array_merge(
                    array($this->getValue()),
                    $arguments
                )
            );
        } catch (\Exception $previous) {
            throw new ConditionEvaluationException(
                strtr(
                    'The condition "{name}" for argument "{argument}" failed to evaluate.',
                    array(
                        '{name}' => $name,
                        '{argument}' => $this->getArgumentName(),
                    )
                ),
                1372597122,
                $previous
            );
        }
        return $this;
    }

    # }}}

    /**
     * Create a condition class instance by name.
     *
     * @param string $name The condition name.
     * @return ConditionInterface
     */
    protected function createCondition($name)
    {
        if (isset (self::$conditions[$name])) {
            return self::$conditions[$name];
        }
        $condition = $this->createConditionFromTemplates(
            $name,
            self::$conditionClassTemplates
        );
        if (isset ($condition)) {
            if (( ! $condition instanceof ConditionInterface)) {
                throw new LogicException(
                    strtr(
                        'The condition "{name}" defined in class "{class}" ' .
                        'does not implement the required interface "ConditionInterface".',
                        array(
                            '{name}' => $name,
                            '{class}' => get_class($condition),
                        )
                    ),
                    1372596698
                );
            }
            self::$conditions[$name] = $condition;
            return $condition;
        }
        throw new NoSuchConditionException(
            strtr(
                'The condition "{name}" is not defined.',
                array(
                    '{name}' => $name,
                )
            ),
            1372596521
        );
    }

    /**
     * @see createCondition
     */
    protected function createConditionFromTemplates($name, array $templates)
    {
        foreach ($templates as $classTemplate) {
            $conditionClass = strtr(
                $classTemplate,
                array(
                    '{namespace}' => __NAMESPACE__,
                    '{name}' => ucfirst($name),
                )
            );
            if (( ! class_exists($conditionClass))) {
                continue;
            }
            $instance = new $conditionClass();
            return $instance;
        }
        return null;
    }
}
