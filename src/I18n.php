<?php


namespace MordiSacks\I18n;

/**
 * Class I18n
 *
 * @package MordiSacks\I18n
 */
class I18n
{
    use LocaleMaker;

    /**
     * Path to language files directory
     *
     * @var string
     */
    public static $dir = null;

    /**
     * Auto generate language files?
     *
     * @var  bool
     */
    public static $autoGenerate = false;

    /**
     * Current locale
     *
     * @var  string
     */
    public static $locale = null;

    /**
     * Loaded locale files
     *
     * @var array
     */
    protected static $loaded = [];

    /**
     * @param string $string      Text to be translated
     * @param string $text_domain Text domain
     *
     * @return string Translated text
     */
    protected static function loadTranslation($string, $text_domain)
    {
        /**
         * Locale file path
         *
         * @var string $file
         */
        $file = static::$dir . '/' . static::$locale . '/' . $text_domain . '.php';

        /**
         * Check if we have already loaded this file
         */
        if (array_key_exists($file, static::$loaded)) {

            /**
             * Save missing string if configured to
             */
            if (static::$autoGenerate && (!isset(static::$loaded[$file][$string]))) {
                return static::addTranslation($file, $string);
            }

            /** return processed string */
            return isset(static::$loaded[$file][$string]) && !empty(static::$loaded[$file][$string])
                ? self::$loaded[$file][$string] : $string;
        }

        /**
         * Check if the file exists
         */
        if (!file_exists($file)) {

            /**
             * Create file if not in configured to
             */
            if (static::$autoGenerate) {
                static::saveTranslationFile($file, [$string => '']);
            }

            return $string;
        }
        /** @noinspection PhpIncludeInspection */
        static::$loaded[$file] = (array)require $file;

        /**
         * Save missing string if not in production
         */
        if (static::$autoGenerate && (!isset(static::$loaded[$file][$string]))) {
            return static::addTranslation($file, $string);
        }

        /** return processed string */
        return isset(static::$loaded[$file][$string]) && !empty(static::$loaded[$file][$string])
            ? static::$loaded[$file][$string] : $string;
    }

    /**
     * @param string $string Translated text
     * @param array  $vars   Associative array of vars to inject
     *
     * @return string Translated and vared text
     */
    public static function dropVars($string, $vars = [])
    {
        return strtr($string, array_flip(array_map(function ($v) {
            return ':' . $v;
        }, array_flip($vars))));
    }

    /**
     * @param        $string
     * @param string $text_domain
     * @param array  $vars
     *
     * @return string
     */
    public static function translate($string, $text_domain = 'default', $vars = [])
    {
        return static::dropVars(static::loadTranslation($string, $text_domain), $vars);
    }

    /**
     * Get all strings available
     * Not for use in production
     *
     * @return array
     * @throws \Exception
     */
    public static function getAllStrings()
    {
        if (is_null(self::$dir) || is_null(self::$locale)) {
            throw new \Exception('Locales directory and locale must be set');
        }

        $strings = [];
        foreach (scandir(self::$dir . '/' . self::$locale) as $text_domain) {
            if ($text_domain == '.' || $text_domain == '..') {
                continue;
            }

            /** @noinspection PhpIncludeInspection */
            foreach ((array)require self::$dir . '/' . self::$locale . '/' . $text_domain as $string => $value) {
                $strings[$string] = $value;
            }
        }

        return $strings;
    }
}