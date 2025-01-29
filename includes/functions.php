<?php

  function validateField($field, $name, $required = true, $regex = null, $maxLength = null, $minLength = null){
    if($required && $field === null || $field === false){
      return "Pole '{$name}' jest wymagane.";
    }
    if($regex && !preg_match($regex, $field)){
      return "Pole '{$name}' ma nieprawidłowy format.";
    }
    if($maxLength && strlen($field) > $maxLength){
      return "Pole '{$name}' przekracza maksymalną długość {$maxLength} znaków.";
    }
    if($minLength && strlen($field) <= $minLength){
      return "Pole '{$name}' nie przekracza minimalnej długości {$maxLength} znaków.";
    }
    return null;
  }

  function validPasswordAndPlainPassword($password, $plainPassword){
    if($password !== $plainPassword){
      return "Hasła muszą być takie same.";
    }
    return null;
  }
