<?php
require_once '../vendor/autoload.php';

\MordiSacks\I18n\I18n::$dir        = 'Lang';
\MordiSacks\I18n\I18n::$production = true;
\MordiSacks\I18n\I18n::$locale     = 'he_IL';

$name = 'מורדי';
echo MordiSacks\I18n\I18n::translate('Hello :name', 'default', compact('name'));
