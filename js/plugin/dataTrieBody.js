(function($){
	// Parametre par defaut
	var defauts={
		"data" : []
	};


	$.fn.dataTrieBody=function(methodOrOptions){
		var methodArgs=arguments;	
		this.each(function(){
			var dataTrieBody=$(this).data('dataTrieBody');
			if (typeof dataTrieBody === "undefined") {
				// On initialise la classe
				var options=methodOrOptions;
			
				dataTrieBody=$.dataTrieBody($(this),options);
			}else{
				// On applique une method public sur la classe
				var method=methodOrOptions;
			
				dataTrieBody.doPublicMethod(method,methodArgs);
			}
			
			$(this).data('dataTrieBody',dataTrieBody);
		});
		
		return this;
	};



	$.dataTrieBody=function(that,methodOrOptions){
		that.nbAction=0;
		
		var initialize = function(){
			// On vide le conteneur
			that.empty();
			
			that.bodyContener=$("<div>").addClass("panel panel-default");
			
			for(var i in that.parametres.data){
				var action=that.parametres.data[i][0];
				var date=new Date(that.parametres.data[i][1]);
				var params=that.parametres.data[i][2];
				
				addContent(action,date,params);
			}
			
			
			// Création du squelette du dataTrieBody
			that.append(
				$('<div>',{"class":"panel-group","id":"accordion","role":"tablist","aria-multiselectable":"true"}).append(
					$("<div>").addClass("panel panel-default").append(
						that.bodyContener
					)
				)
			);
			
			return that;
		};
		
		var addContent = function(action,date,params){
			that.nbAction++;
			
			var paramsContener=$("<ul>");
			
			for(var c in params){
				var paramName=params[c][0];
				var paramVal=params[c][1];
				paramsContener.append($("<li>").text(paramName+" : "+paramVal));
			}
			
			that.bodyContener.append([
			        $("<div>",{"class":"panel-heading","role":"tab","id":"heading"+that.nbAction,"action-name":action}).append(
						$("<h4>").addClass("panel-title").append(
							$("<a>",{"role":"button","data-toggle":"collapse","data-parent":"#accordion","href":"#collapse"+that.nbAction,"aria-expanded":"true","aria-controls":"collapse"+that.nbAction}).append([
								$("<span>",{"class":"name-action"}).text(action),
								$("<span>",{"class":"date-action","timestamp":date.getTime()}).text(date.toLocaleString())								
							])
						)
					),
					$("<div>",{"id":"collapse"+that.nbAction,"class":"panel-collapse collapse in","role":"tabpanel","aria-labelledby":"heading"+that.nbAction,"action-name":action}).append(
						$("<div>").addClass("panel-body").append(
							paramsContener
						)
					)  
			
			]);
			
			that.parent().trigger({
				type: "dataTrieBodyAdd",
				message: action,
				time: new Date()
			});
			
			return that;
		};
		
		var showAction=function(action){
			that.bodyContener.children().each(function(){
				if($(this).is("[action-name='"+action+"']") || action=="all"){
					if(!$(this).is(".panel-heading")) $(this).collapse('show');
					else $(this).show();
				}else{
					if(!$(this).is(".panel-heading")) $(this).collapse('hide');
					else $(this).hide();
				}
			});
			
		}
		
		var methods={
			addContent : function(action,date,params){ return addContent(action,date,params)},
			showAction : function(action){ return showAction(action)}
		};
		
		
		
		that.doPublicMethod=function(method,args){
			if ( methods[method] ) {
				return methods[ method ].apply( that, Array.prototype.slice.call( args, 1 ));
			} else{
				$.error( 'Method ' +  method + ' does not exist on jQuery.dataTrieBody' );
			}
		}
		
		
		// Prise en compte des options utilisateurs
		that.parametres=$.extend(defauts, methodOrOptions);
		return initialize();
		
    };
	
	
	
})(jQuery);