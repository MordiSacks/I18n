# I18n
Small but powerful locale library.

# Installation
``` 
composer require mordisacks/i18n
```

# Usage

Set locales directory
```
\MordiSacks\I18n\I18n::setDir('Lang');
```

Variable injection!
Added in version 2.0.0
```
$name = 'Mordi';
echo __('Hello :name', 'default', compact('name'))
// Outputs "Hello Mordi"
```

Production mode, Added in version 1.1.0
If Production is set to false, 
Any missing domains and/or strings will be auto generated
To use, simply state the following
```
\MordiSacks\I18n\I18n::setProduction(false);
```

Set current locale
```
\MordiSacks\I18n\I18n::setLocale('he_IL');
```

Translate!
```
echo \MordiSacks\I18n\I18n::translate('Hello World!', 'default');
```
If your text domain is "default", you can leave that parameter out
```
echo \MordiSacks\I18n\I18n::translate('Hello World!');
```
And via helper
```
echo __('Hello World!');
```