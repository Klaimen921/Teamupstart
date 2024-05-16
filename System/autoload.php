<?php
function autoloader($className) {
    $className = str_replace("\\","/", $className);
    include __DIR__ . '/../'. $className .'.php';
}
spl_autoload_register('autoloader');