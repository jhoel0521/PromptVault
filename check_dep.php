<?php

require __DIR__.'/vendor/autoload.php';

try {
    if (class_exists('LucianoTonet\GroqPHP\Groq')) {
        echo "Dependency loaded correctly.\n";
    } else {
        echo "ERROR: LucianoTonet\GroqPHP\Groq class not found. Please run 'composer require lucianotonet/groq-php'.\n";
    }
} catch (Throwable $e) {
    echo 'Error checking dependency: '.$e->getMessage()."\n";
}
