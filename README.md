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