import vueParser from 'vue-eslint-parser';
import eslintPluginVue from 'eslint-plugin-vue';
import eslintPluginImport from 'eslint-plugin-import';
import eslintPluginPromise from 'eslint-plugin-promise';
import globals from 'globals';
import tsParser from '@typescript-eslint/parser';
import babelParser from '@babel/eslint-parser';
import tsPlugin from '@typescript-eslint/eslint-plugin';

export default [
    {
        ignores: [
            'dist/**',
            'node_modules/**',
            'public/**'
        ]
    },

    {
        files: ['**/*.vue'],
        languageOptions: {
            ecmaVersion: 2025,
            sourceType: 'module',
            globals: globals.browser,
            parser: vueParser,
            parserOptions: {
                parser: {
                    js: babelParser,
                    ts: tsParser
                },
                requireConfigFile: false,
                ecmaFeatures: {
                    jsx: true
                }
            }
        },
        plugins: {
            vue: eslintPluginVue
        },
        rules: {
            'vue/html-self-closing': ['error', {
                html: {
                    void: 'never',
                    normal: 'always',
                    component: 'always'
                }
            }],
            'vue/attributes-order': ['error', {
                order: [
                    'DEFINITION',
                    'LIST_RENDERING',
                    'CONDITIONALS',
                    'RENDER_MODIFIERS',
                    'GLOBAL',
                    'UNIQUE',
                    'TWO_WAY_BINDING',
                    'OTHER_DIRECTIVES',
                    'OTHER_ATTR',
                    'EVENTS',
                    'CONTENT'
                ],
                alphabetical: false
            }],
            'vue/order-in-components': ['error', {
                order: [
                    'el',
                    'name',
                    'key',
                    'parent',
                    'functional',
                    ['delimiters', 'comments'],
                    ['components', 'directives', 'filters'],
                    'extends',
                    'mixins',
                    ['provide', 'inject'],
                    'ROUTER_GUARDS',
                    'layout',
                    'middleware',
                    'validate',
                    'scrollToTop',
                    'transition',
                    'loading',
                    'inheritAttrs',
                    'model',
                    ['props', 'propsData'],
                    'emits',
                    'setup',
                    'asyncData',
                    'data',
                    'fetch',
                    'head',
                    'computed',
                    'watch',
                    'watchQuery',
                    'methods',
                    ['template', 'render'],
                    'renderError'
                ]
            }]
        }
    },

    {
        files: ['**/*.ts'],
        languageOptions: {
            ecmaVersion: 2025,
            sourceType: 'module',
            globals: {
                ...globals.browser,
                ...globals.node
            },
            parser: tsParser,
            parserOptions: {
                project: './tsconfig.json'
            }
        },
        plugins: {
            '@typescript-eslint': tsPlugin,
            import: eslintPluginImport,
            promise: eslintPluginPromise
        },
        rules: {
            '@typescript-eslint/no-unused-vars': ['warn', { argsIgnorePattern: '^_' }],
            '@typescript-eslint/no-explicit-any': 'warn',
            'no-console': 'warn',
            'import/order': [
                'error',
                {
                    groups: ['builtin', 'external', 'internal', 'parent', 'sibling', 'index'],
                    'newlines-between': 'always'
                }
            ]
        },
        settings: {
            'import/resolver': {
                typescript: {
                    project: './tsconfig.json'
                },
                alias: {
                    map: [
                        ['@', './resources/js'],
                        ['~', './resources']
                    ],
                    extensions: ['.ts', '.vue', '.json']
                }
            }
        }
    },

    {
        files: ['**/*.js'],
        languageOptions: {
            ecmaVersion: 2025,
            sourceType: 'module',
            globals: {
                ...globals.browser,
                ...globals.node
            },
            parser: babelParser
        },
        plugins: {
            import: eslintPluginImport,
            promise: eslintPluginPromise
        },
        rules: {
            'no-console': 'warn',
            'no-unused-vars': ['warn', { argsIgnorePattern: '^_' }],
            'import/order': [
                'error',
                {
                    groups: ['builtin', 'external', 'internal', 'parent', 'sibling', 'index'],
                    'newlines-between': 'always'
                }
            ]
        },
        settings: {
            'import/resolver': {
                alias: {
                    map: [
                        ['@', './resources/js'],
                        ['~', './resources']
                    ],
                    extensions: ['.js', '.vue', '.json']
                }
            }
        }
    }
];
