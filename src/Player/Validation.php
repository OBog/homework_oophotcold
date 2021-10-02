<?php

namespace Player;

class Validation
{
    private $errors = [];

    public function setErrors(array $errors): void
    {
        $this->errors = $errors;
    }

    public function getErrors($value): array {

        $value = is_numeric($value) ? (int) $value : $value;
        $this->errors=[];
        if(!$value && $value!=0){
            $this->errors[] = 'empty value';
        } else if(is_string($value)){
            $this->errors[] = 'value is not Integer';
        }
        return $this->errors;
    }

    public function isValidName($value): array {
        $this->errors=[];
        if(!$value && $value!=0){
            $this->errors[] = 'empty value';
        } else if(!is_string($value) || is_numeric($value)){
            $this->errors[] = 'value is not string';
        }
        return $this->errors;
    }
}