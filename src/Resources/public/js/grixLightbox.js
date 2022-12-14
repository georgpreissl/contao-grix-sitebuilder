(function($){
	$(document).ready(function(){
		

		window.GrixLightbox = function(){
			
			var self = this;
		

			// Bind the event handler to the elements

			self.bindEvents = function(){

				// choose the units config for a row by click
				$('.grix-lb__unitsconf').click(function(e) {
					$(this).addClass('selected').siblings().removeClass('selected');

					// empty then custom input field when a predefined option is selected
					if(!$(this).hasClass('grix_lb_unitsconf_custom')) {
						$(this).siblings('.grix_lb_unitsconf_custom').find('input').val('');
					}
					e.preventDefault();
				});

				// choose the units config for a row by text input
				$('.grix_lb_unitsconf_custom input').change(function(e) {
					//console.log('change');
					var val = $(this).val();
					if ($(this).val() != '') {
						$(this).parent().addClass('selected').siblings().removeClass('selected');
						$(this).parent().data('config',val);
					};
					e.preventDefault();
				});

				// dont select a configuration if the text input is left empty
				$('.grix_lb_unitsconf_custom input').blur(function(e) {
					var val = $(this).val();
					if (val == '') {
						$(this).parent().removeClass('selected');
					};
					e.preventDefault();
				});



				// import CE's from other articles via dropdown menu
				$(".grix_lb_articles select").change(function(){
				    var nrArtId = $(this).val();
				    //console.log('nrArtId: ',nrArtId);
				    // php action is defined in GrixHooks.php
					$.ajax({
						type: 'POST',
						data: {
							'action':'loadGrixCEs',
							'id':nrArtId,
							'REQUEST_TOKEN':Contao.request_token
						},
					    dataType: 'json',
						cache: false		     	
			        }).done(function(obj) {
			        	// Insert the loaded CE's
						$('.grix_lb_ces').html(obj.content);
						//console.log(obj);
					});	
			        return false;
				});

				// select an CE to import it
				$('.grix_lb').on("click", '.grix_lb_ce', function(event) { 
					$(this).toggleClass('selected');
				});
				
				$('.grix_lb_overlay').click(function(e){
					self.close();
					e.preventDefault();
				});

				$('.grix_lb_cancel').click(function(e){
					self.close();
					e.preventDefault();
				});

				// select an css class to apply it
				$('.grix_lb_class').click(function(e) {
					$(this).toggleClass('selected');
				});
				
				$('#grix_lb_apply').click(function(e){

					// collect the selected unit-configs for a row
					$('.grix-lb__unitsconf.selected').each(function(i,el){
						var dev = $(el).data('device');
						self.obCfg.unitsConf[dev] = $(el).data('config');
					});

					// collect the selected CEs
					$('.grix_lb_ce.selected').each(function(i,el){
						self.arCEchecked.push($(this).data("ceid"));
					});

					// collect the selected classes
					$('.grix_lb_class.selected').each(function(i,el){
						self.arCLchecked.push($(this).data("alias"));
					});

					// create the return object
					self.obCfg.arClasses = self.arCLchecked;
					self.obCfg.arCEs = self.arCEchecked;

					// first call the callback function
					self.settings.callBackFunction(self.settings.obTarget,self.obCfg);

					// afterwards close the lightbox
					self.close();

				});

			}



			// Open the lightbox window

			self.activate = function(settings){
				self.obCfg = {
					unitsConf:{}
				};
				self.settings = settings;

				// Start without a selection
				self.arCEchecked = [];
				self.arCLchecked = [];

				// get the clicked row/column
				// var obClicked = self.settings.obTarget.elements[self.settings.obTarget.pos];
				var obClicked = self.settings.obTarget;

				// Open the lightbox
				$('body').addClass('grix_lb_active grix_lb_'+obClicked.type);

				// Get the existing css classes of the row/column
				self.arClasses = obClicked.classes;

				// mark those existing css classes as selected
				for (var i = 0; i < self.arClasses.length; i++) {
					$('.grix_lb_classes').find('[data-alias="'+self.arClasses[i]+'"]').addClass('selected');
				}

				if (obClicked.type == 'row') {

					var arCols = obClicked.elements;
					// console.log('arCols: ',arCols);

					var arDevices = ['xs','sm','md','lg'];

					// Mark the choosen units config as selected
					$('.grix_lb_colmenu').each(function(index, el) {
						var stUnCfg = obClicked.unitsConf[arDevices[index]];
						// console.log('stUnCfg: ',stUnCfg);

						var $unConf = $(this).find('*[data-config="'+stUnCfg+'"]');
						if ($unConf.length) {
							$unConf.addClass('selected');
						} else {
							$(this).find('.grix_lb_unitsconf_custom input').val(stUnCfg);
							$(this).find('.grix_lb_unitsconf_custom').addClass('selected');
						}
					});
				};

			}


			// Close the lightbox window

			self.close = function(){

				self.obCfg = {
					unitsConf:{}
				};

				// Deselect everything
				$('.grix-lb__unitsconf').removeClass('selected');
				$('.grix_lb_class').removeClass('selected');
				$('.grix_lb_ce').removeClass('selected');

				$('.grix_lb_unitsconf_custom').each(function(index, el) {
					$(this).find('input').val('');
				});

				$('body').removeClass('grix_lb_active grix_lb_row grix_lb_col');

			}


		}




		
		
	});
})(jQuery);