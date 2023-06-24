<?php

/**
 * Grid Extension for Contao
 *
 * Copyright (c) 2017 Georg Preissl
 *
 * @package gp_grix
 * @link    https://www.georg-preissl.at
 * @license https://opensource.org/licenses/MIT MIT
 */

/**
 * Namespace
 */
namespace GeorgPreissl\ContaoGrixBundle\Classes;


use GeorgPreissl\ContaoGrixBundle\Models\GrixCssModel;

class GrixBe extends \BackendModule
{

	protected $strTemplate = 'mod_grix';


	public function compile()
	{

		$this->loadLanguageFile('tl_grix'); 

		// include CSS & Javascripts

		if (TL_MODE=='BE')
		{
			if (!isset($GLOBALS['TL_JAVASCRIPT']))
			{
				$GLOBALS['TL_JAVASCRIPT'] = array();
			}
		    // add "jQuery.noConflict()" at the beginning of TL_JAVASCRIPT
			array_unshift($GLOBALS['TL_JAVASCRIPT'], 'bundles/georgpreisslcontaogrix/js/jquery.noconflict.js');

		    // add the jquery library at the beginning of TL_JAVASCRIPT
			array_unshift($GLOBALS['TL_JAVASCRIPT'], 'assets/jquery/js/jquery.min.js');

			$GLOBALS['TL_JAVASCRIPT'][] = 'bundles/georgpreisslcontaogrix/js/jquery-ui-1.12.1/jquery-ui.min.js';
			$GLOBALS['TL_JAVASCRIPT'][] = 'bundles/georgpreisslcontaogrix/js/grixElement.js';
			$GLOBALS['TL_JAVASCRIPT'][] = 'bundles/georgpreisslcontaogrix/js/grixLightbox.js';
			$GLOBALS['TL_JAVASCRIPT'][] = 'bundles/georgpreisslcontaogrix/js/grix.js';
			$GLOBALS['TL_CSS'][] = 'bundles/georgpreisslcontaogrix/css/grix_backend.css';
			$GLOBALS["TL_CSS"][] = 'bundles/georgpreisslcontaogrix/css/bootstrap_backend.css';
		}


		// get the id of the article to edit
		// eg. main.php ? do=grixbe & id=4 & ref=f450a0f36c3019d4030aeab540292c3d
		$id = \Input::get('id');


		// if the grixBeForm has been submitted, save js and html to the database
		if (\Input::post('FORM_SUBMIT') == 'tl_grix')
		{
			// save the frontend html
			$strGrixHtmlFrontend = $_POST['grixHtmlFrontend'];
			$this->Database->prepare("UPDATE tl_article SET grixHtmlFrontend=? WHERE id=?")->execute($strGrixHtmlFrontend, $id);
			
			// save the js string
			$strGrixJs = $_POST['grixJs'];
			$this->Database->prepare("UPDATE tl_article SET grixJs=? WHERE id=?")->execute($strGrixJs, $id);

			// save the CEsUsed value
			$strCEsUsed = $_POST['CEsUsed'];
			$arrCEsUsed = json_decode($strCEsUsed,TRUE);
			$strCEsUsedSerialized = serialize($arrCEsUsed);
			$this->Database->prepare("UPDATE tl_article SET CEsUsed=? WHERE id=?")->execute($strCEsUsedSerialized, $id);
		}


		// get all the content elements of this article used by Grix
		$objCEsUsed = $this->Database->prepare("SELECT CEsUsed from tl_article WHERE id=?")->execute($id);
		$arrCEsUsed = unserialize($objCEsUsed->CEsUsed);

		if ($arrCEsUsed == false) 
		{
			$arrCEsUsed = array();
		}
		$intCEsUsedNr = count($arrCEsUsed);


		// get all the CEs of this article created by contao directly
		$objCEs = \ContentModel::findPublishedByPidAndTable($id,'tl_article');
        $arrCEs = array();
	    if ($objCEs == null)
	    {
	        $intCEsNr = 0;
	    } else {
	        $intCEsNr = $objCEs->count();

	        while ($objCEs->next()) 
	        {
	            $objCE = $objCEs->current();
	            $arrCEs[] = $objCE->id;
	        }
	    	
	    }


	    // add the contao-created CEs to the collection
		$arrCEsAll = array_merge($arrCEsUsed, $arrCEs);
		
		// delete duplicates
		$arrCEsAll = array_unique($arrCEsAll);

		// now we have all the CEs for this article
		$objCEsAll = \ContentModel::findMultipleByIds($arrCEsAll);

		// store all the CEs in an array
		$arrCEsData = array();
		if ($objCEsAll !== null)
		{
		 	while ($objCEsAll->next())
			{
				$arrCE = array();
				$arrCE['html'] = \Controller::getContentElement($objCEsAll->current(),'main');
				$arrCE['id'] = $objCEsAll->id;
				$arrCEsData[] = $arrCE;
			}
		}


		// get all the css classes of this article
		$objClasses = GrixCssModel::findAll();

		// store the css classes in an array
		$arrClasses = array();
		if ($objClasses !== null)
		{
		 	while ($objClasses->next())
			{
				$arrCl = array();
				$arrCl['name'] = $objClasses->styleTitle;
				$arrCl['id'] = $objClasses->id;
				$arrCl['alias'] = $objClasses->cssClasses;
				$arrCl['description'] = $objClasses->styleDescription;
				$arrClasses[] = $arrCl;
			}
		}


		// get the grixJs of the article
		$result = $this->Database->prepare("SELECT grixJs, grixHtmlFrontend, title, pid FROM tl_article WHERE id=?")->execute($id);
		$strData = $result->grixJs ? : '';

		$this->Template->id = $id;
		$this->Template->data = $strData;
		$this->Template->grixHtmlFrontend = $result->grixHtmlFrontend;



		// get the title of the article
		$this->Template->articleTitle = $result->title;	
		
		// get the title of the page
		$result = $this->Database->prepare("SELECT title FROM tl_page WHERE id=?")->execute($result->pid);
		$this->Template->pageTitle = $result->title;		 

		// id's of the used content elements
		$this->Template->CEsUsed = json_encode($arrCEsUsed);

		// html data of the used content elements
		$this->Template->ces = $arrCEsData;

		// form action attribute
		$this->Template->action = ampersand(\Environment::get('request'));

		// lightbox data
		$this->Template->allArticles = $this->getArticleAlias($id);
		$this->Template->classes = $arrClasses;

		// languages – back link
		$this->Template->referer = $this->getReferer() . '?do=article';
		$this->Template->button = $GLOBALS['TL_LANG']['MSC']['backBT'];
		$this->Template->backBTTitle = specialchars($GLOBALS['TL_LANG']['MSC']['backBTTitle']);

		// languages – ui elements
		$this->Template->submit = specialchars($GLOBALS['TL_LANG']['MSC']['save']);		
		$this->Template->delete = specialchars($GLOBALS['TL_LANG']['tl_grix']['reset'][0]);		
		$this->Template->lbChooseCE = specialchars($GLOBALS['TL_LANG']['tl_grix']['lbChooseCE'][0]);		

		// for debugging
		$this->Template->DbgCEsNr = $intCEsNr;
		$this->Template->DbgCEs = count($arrCEs) ? 'IDs: ' . implode(", ", $arrCEs) : '';
		$this->Template->DbgCEsUsedNr = $intCEsUsedNr;
		$this->Template->DbgCEsUsed = count($arrCEsUsed) ? implode(", ", $arrCEsUsed) : '';
		
		

		
	}



