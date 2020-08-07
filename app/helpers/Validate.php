<?php

namespace helpers;

/**
 *A USEFUL HELPER CLASS TO PERFORM VALIDATION
 */
class Validate {
  private $_passed = false,
    $_errors = [];
  private $customFunctionCallback;

  private $messageSet = [];

  function __construct($source = [], $ruleSet = [], $messageSet = []) {
    $this->customFunctionCallback = function () {
      return false;
    };

    $this->check($source, $ruleSet, $messageSet);
  }

  public function check($source, $ruleSet = [], $messageSet = []) {

    $this->messageSet = $messageSet;

    foreach ($ruleSet as $item => $rules) {
      foreach ($rules as $rule => $rule_value) {
        $value = isset($source[$item]) ? trim($source[$item]) : '';
        if ($rule === 'message') {
          continue;
        }

        if ($rule === 'required' && $rule_value) {
          if (empty($value)) {

            $customFunctionMessage = $this->checkMessage($item, 'required') ? $this->getMessage($item, 'required') : 'Required field.';
            $this->addError($item, $customFunctionMessage);
          }
          // $this->addError($item, "Required field.");
        } else if (!empty($value)) {
          switch ($rule) {
            case 'min':
              if (strlen($value) < $rule_value) {
                $customFunctionMessage = $this->checkMessage($item, $rule) ? $this->getMessage($item, $rule) : "Must be a minimum of {$rule_value} characters.";
                $this->addError($item, $customFunctionMessage);
              }
              break;
            case 'max':
              if (strlen($value) > $rule_value) {
                $customFunctionMessage = $this->checkMessage($item, $rule) ? $this->getMessage($item, $rule) : "Must be a maximum of {$rule_value} characters.";
                $this->addError($item, $customFunctionMessage);
              }
              break;
            case 'matches':
              if ($value != $source[$rule_value]) {
                $customMessage = $this->checkMessage($item, $rule) ? $this->getMessage($item, $rule) : "" . ucwords($rule_value) . " must match " . str_replace('_', ' ', $item) . ".";
                $this->addError($item, $customMessage);
              }
              break;
            case 'alpha':
              if (!(bool) preg_match('/^[\pL\pM]+$/u', $value)) {
                $customMessage = $this->checkMessage($item, $rule) ? $this->getMessage($item, $rule) : "Can only contain alphabets.";
                $this->addError($item, $customMessage);
              }
              break;
            case 'string':
            case 'alphanumeric':
              if ((bool) preg_match('/[^0-9a-z _\.,\(\)\'\"-]+/iu', $value)) {
                $customMessage = $this->checkMessage($item, $rule) ? $this->getMessage($item, $rule) : "Can not contain special characters.";
                $this->addError($item, $customMessage);
              }
              break;
            case 'regex':
              if (!(bool) preg_match($rule_value, $value)) {
                $customMessage = $this->checkMessage($item, $rule) ? $this->getMessage($item, $rule) : "Failed to match pattern.";
                $this->addError($item, $customMessage);
              }
              break;
            case 'number':
              if (!is_numeric($value)) {
                $customMessage = $this->checkMessage($item, $rule) ? $this->getMessage($item, $rule) : "Can only contain numbers.";
                $this->addError($item, $customMessage);
              }
              break;
            case 'email':
              if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                $customMessage = $this->checkMessage($item, $rule) ? $this->getMessage($item, $rule) : "Must be an email";
                $this->addError($item, $customMessage);
              }
              break;
            case 'customFunction':
              if (!call_user_func($rule_value ?? $this->customFunctionCallback, $value, $item, $value)) {
                $customFunctionMessage = $this->checkMessage($item, $rule) ? $this->getMessage($item, $rule) : "Field already exist in the database";
                $this->addError($item, $customFunctionMessage);
              }
              break;
              // case 'file':
              // 	$check = $this->_db->get($rule_value, [$item, '=', $value]);
              // 	if($check->count()){
              // 		$this->addError($item, "Field already exist in the database");
              // 	}
              // break;
            default:
              $this->addError($item, "Validation rule ('{$rule}') doesn't exist");
          }
        }
      }
    }
    if (empty($this->_errors)) {
      $this->_passed = true;
    }
    return $this;
  }

  private function checkMessage($fieldName, $rule): bool {
    if (!count($this->messageSet)) {
      return false;
    }

    if (!isset($this->messageSet[$fieldName])) {
      return false;
    }

    if (!isset($this->messageSet[$fieldName][$rule])) {
      return false;
    }

    return true;
  }

  private function getMessage($fieldName, $rule): string {
    return $this->messageSet[$fieldName][$rule];
  }

  public function customFunction($callback) {
    $this->customFunctionCallback = $callback;
  }
  private function addError($field, $error) {
    $this->_errors[$field][] = $error;
  }

  public function errors() {
    return $this->_errors;
  }
  public function passed(): bool {
    return $this->_passed;
  }
}
