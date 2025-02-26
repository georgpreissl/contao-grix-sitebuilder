<?php 

/**
 * Palettes
 */

// Add the toggle checkbox to the article palette
$GLOBALS['TL_DCA']['tl_article']['palettes']['default'] .= ',grixToggle';
// dump($GLOBALS['TL_DCA']['tl_article']['palettes']);
// $GLOBALS['TL_DCA']['tl_article']['palettes']['sdfasdf'] = '{title_legend},grixJs';



/**
 * Fields
 */

$GLOBALS['TL_DCA']['tl_article']['fields']['grixJs'] = array
(
	'exclude'                 => true,
	'inputType'               => 'textarea',
	'eval'					  => array
	(
		'preserveTags' => true, 
		'allowHtml'=> true, 
		'tl_class' => 'grixJs'
	),
	'sql'                     => "mediumtext NULL"
);


$GLOBALS['TL_DCA']['tl_article']['fields']['grixHtmlFrontend'] = array
(
	'exclude'                 => true,
	'inputType'               => 'textarea',
	'eval' 					  => array
	(
		'preserveTags' => true, 
		'allowHtml' => true, 
		'tl_class' => 'grixHtmlFrontend'
	),
	'sql'                     => "mediumtext NULL"
);


// Decides whether the content elements of the article will be output via the module grix
$GLOBALS['TL_DCA']['tl_article']['fields']['grixToggle'] = array
(
	'exclude'       => true,
	'inputType'     => 'checkbox',
	'eval' 			=> array('tl_class'=>'long clr'),
	'sql'           => "char(1) NOT NULL default ''"
);



// CE ids which are used by grix in the current article
$GLOBALS['TL_DCA']['tl_article']['fields']['CEsUsed'] = array
(
	'exclude'       => true,
	'inputType'     => 'text',
	'eval' 			=> array('tl_class'=>'long clr'),
	'sql'           => "varchar(255) NOT NULL default ''"
);






