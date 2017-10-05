<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Mlang module config file
 */

/*
 * List of available languages
 */
return array(
	'default'		=> 'da',
	'cookie'		=> 'lang',
	'languages'		=>	array(
		'da'		=>	array(
			'i18n'		=> 'da_DK',
			'locale'    => array('da_DK.utf-8'),
			'label'		=> 'Dansk',
		),
		'en'		=> array(
			'i18n'		=> 'en_US',
			'locale'    => array('en_US.utf-8'),
			'label'		=> 'English',
		),
	),
);
