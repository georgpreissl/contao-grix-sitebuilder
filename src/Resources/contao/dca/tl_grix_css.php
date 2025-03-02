<?php

use Contao\DC_Table;
use Contao\DataContainer;

$GLOBALS['TL_DCA']['tl_grix_css'] = array
(
    // Config
    'config'   => array
    (
        'dataContainer'               => DC_Table::class,
        'enableVersioning'            => true,
        'sql' => array
        (
            'keys' => array
            (
                'id' => 'primary'
            )
        )
    ),
    // List
    'list' => array
    (
        'sorting' => array
        (
            'mode'                    => 11,
            'fields'                  => array('styleTitle'),
            'panelLayout'             => 'filter;search,limit'
        ),
        'label' => array
        (
            'fields'                  => array('styleTitle', 'cssClasses'),
            'showColumns'             => true,
            'label_callback' => function ($row, $label, DC_Table $dc, $args) {
                $args[0] = $row['styleTitle'];

                return $args;
            }
        ),
        'global_operations' => array
        (
            'all' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['MSC']['all'],
                'href'                => 'act=select',
                'class'               => 'header_edit_all',
                'attributes'          => 'onclick="Backend.getScrollOffset()" accesskey="e"'
            )
        ),
        'operations' => array
        (
			'edit',
			'copy',
			'delete',
            'show',
			'toggle' => array
			(
				'href'                => 'act=toggle&amp;field=published',
				'icon'                => 'visible.svg',
				'showInHeader'        => true
			),            
        )
    ),
    // Palettes
    'palettes' => array
    (
        'default' => '{style_legend},styleTitle;{css_legend},cssClasses;{description_legend},styleDescription;{publish_legend},published'
    ),
    // Fields
    'fields'   => array
    (
        'id' => array
        (
            'sql'                     => "int(10) unsigned NOT NULL auto_increment"
        ),
        'tstamp' => array
        (
            'sql'                     => "int(10) unsigned NOT NULL default '0'"
        ),
        'styleTitle' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_grix_css']['styleTitle'],
            'exclude'                 => true,
            'search'                  => true,
            'inputType'               => 'text',
            'eval'                    => array('mandatory' => true, 'maxlength' => 255, 'tl_class' => 'w50'),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'cssClasses' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_grix_css']['cssClasses'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'eval'                    => array('mandatory'=>true, 'maxlength'=>255, 'rgxp'=>'alphanumeric', 'tl_class'=>'w50'),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'styleDescription' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_grix_css']['styleDescription'],
            'exclude'                 => true,
            'search'                  => true,
            'inputType'               => 'text',
            'eval'                    => array('maxlength' => 255, 'tl_class' => 'w50'),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
		'published' => array
		(
			'toggle'                  => true,
			'filter'                  => true,
			'flag'                    => DataContainer::SORT_INITIAL_LETTER_ASC,
			'inputType'               => 'checkbox',
			'eval'                    => array('doNotCopy'=>true),
			'sql'                     => array('type' => 'boolean', 'default' => false)
		),        
    )
);
