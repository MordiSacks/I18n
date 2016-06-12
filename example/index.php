<?php
require_once '../vendor/autoload.php';

\MordiSacks\I18n\I18n::setDir('Lang');
\MordiSacks\I18n\I18n::setLocale('he_IL');

echo __('Hello World!', 'default');

