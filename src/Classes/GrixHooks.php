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
 * Namespace
 */
namespace GeorgPreissl\ContaoGrixBundle\Classes;



use Contao\DataContainer;
use Contao\LayoutModel;
use Contao\PageModel;
use Contao\PageRegular;


class GrixHooks extends \Backend {



	/**
	 * Change the output if grixJs is set and activated
	 */
	public function myCompileArticle($objTemplate, $arrData, $objModule)
	{
		if ($arrData['grixJs'] !== '' && $arrData['grixToggle'] == '1') 
		{

			$grixHtmlFrontend = $arrData['grixHtmlFrontend'];

			// is this needed?????
			// $grixHtmlFrontend = preg_replace("/%u([0-9a-f]{3,4})/i","&#x\\1;",urldecode($grixHtmlFrontend));
			// $grixHtmlFrontend = html_entity_decode($grixHtmlFrontend,null,'UTF-8');;

			$objTemplate->elements = array($grixHtmlFrontend);
		}
	}





	/**
	 * Generate the grix icon in the article list view
	 */
	public function addGrixIcon()
	{
		array_insert($GLOBALS['TL_DCA']['tl_article']['list']['operations'], 0, array
		(
			'grix' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_article']['grixListIcon'],
				'icon'                => 'bundles/georgpreisslcontaogrix/img/icon.svg',
				'button_callback'     => array('GeorgPreissl\ContaoGrixBundle\Classes\GrixHooks', 'createGrixIcon')
			)
		));
	}


	/**
	 * Create the html for the icon
	 */
	public function createGrixIcon($row, $href, $label, $title, $icon, $attributes)
	{
		// printf('<pre>%s</pre>', print_r($row,true));
		$strIcon = ($row['grixToggle'] == '') ? 'icon_inactive' : 'icon';
		return '<a class="grix_icon" href="contao/main.php?do=grixbe&amp;id='.$row['id'].'&amp;ref='.REQUEST_TOKEN.'" title="'.specialchars($title).'"'.$attributes.'>'
		.\Image::getHtml('bundles/georgpreisslcontaogrix/img/'.$strIcon.'.svg', $label)
		.'</a> ';
	}


	/**
	 * Add a class to the body when editing an article with grix
	 */
	public function myParseBackendTemplate($strBuffer, $strTemplate)
	{
	    if ($strTemplate == 'be_main' && \Input::get('do') == 'grixbe')
	    {
	        $strBuffer = str_replace('<body id="top" class="', '<body id="top" class="grix_active grix_lg ', $strBuffer);
	    }
	    return $strBuffer;          
	}




    public function grixPreAction($strAction)
    {
    }




    public function grixPostAction($strAction, $dc)
    {
        	// $dc->table  ... is 'tl_article'!
        	// $dc->id     ... is the id of the current edited article
 

		// Save with ajax – due to cache problems not working :(

        if ($strAction == 'saveGrix')
        {
        	$id = \Input::post('id');
        	$grixJs = \Input::post('grixJs');
        	$grixHtml = \Input::post('grixHtmlFrontend');

          	$this->import('Database');
			$this->Database->prepare("UPDATE tl_article SET grixHtmlFrontend=? WHERE id=?")->execute($grixHtml, $id);
			$this->Database->prepare("UPDATE tl_article SET grixJs=? WHERE id=?")->execute($grixJs, $id);

			echo json_encode(array 
			( 
			    'content'    => 'done!', 
			    'token'        => REQUEST_TOKEN 
			));  
            exit; 
            
        }        

 		
 		// load the content elements in the grix lightbox

        if ($strAction == 'loadGrixCEs')
        {

        	$id = \Input::post('id');

			$objCte = \ContentModel::findPublishedByPidAndTable($id, 'tl_article');

			if ($objCte !== null)
			{
				$html = "<ul>";
			 	while ($objCte->next())
				{
					$objRow = $objCte->current();
					$strBuffer = \Controller::getContentElement($objRow, "main");

					$html .= "<li class='grix_lb_ce' data-ceid='".$objCte->id."' >";
					$html .= "<div class='grix_lb_ce_inner' id='grixce_".$objCte->id."' >";
					$html .= $strBuffer;
					$html .= "</div>";
					$html .= "</li>";
				}
				$html .= "</ul>";
			}

			echo json_encode(array 
			( 
			    'content'    => $html, 
			    'token'      => REQUEST_TOKEN 
			));  
            exit; 
        }  
    }




	// Add a CSS file to the layout options

	public function generatePageHook(PageModel $page, LayoutModel $layout, PageRegular $pageRegular)
	{
		if ($layout->grix_load_css) {
			$GLOBALS['TL_CSS'][] = 'bundles/georgpreisslcontaogrix/css/bootstrap.css||static';
			$GLOBALS['TL_CSS'][] = 'bundles/georgpreisslcontaogrix/css/margin-bottom.css||static';
		}
	}






	public function addBootstrapFramework($strName)
	{
	    if ($strName == 'tl_layout')
	    {
	      array_push($GLOBALS['TL_DCA']['tl_layout']['fields']['framework']['options'], 'bundles/georgpreisslcontaogrix/css/bootstrap.css');
	      array_push($GLOBALS['TL_DCA']['tl_layout']['fields']['framework']['options'], 'bundles/georgpreisslcontaogrix/css/margin-bottom.css');
	    }
	}





}