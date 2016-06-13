<?php


namespace MordiSacks\I18n;


class I18n
{
	/** @var  string Lang directory */
	protected static $dir = null;
	/** @var  boolean|bool Production mode */
	protected static $production = true;
	/** @var  string Current locale */
	protected static $locale = null;
	/** @var array Loaded locales */
	protected static $loaded = [];

	/**
	 * Get locale directory
	 * @return string
	 */
	public static function getDir()
	{
		return self::$dir;
	}

	/**
	 * Set Locales directory
	 *
	 * @param $dir
	 */
	public static function setDir($dir)
	{
		self::$dir = $dir;
	}

	/**
	 * @return boolean
	 */
	public static function isProduction()
	{
		return self::$production;
	}

	/**
	 * If is set to false, we will create all missing files and strings
	 *
	 * @param boolean $production
	 */
	public static function setProduction($production)
	{
		self::$production = $production;
	}


	/**
	 * Set locale
	 * @return string
	 */
	public static function getLocale()
	{
		return self::$locale;
	}

	/**
	 * Get locale
	 *
	 * @param string $locale
	 */
	public static function setLocale($locale)
	{
		self::$locale = $locale;
	}

	/**
	 * @param string $string      Text to be translated
	 * @param string $text_domain Text domain
	 *
	 * @return string Translated text
	 */
	public static function translate($string, $text_domain = 'default')
	{
		/** @var string $file locale file path */
		$file = static::$dir . DIRECTORY_SEPARATOR . static::$locale . DIRECTORY_SEPARATOR . $text_domain . '.php';

		/**
		 * Check if we already loaded this file
		 */
		if(array_key_exists($file, self::$loaded))
		{
			/**
			 * Save missing string if not in production
			 */
			if(!self::isProduction() && (!isset(self::$loaded[$file][$string])))
			{
				return self::addTranslation($file, $string);
			}

			/** return processed string */
			return isset(self::$loaded[$file][$string]) && !empty(self::$loaded[$file][$string]) ? self::$loaded[$file][$string] : $string;
		}

		/**
		 * Check if the file exists
		 */
		if(!file_exists($file))
		{
			/**
			 * Create file if not in production
			 */
			if(!self::isProduction())
			{
				self::saveTranslationFile($file, [$string => '']);
			}

			return $string;
		}
		/** @noinspection PhpIncludeInspection */
		self::$loaded[$file] = (array)require $file;

		/**
		 * Save missing string if not in production
		 */
		if(!self::isProduction() && (!isset(self::$loaded[$file][$string])))
		{
			return self::addTranslation($file, $string);
		}

		/** return processed string */
		return isset(self::$loaded[$file][$string]) && !empty(self::$loaded[$file][$string]) ? self::$loaded[$file][$string] : $string;
	}

	/**
	 * @param $file
	 * @param $strings
	 */
	protected static function saveTranslationFile($file, $strings)
	{
		file_put_contents($file, "<?php\n/** I18n Auto generated file on " . date('Y-m-d H:i:s') . " */\nreturn " . self::TranslationArrayExport($strings));
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
		foreach($array as $key => $value)
		{
			$output .= "\t'{$key}' => '{$value}',\n";
		}

		return $output . "];";
	}

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
		self::$loaded[$file] = array_merge(self::$loaded[$file], [$string => '']);
		self::saveTranslationFile($file, self::$loaded[$file]);

		return $string;
	}
}