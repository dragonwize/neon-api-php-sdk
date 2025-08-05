<?php

declare(strict_types=1);

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$finder = new Finder()
    ->in(__DIR__)
    ->exclude('vendor');

return new Config()
    ->setRules([
        '@Symfony'                        => true,
        '@Symfony:risky'                  => true,
        '@PHP84Migration'                 => true,
        '@PHP82Migration:risky'           => true,
        '@PHPUnit91Migration:risky'       => true,
        'binary_operator_spaces'          => [
            'operators' => [
                '=>' => 'align_single_space_by_scope',
                '='  => 'align_single_space',
            ],
        ],
        'class_definition'                => [
            'single_line'                  => false,
            'inline_constructor_arguments' => false,
            'space_before_parenthesis'     => true,
        ],
        'concat_space'                    => ['spacing' => 'one'],
        'fully_qualified_strict_types'    => ['import_symbols' => true],
        'function_declaration'            => ['closure_fn_spacing' => 'one'],
        'method_argument_space'           => ['on_multiline' => 'ensure_fully_multiline'],
        'single_line_empty_body'          => true,
        'whitespace_after_comma_in_array' => ['ensure_single_space' => true],
        'yoda_style'                      => [
            'equal'            => false,
            'identical'        => false,
            'less_and_greater' => false,
        ],
    ])
    ->setRiskyAllowed(true)
    ->setFinder($finder);
