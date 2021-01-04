<?php 

define('TL_MODE', 'FE');
$path = dirname(dirname($_SERVER['SCRIPT_FILENAME']));
$path = substr($path, 0, -15) . 'initialize.php';
require($path);


if(RequestToken::validate(Input::post('REQUEST_TOKEN')))
{

	$grixAction = Input::post('grixAction');

	switch ($grixAction) {
	    case "save":
	    	// update the grix js of an article

			$grixJs = \Input::post('grixJs');
			$articleId = \Input::post('articleId');

			$objResult = Database::getInstance()->prepare("UPDATE tl_article SET grixJs=? WHERE id=?")->execute($grixJs, $articleId);
			echo $objResult->affectedRows;
	        
	        break;


	    case "load":
	    	// load the grix js of an article

			$articleId = \Input::post('articleId');

			$objResult = Database::getInstance()->prepare("SELECT grixJs from tl_article WHERE id=?")->execute($articleId);
			echo $objResult->grixJs;

	        break;


	    case "insert":
	    	// update the grix js of an article
	    	// update the used CEs of an article

			$grixJs = \Input::post('grixJs');
			$articleId = \Input::post('articleId'); 
			$ceId = \Input::post('ceId'); 

			// Insert the new grix js
			$objResult = Database::getInstance()->prepare("UPDATE tl_article SET grixJs=? WHERE id=?")->execute($grixJs, $articleId);

			// Get the used CEs for this article as a database object
			$objUsedCEs = Database::getInstance()->prepare("SELECT CEsUsed from tl_article WHERE id=?")->execute($articleId);

			// Unserialize the CEsUsed property
			$arrUsedCEs = unserialize($objUsedCEs->CEsUsed);

			if (!is_array($arrUsedCEs))
			{
				$arrUsedCEs = array();
			}

			// Update the used CEs for this article
			if (!in_array($ceId, $arrUsedCEs)) 
			{
			    $arrUsedCEs[] = $ceId;
				$data = serialize($arrUsedCEs);
				Database::getInstance()->prepare("UPDATE tl_article SET CEsUsed=? WHERE id=?")->execute($data, $articleId);
			    
			}
			echo 'done!';
			break;




	    case "delete":
	    	// delete a CE permanently

			$articleId = \Input::post('articleId'); 
			$ceId = \Input::post('ceId');  

			// delete the CE
			$objResult = Database::getInstance()->prepare("DELETE FROM tl_content WHERE id=?")->execute($ceId);

			// delete the CE id from the 'CEsUsed' list
			$objCEsUsed = Database::getInstance()->prepare("SELECT CEsUsed from tl_article WHERE id=?")->execute($articleId);
			$arrCEsUsed = unserialize($objCEsUsed->CEsUsed);
			$arrCEsUsed = array_diff($arrCEsUsed, array($ceId));	
			$data = serialize($arrUsedCEs);
			Database::getInstance()->prepare("UPDATE tl_article SET CEsUsed=? WHERE id=?")->execute($data, $articleId);

			break;



	    case "insertce":
	    	// insert a CE into the CEsUsed array of an article

			$articleId = \Input::post('articleId');
			$strCEs = \Input::post('arCEs');

			$arrCEs = json_decode($strCEs);

			$objUsedCEs = Database::getInstance()->prepare("SELECT CEsUsed from tl_article WHERE id=?")->execute($articleId);
			$arrUsedCEs = unserialize($objUsedCEs->CEsUsed);

			if (!is_array($arrUsedCEs)) 
			{
				$arrUsedCEs = array();
			}

			foreach ($arrCEs as $key => $id) 
			{
				if (!in_array($id, $arrUsedCEs)) 
				{
				    $arrUsedCEs[] = intval($id);
				}
			}

			$data = serialize($arrUsedCEs);
			$result = Database::getInstance()->prepare("UPDATE tl_article SET CEsUsed=? WHERE id=?")->execute($data, $articleId);
				
			echo $objResult->affectedRows;


			break;




	    default:
	        echo "No valid ajax GrixAction!";
	}



};




?>