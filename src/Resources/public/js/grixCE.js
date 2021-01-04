(function($){
	$(document).ready(function(){




		// the new CE should be saved
		// Let's paste it into the grix JSON before
		$('#saveNclose').click(function(e) {

			var phId = getUrlParameter('phid');
			var articleId = getUrlParameter('grixarticle');
			var ceId = getUrlParameter('id');
			console.log('phId: ',phId);
			console.log('articleId: ',articleId);
			console.log('ceId: ',ceId);

			loadGrixJs(articleId,phId,ceId);
			
		    e.preventDefault();
			return false;
		});


		// load the grix js for the current article and insert the CE
		function loadGrixJs(articleId,phId,ceId) {
			
			
			$.ajax({
				url: '/grixload',
				type: 'POST',
				dataType: 'json',
				data: {
					articleId: articleId
				},
				async: true,  
				cache: false,
				success: function(data){

					// console.log(data.data);

					// Convert the JSON to js
					var obGrixJs = JSON.parse(data.data);
					// console.log('obGrixJs: ',obGrixJs);

					// Find the place where the element is to be inserted
					var arId = phId.split("_");
					var obP = {
						elements: obGrixJs
					};
					var nrIx = parseInt(arId[0]);
					// console.log('nrIx: ',nrIx);
					// console.log('obP.elements[nrIx]: ',obP.elements[nrIx]);

					for (var i = 0; i < arId.length-1; i++) {
						obP = obP.elements[arId[i]];
						nrIx = parseInt(arId[i+1]);
					};

					var obCE = new GrixCE();
					obCE.id = ceId;

					if (obP.elements[nrIx].elements) {
						// insert the element into the clicked column
						obP.elements[nrIx].elements.push(obCE);
					} else{
						// insert the element after the clicked CE 
						obP.elements.splice(nrIx+1, 0, obCE);
					};

					// Convert back to JSON and save it
					var stGrixJs = JSON.stringify(obGrixJs);
			        insertGrixJs(stGrixJs,articleId,ceId);



				},
				error: function (xhr, textStatus, errorThrown) {
					alert('ajax error ' + (errorThrown ? errorThrown : xhr.status));
				}
			});	
		}


		// save the grix js of the current article
		function insertGrixJs(grixjs,articleId,ceId) {
			$.ajax({
				url: '/grixinsert',
				type: 'POST',
				dataType: 'json',
				data: {
					grixJs: grixjs,
					articleId: articleId,
					ceId: ceId
				},
				success: function(msg){
					// console.log(msg);

					// dont execute 'loadGrixJs' again
					$('#saveNclose').off('click');

					// submit the ce form
					$('#saveNclose').trigger('click');
				},
				error: function (xhr, textStatus, errorThrown) {
					alert('ajax error ' + (errorThrown ? errorThrown : xhr.status));
				}
			});
		}


		var getUrlParameter = function getUrlParameter(sParam) {
		    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
		        sURLVariables = sPageURL.split('&'),
		        sParameterName,
		        i;
		    for (i = 0; i < sURLVariables.length; i++) {
		        sParameterName = sURLVariables[i].split('=');
		        if (sParameterName[0] === sParam) {
		            return sParameterName[1] === undefined ? true : sParameterName[1];
		        }
		    }
		};


	});
})(jQuery);