	/**
	 * Get all articles and return them as array (article alias)
	 * @param object
	 * @return array
	 */
	public function getArticleAlias($id)
	{
		$arrPids = array();
		$arrAlias = array();

	    $this->import('BackendUser', 'User');

		if (!$this->User->isAdmin)
		{
			foreach ($this->User->pagemounts as $id)
			{
				$arrPids[] = $id;
				$arrPids = array_merge($arrPids, $this->Database->getChildRecords($id, 'tl_page'));
			}

			if (empty($arrPids))
			{
				return $arrAlias;
			}

			$objArticles = $this->Database->prepare("SELECT a.id, a.pid, a.title, a.inColumn, p.title AS parent FROM tl_article a LEFT JOIN tl_page p ON p.id=a.pid WHERE a.pid IN(". implode(',', array_map('intval', array_unique($arrPids))) .") ORDER BY parent, a.sorting")
									   ->execute();
		}
		else
		{
			$objArticles = $this->Database->prepare("SELECT a.id, a.pid, a.title, a.inColumn, p.title AS parent FROM tl_article a LEFT JOIN tl_page p ON p.id=a.pid ORDER BY parent, a.sorting")
									   ->execute();
		}

		if ($objArticles->numRows)
		{
			$this->loadLanguageFile('tl_article');

			while ($objArticles->next())
			{
					$result = $this->Database->prepare("SELECT * FROM tl_content WHERE pid=?")->execute($objArticles->id);
					if ($result->numRows) 
					{
						$key = $objArticles->parent . ' (ID ' . $objArticles->pid . ')';
						if ($id == $objArticles->id ) 
						{
							
							// show the current edited article as first option in the dropdown
							$arrCurrent = array();
							// $arrCurrent[$key][$objArticles->id] = $objArticles->title . ' (' . ($GLOBALS['TL_LANG']['tl_article'][$objArticles->inColumn] ?: $objArticles->inColumn) . ', ID ' . $objArticles->id . ')';
							$arrCurrent[$key][$objArticles->id] = $objArticles->title . ' (ID ' . $objArticles->id . ')';
							

						} else {
							$arrAlias[$key][$objArticles->id] = $objArticles->title . ' (ID ' . $objArticles->id . ')';

						}
					}
			}

			if (isset($arrCurrent)) 
			{
				$arrAlias = array_merge($arrCurrent, $arrAlias);
			}
		}
		
		return $arrAlias;
	}




}