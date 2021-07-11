<?php


namespace MordiSacks\I18n;

/**
 * Class LocaleMaker
 *
 * @package MordiSacks\I18n
 */
trait LocaleMaker
{
    /**
     * Add missing string to an existing locale
     *
     * @param string $file
     * @param string $string
     *
     * @return string
     */
    protected static function addTranslation($file, $string)
    {
        static::$loaded[$file] = array_merge(static::$loaded[$file], [$string => '']);
        static::saveTranslationFile($file, static::$loaded[$file]);
        
        return $string;
    }
    
    /**
     * Like var_export, but pretty
     *
     * @param array $array I18n strings
     *
     * @return string
     */
    protected static function TranslationArrayExport($array)
    {
        $output = "[\n";
        foreach ($array as $key => $value) {
            /**
             * Escape '
             */
            $key = str_replace('\'', '\\\'', $key);
            $value = str_replace('\'', '\\\'', $value);
            $output .= "\t'{$key}' => '{$value}',\n";
        }
        
        return $output . "];";
    }
    
    /**
     * @param $file
     * @param $strings
     */
    protected static function saveTranslationFile($file, $strings)
    {
        /**
         * Get path info
         */
        $pathinfo = pathinfo($file);
        
        /**
         * Create Directory if not exist
         */
        if (!file_exists($pathinfo['dirname'])) {
            mkdir($pathinfo['dirname'], 0777, true);
        }
        file_put_contents($file, "<?php\n/** I18n Auto generated file on " . @date('Y-m-d H:i:s') . " */\nreturn " . static::TranslationArrayExport($strings));
    }
}