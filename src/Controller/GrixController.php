<?php

namespace GeorgPreissl\ContaoGrixBundle\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Contao\ArticleModel;
use Contao\PageModel;

class GrixController
{


    public function save(Request $request)
    {
        $articleId = $request->request->get('articleId'); 
        $grixJs = $request->request->get('grixjs');  
        $objResult = \Database::getInstance()->prepare("UPDATE tl_article SET grixJs=? WHERE id=?")->execute($grixJs, $articleId);

        return new JsonResponse(array(
			'data' => $objResult->affectedRows,
            'status' => 'OK',
            'message' => ['returntest', 'testarray']),
        200);
    }

    // load the grix js of an article
    public function load(Request $request)
    {

        $articleId = $request->request->get('articleId');

        $objResult = \Database::getInstance()->prepare("SELECT grixJs from tl_article WHERE id=?")->execute($articleId);
        // echo $objResult->grixJs;

        return new JsonResponse(array(
			'data' => $objResult->grixJs,
            'status' => 'OK',
            'message' => ['returntest', 'testarray']),
        200);
		
    }


    // update the grix js of an article
    // update the used CEs of an article
    public function insert(Request $request)
    {

        // $grixJs = \Input::post('grixJs');
        // $articleId = \Input::post('articleId'); 
        // $ceId = \Input::post('ceId'); 

        $grixJs = $request->request->get('grixJs');
        $articleId = $request->request->get('articleId');
        $ceId = $request->request->get('ceId');


        // Insert the new grix js
        $objResult = \Database::getInstance()->prepare("UPDATE tl_article SET grixJs=? WHERE id=?")->execute($grixJs, $articleId);

        // Get the used CEs for this article as a database object
        $objUsedCEs = \Database::getInstance()->prepare("SELECT CEsUsed from tl_article WHERE id=?")->execute($articleId);

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
            \Database::getInstance()->prepare("UPDATE tl_article SET CEsUsed=? WHERE id=?")->execute($data, $articleId);
            
        }


        return new JsonResponse(array(
			'data' => $arrUsedCEs,
            'status' => 'OK',
            'message' => ['returntest', 'testarray']),
        200);
		
    }



    public function test($action = 0, Request $request)
    {


        // $formData = $request->request->get('formdata'); /** if there is a formData in the js data {} */
        $articleId = $request->request->get('articleid'); /** if there is a formData in the js data {} */
        $grixJs = $request->request->get('grixjs'); /** if there is a formData in the js data {} */

        // $html = "<h1>works: ".$formData."</h1>";


			// $grixJs = \Input::post('grixJs');
			// $articleId = \Input::post('articleId');

			$objResult = \Database::getInstance()->prepare("UPDATE tl_article SET grixJs=? WHERE id=?")->execute($grixJs, $articleId);
			// echo $objResult->affectedRows;


        return new JsonResponse(array(
			'data' => $objResult->affectedRows,
            'status' => 'OK',
            'message' => ['returntest', 'testarray']),
        200);
		
    }

	

}
?>
