<?php


namespace MordiSacks\I18n;


class I18n
{
	/** @var  string Lang directory */
	protected static $dir = null;
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
		$file = static::$dir . DIRECTORY_SEPARATOR . static::$locale . DIRECTORY_SEPARATOR . $text_domain . '.php';

		if(array_key_exists($file, self::$loaded))
		{
			return isset(self::$loaded[$file][$string]) ? self::$loaded[$file][$string] : $string;
		}

		if(!file_exists($file))
		{
			return $string;
		}
		/** @noinspection PhpIncludeInspection */
		self::$loaded[$file] = (array)require $file;

		return isset(self::$loaded[$file][$string]) ? self::$loaded[$file][$string] : $string;
	}
}