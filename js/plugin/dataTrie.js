(function($){
	// Parametre par defaut
	var defauts={
		
	};


	$.fn.dataTrie=function(methodOrOptions){
		var methodArgs=arguments;	
		this.each(function(){
			var dataTrie=$(this).data('dataTrie');
			if (typeof dataTrie === "undefined") {
				// On initialise la classe
				var options=methodOrOptions;
			
				dataTrie=$.dataTrie($(this),options);
			}else{
				// On applique une method public sur la classe
				var method=methodOrOptions;
			
				dataTrie.doPublicMethod(method,methodArgs);
			}
			
			$(this).data('dataTrie',dataTrie);
		});
		
		return this;
	};



	$.dataTrie=function(that,methodOrOptions){
		var initialize = function(){
			// On vide le conteneur
			that.empty();
			
			// Création du conteneur de message
			that._messageContent=$('<div></div>').addClass('dataTrie-content-message');   
			
			// Création du squelette du dataTrie
			that.append(
				$("<div></div>",{"class":"panel-dataTrie"}).append(
					$('<ul></ul>')
						.addClass('dataTrie')
						.css('height',that.parametres.height)
						.append(that._messageContent)
				)
			);
			return that;
		};
		
		var addMessage = function(auteur,time,message){
			
			var message_elem=$('<li></li>').addClass("clearfix").append(
				$('<div></div').addClass('dataTrie-body clearfix').append(
					[
						$('<div></div>').addClass('header').append(
							[
								$('<strong></strong>').addClass('primary-font').html(auteur),
								$('<small></small>').addClass('pull-right text-muted').append(
									[
										$('<span></span>').addClass('glyphicon glyphicon-time'),
										time
									]
								)
							]
						),
						$('<p></p>').text(message)
					]
				)
			);
			
			that._messageContent.append(message_elem);
			while(that._messageContent.children().length > that.parametres.maxMessage){
				that._messageContent.children().first().remove();
			}
			return that;
		};
		
		var methods={
			addMessage : function(auteur,time,message){ return addMessage(auteur,time,message)}
		};
		
		that.doPublicMethod=function(method,args){
			if ( methods[method] ) {
				return methods[ method ].apply( that, Array.prototype.slice.call( args, 1 ));
			} else{
				$.error( 'Method ' +  method + ' does not exist on jQuery.dataTrie' );
			}
		}
		
		
		// Prise en compte des options utilisateurs
		that.parametres=$.extend(defauts, methodOrOptions);
		return initialize();
		
    };
	
	
	
})(jQuery);