# php-cs-fixer-phpdoc-force-fqcn

[php-cs-fixer](https://github.com/FriendsOfPHP/PHP-CS-Fixer) rule to force using Single line @var phpdoc if no additional description provided. 

## Usage

In your .php_cs file: 

```php
<?php

// PHP-CS-Fixer 2.x syntax
return PhpCsFixer\Config::create()
    // (1) Register \AdamWojs\PhpCsFixerSingleLineVarPhpdoc\Fixer\Phpdoc\SingleLineVarPhpDocFixer fixer
    ->registerCustomFixers([
        new \AdamWojs\PhpCsFixerSingleLineVarPhpdoc\Fixer\Phpdoc\SingleLineVarPhpDocFixer(),
    ])
    ->setRules([
        // ... 
        // (2) Enable AdamWojs/phpdoc_force_single_line_var rule
        'AdamWojs/phpdoc_force_single_line_var' => true,
    ])
    // ...
    ;
```
