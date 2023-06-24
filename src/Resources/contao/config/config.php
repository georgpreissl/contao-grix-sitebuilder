<?php

/**
 * Grid Extension for Contao
 *
 * Copyright (c) 2017 Georg Preissl
 *
 * @package gp_grix
 * @link    http://www.georg-preissl.at
 * @license http://opensource.org/licenses/MIT MIT
 */


/**
 * Backend module
 */
array_insert($GLOBALS['BE_MOD']['design'], 1, array
(
	'grixbe' => array
	(
		'callback'        => 'GeorgPreissl\ContaoGrixBundle\Classes\GrixBe',
		'hideInNavigation' 		  => true
		// 'tables' 		  => array('tl_article'),
		// 'icon'            => 'bundles/georgpreisslcontaogrix/img/icon.svg'
	)
,
	'grixCss' => array
	(
	    'tables'          => array('tl_grix_css'),
	    'icon'            => 'bundles/georgpreisslcontaogrix/img/icon.svg'
	)

));



$GLOBALS['TL_MODELS']['tl_grix_css'] = '\\GeorgPreissl\\ContaoGrixBundle\\Models\\GrixCssModel';




/**
 * Hooks
 */

// Add the grix icon in the article list view
$GLOBALS['TL_HOOKS']['loadDataContainer'][] = array('GeorgPreissl\ContaoGrixBundle\Classes\GrixHooks', 'addGrixIcon');

// Add the bootstrap css file in the frontend
$GLOBALS['TL_HOOKS']['generatePage'][] = array('GeorgPreissl\ContaoGrixBundle\Classes\GrixHooks', 'generatePageHook');

// Output the grix html if grix is activated
$GLOBALS['TL_HOOKS']['compileArticle'][] = array('GeorgPreissl\ContaoGrixBundle\Classes\GrixHooks', 'myCompileArticle');

// Add a class to the body in the backend when editing an article with grix
$GLOBALS['TL_HOOKS']['parseBackendTemplate'][] = array('GeorgPreissl\ContaoGrixBundle\Classes\GrixHooks', 'myParseBackendTemplate');

// Ajax save function
$GLOBALS['TL_HOOKS']['executePreActions'][] = array('GeorgPreissl\ContaoGrixBundle\Classes\GrixHooks', 'grixPreAction');
$GLOBALS['TL_HOOKS']['executePostActions'][] = array('GeorgPreissl\ContaoGrixBundle\Classes\GrixHooks', 'grixPostAction');



/*
ToDo:

- add possibility to toggle visiblity of content elements in the grix grid view




*/


?>
