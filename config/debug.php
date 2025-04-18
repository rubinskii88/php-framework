<?php

if (!function_exists('d')) {
    function d(...$values): void
    {
        $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 3);
        $caller = null;

        // прохожу стек вызовов в поисках первого реального вызова пользователем
        foreach ($backtrace as $trace) {
            if (isset($trace['file']) && $trace['file'] !== __FILE__) {
                $caller = $trace;
                break;
            }
        }
        echo '<hr>';
        echo '<pre>';

        foreach ($values as $value) {
            var_dump($value);
        }

        if ($caller) {
            echo "Called in {$caller['file']} on line {$caller['line']}\n\n";
        } else {
            echo "Caller not found.\n\n";
        }

        echo '</pre>';
        echo '<hr>';
    }
}

if (!function_exists('dd')) {
    function dd(...$values): void
    {
        d(...$values);
        die(1);
    }
}