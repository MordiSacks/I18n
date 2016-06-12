<?php

use MordiSacks\I18n\I18n;

if(!function_exists('__'))
{
	/**
	 * @param string $string      Text to be translated
	 * @param string $text_domain Text domain
	 *
	 * @return string Translated text
	 */
	function __($string, $text_domain = 'default')
	{
		return I18n::translate($string, $text_domain);
	}
}
