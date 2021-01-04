<?php

/**
 * Extension for Contao Open Source CMS
 *
 * Copyright (c) 2015 Craffft
 *
 * @package CssStyleSelector
 * @link    https://github.com/craffft/contao-css-style-selector
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */

namespace GeorgPreissl\ContaoGrixBundle\Models;

use Contao\Model;

class GrixCssModel extends Model
{


    /**
     * Name of the table
     * @var string
     */
    protected static $strTable = 'tl_grix_css';



    /**
     * @param array $arrIds
     * @return array
     */
    public static function findCssClassesByIds(array $arrIds)
    {
        $t = self::$strTable;
        $objDatabase = \Database::getInstance();

        $objCssStyleSelector = $objDatabase->prepare("SELECT cssClasses FROM $t WHERE id IN(". implode(',', array_map('intval', array_unique($arrIds))) .")")->execute();

        return $objCssStyleSelector->fetchEach('cssClasses');
    }


    /**
     * @param $strType
     * @return array
     */
    public static function findStyleTitleByNotDisabledType($strType)
    {
        if (!in_array($strType, self::getAvailableTypes())) {
            return array();
        }

        $t = self::$strTable;
        $objDatabase = \Database::getInstance();

        $objCssStyleSelector = $objDatabase
            ->prepare("SELECT id, styleTitle FROM $t WHERE disableIn" . ucfirst($strType) . "=? ORDER BY styleTitle ASC")
            ->execute(0);

        return $objCssStyleSelector->fetchEach('styleTitle');
    }
}
