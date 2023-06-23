<?php 







// When the CE editor is loaded
$GLOBALS['TL_DCA']['tl_content']['config']['onload_callback'][] = array('gp_grix','addGrixJs');


// When the CE is saved/submitted
$GLOBALS['TL_DCA']['tl_content']['config']['onsubmit_callback'][] = array('gp_grix','grixOnCeSubmit');



/**
 * Class gp_grix
 * Provide miscellaneous methods that are used by the data configuration array.
 */
class gp_grix extends tl_content
{

	/**
	 * Add the grix js when a new CE is created via grix
	 */
    public function addGrixJs(DataContainer $dc)
    {


    	if(\Input::get('grix')=='create')
    	{

    		// do not remove!!!
			if (!isset($GLOBALS['TL_JAVASCRIPT']))
			{
				$GLOBALS['TL_JAVASCRIPT'] = array();
			}

		    // add the jquery-library at the beginning of TL_JAVASCRIPT
			array_unshift($GLOBALS['TL_JAVASCRIPT'], 'assets/jquery/js/jquery.min.js');

		    // add "jQuery.noConflict()" after the jquery-library
			$GLOBALS['TL_JAVASCRIPT'][] = 'bundles/georgpreisslcontaogrix/js/jquery.noconflict.js';

			// add the js for ce creating
    		$GLOBALS['TL_JAVASCRIPT'][] = 'bundles/georgpreisslcontaogrix/js/grixElement.js';
    		$GLOBALS['TL_JAVASCRIPT'][] = 'bundles/georgpreisslcontaogrix/js/grixCE.js';
			
    	};

    }



	/**
	 * CE has been saved/submitted: 
	 * Now add the article id as a url parameter and redirect to GrixBE
	 */
    public function grixOnCeSubmit(DataContainer $dc)
    {

    	if (\Input::get('grix'))
    	{
    		// Only redirect when the save buttons have been pressed
    		// required to ignore the selection of a ce module 
    		if ($this->Input->post('saveNclose') || $this->Input->post('saveNback')) 
    		{
	    		if (\Input::get('grix')=='edit' || \Input::get('grix')=='create' ) 
	    		{
					$strCeId = \Input::get('id');
					$strArtId = \Input::get('pid');
				        
			        // add the tstamp, required!
					$this->import('Database');
					$this->Database->prepare("UPDATE tl_content SET tstamp=? WHERE id=?")->execute(time(), $strCeId);

		 			// go back to the grix module
		 			$this->redirect('contao?do=grixbe&id='.$strArtId);
	    		}

    		}
	    }

    }


}






 ?>