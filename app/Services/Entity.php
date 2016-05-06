<?php

namespace App\Services;

class Entity
{
    /**
     * @var array|object $item
     */
    protected $item;
    /**
     * @var $rules
     */
    protected $rules;
    /**
     * @var
     */
    protected $messages;
    /**
     * @var
     */
    protected $attributes;
    /**
     * @var
     */
    protected $errors;
    /**
     * @var
     */
    protected $valid;

    /**
     * @return Entity
     */
    public static function create()
    {
        return new self();
    }

    /**
     * @param array:object $object
     * @return $this|bool
     */
    public function import($object)
    {
        if (!$object) return false;

        if (is_array($object)) {
            $this->attributes = $object;
        } else {
            foreach ($object->attribs as $it) {
                $this->attributes[$it->name] = $it->value;
            }
        }

        return $this;
    }

    /**
     * @param array $props
     * @return $this
     */
    public function setProperties($props)
    {
        foreach ($props as $item => $values) {
            $this->$item = $values;
        }
        return $this;
    }

    /**
     * @return bool
     */
    public function isValid()
    {
        return $this->valid === true;
    }

    /**
     * @return mixed
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @return mixed
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @param string $key
     * @return null|string
     */
    public function getAttributeByKey($key)
    {
        return isset($this->attributes[$key]) ? $this->attributes[$key] : null;
    }

    protected function pushError($key)
    {
        $this->errors[$key] = $this->messages[$key];
    }

    /**
     * @return bool
     */
    public function validate()
    {
        if (!$this->rules) return true;

        foreach ($this->rules as $field => $rule) {
            if (isset($this->attributes[$field])) {
                if (!$rule['null'] && $this->attributes[$field] === null) {
                    $this->pushError($field);
                } else {
                    if (strlen($rule['rule']) > 0 && !preg_match($rule['rule'], $this->attributes[$field])) {
                        $this->pushError($field);
                    }
                }
            } else {
                $this->pushError($field);
            }
        }

        return $this->valid = count($this->errors) > 0 ? false : true;
    }
}