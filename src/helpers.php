<?php

use MordiSacks\I18n\I18n;

if(!function_exists('__'))
{
	/**
	 * @param string $string      Text to be translated
	 * @param string $text_domain Text domain
	 * @param array  $vars        Associative array of vars to inject
	 *
	 * @return string Translated text
	 */
	function __($string, $text_domain = 'default', $vars = [])
	{
		return I18n::translate($string, $text_domain, $vars);
	}
}
