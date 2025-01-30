<?php

  function my_autoloader($class){

    $class = strtolower($class);
    $path = "./src/config/init.php";

    if(file_exists($path)){
      include($path);
    }else{
      die("This file name {$class}.php does not exist...");
    }

  }

  spl_autoload_register('my_autoloader');