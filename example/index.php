<?php
require_once '../vendor/autoload.php';

\MordiSacks\I18n\I18n::$dir          = __DIR__ . '/Lang';
\MordiSacks\I18n\I18n::$autoGenerate = true;
\MordiSacks\I18n\I18n::$locale       = 'he_IL';

$name = 'מורדי';
echo MordiSacks\I18n\I18n::translate('Hello :name', 'default', compact('name'));
echo '<br>' . PHP_EOL;
echo __('Hello World!');