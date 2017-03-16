<?php

spl_autoload_register(
    function ($class) use ($root) {
        $class = str_replace('\\', '/', $class);
        $file = $root . 'class/' . $class . '.class.php';

        if (!file_exists($file)) {
            return false;
        }

        require_once($file);

        return true;
    }
);
