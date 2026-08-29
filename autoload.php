<?php

spl_autoload_register(function (string $class): void {
    $class = ltrim($class, '\\');
    $file = __DIR__ . '/' . str_replace('\\', '/', $class) . '.php';

    if (is_file($file)) {
        require_once $file;
        return;
    }
    
    $prefix = 'src\\';
    if (strpos($class, $prefix) === 0) {
        $relative = substr($class, strlen($prefix));
        $path = __DIR__ . '/src/' . str_replace('\\', '/', $relative) . '.php';
        if (is_file($path)) {
            require_once $path;
        }
    }
});