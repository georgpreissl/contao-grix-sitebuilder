<?php


$GLOBALS['TL_DCA']['tl_layout']['palettes']['default'] .= ';{grix_legend},grix_load_css';

$GLOBALS['TL_DCA']['tl_layout']['fields']['grix_load_css'] = array(
	'inputType' => 'checkbox',
	'label' => &$GLOBALS['TL_LANG']['tl_layout']['grix_load_css'],
	'sql' => "char(1) NOT NULL default '1'",
);