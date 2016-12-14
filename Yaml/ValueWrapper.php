<?php

namespace Fgms\Yaml;

class ValueWrapper extends \Fgms\ValueWrapper\ValueWrapperImpl
{
    private $yaml;

    public function __construct($obj, $yaml, $path = '')
    {
        parent::__construct($obj,$path);
        $this->yaml = $yaml;
    }

    public function raiseMissing($key)
    {
        throw new Exception\MissingException(
            $this->join($key),
            $this->yaml
        );
    }

    public function raiseTypeMismatch($key, $expected, $actual)
    {
        throw new Exception\TypeMismatchException(
            $expected,
            $actual,
            $this->join($key),
            $this->yaml
        );
    }

    public function wrapImpl($key, $value)
    {
        return new self($value,$this->yaml,$this->join($key));
    }
}
