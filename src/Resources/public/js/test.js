	function X(){

	}
(function($){

	X.prototype.m = function(ar){
		$('#DbgCEsUsedNr').text(ar.length);
		$('#DbgCEsUsedArr').text(ar.join(','));	
		console.log($('#DbgCEsUsedNr').length);
	}

})(jQuery);