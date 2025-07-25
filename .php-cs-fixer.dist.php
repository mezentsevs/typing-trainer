<?php

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$finder = Finder::create()
    ->exclude('vendor')
    ->exclude('storage')
    ->exclude('bootstrap/cache')
    ->notPath(['public/adminer.php'])
    ->in(__DIR__);

return (new Config())
    ->setRules([
        '@PSR12' => true,
        '@PHP84Migration' => true,
        'strict_param' => true,
        'array_syntax' => ['syntax' => 'short'],
        'declare_strict_types' => false,
        'binary_operator_spaces' => [
            'default' => 'single_space',
            'operators' => ['=>' => 'single_space'],
        ],
        'trim_array_spaces' => true,
        'no_whitespace_before_comma_in_array' => true,
        'whitespace_after_comma_in_array' => true,
    ])
    ->setFinder($finder)
    ->setRiskyAllowed(true)
    ->setUsingCache(true);
