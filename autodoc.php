<?php
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', true);

require 'Noder.php';


$class = new ReflectionClass('Noder'); 
$methods = $class->getMethods(); 
foreach ($methods as $method) {
    echo $method;
}
