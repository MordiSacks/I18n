# I18n
Small but powerful locale library.

# Installation
``` 
composer require mordisacks/i18n
```

# Usage

Set locales directory
```
\MordiSacks\I18n\I18n::$dir = 'Lang';
```

Set current locale
```
\MordiSacks\I18n\I18n::$locale = 'he_IL';
```

Auto generate mode,
If autoGenerate is set to true, 
Any missing domains and/or strings will be auto generated
To use, simply state the following
```
\MordiSacks\I18n\I18n::$autoGenerate = true;
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

Variable injection!
Added in version 2.0.0
```
$name = 'Mordi';
echo __('Hello :name', 'default', compact('name'))
// Outputs "Hello Mordi"
```

# changelog
## 3.0.0
* Renamed production to autoGenerate