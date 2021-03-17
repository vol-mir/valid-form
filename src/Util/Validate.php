<?php


namespace App\Util;

class Validate
{
    protected const LIST_ERRORS = [
        'required' => 'The value must not be empty',
        'numeric' => 'The value must be numeric',
        'integer' => 'The value must be integer',
        'float' => 'The value must be float',
        'min_val' => 'The value must have min :value',
        'min_length' => 'The value must have min length :value',
        'max_length' => 'The value must have max length :value',
        'email' => 'The value must be email',
        'confirm' => 'Password mismatch',
    ];

    protected const NOT_RULES = 'No exist valid rule ';

    protected $vars = [];
    protected $rules = [];
    protected $errors = [];

    /**
     * constructor
     *
     * @param array $vars array to validate
     */
    public function __construct(array $vars)
    {
        $this->vars = $vars;
    }

    /**
     * expect - set rules for vars
     *
     * @param $key
     * @param $set_rules for the value, for example numeric, string, min, max and so forth
     */
    public function expect($key, $set_rules): void
    {
        $this->rules[$key] = $set_rules;
    }

    /**
     * getErrors
     *
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * validate
     *
     * @return bool
     */
    public function validate(): bool
    {
        $result = true;

        // reset the array of errors
        $this->errors = [];

        foreach ($this->rules as $key => $set_rules) {
            $rules = explode("|", $set_rules);

            foreach ($rules as $rule) {
                $rule_value = "";
                if (strpos($rule, "=")) {
                    [$rule, $rule_value] = explode("=", $rule);
                }

                $func = strtolower(trim($rule));

                if (!method_exists($this, $func)) {
                    $this->errors['error'][] = self::NOT_RULES . $func;
                    $result = false;
                    continue;
                }

                if ($func === 'confirm') {
                    $flag = $this->$func($this->vars[$key], $this->vars['password_confirm']);
                } elseif ($rule_value) {
                    $flag = $this->$func($this->vars[$key], $rule_value);
                } else {
                    $flag = $this->$func($this->vars[$key]);
                }

                if (!$flag) {
                    $this->errors[$key][] = $this->getErrorForList($func, $rule_value);
                    $result = false;
                }
            }
        }

        return $result;
    }

    /**
     * getErrorForList - get item error for list
     *
     * @param $key
     * @param $value
     * @return string
     */
    protected function getErrorForList($key, $value): string
    {
        return str_replace(':value', $value, self::LIST_ERRORS[$key]);
    }

    protected function email($input)
    {
        return filter_var($input, FILTER_VALIDATE_EMAIL);
    }

    protected function min_val($input, $value): bool
    {
        return ($input >= $value);
    }

    protected function min_length($input, $length): bool
    {
        return (strlen($input) >= $length);
    }

    protected function max_length($input, $length): bool
    {
        return (strlen($input) <= $length);
    }

    protected function confirm($input, $input_confirm): bool
    {
        return ($input === $input_confirm);
    }

    protected function required($input = null): bool
    {
        return (!is_null($input) && (trim($input) !== ''));
    }

    protected function numeric($input): bool
    {
        return is_numeric($input);
    }

    protected function integer($input): bool
    {
        return is_int($input) || ($input === (string)(int)$input);
    }

    protected function float($input): bool
    {
        return is_float($input) || ($input === (string)(float)$input);
    }
}