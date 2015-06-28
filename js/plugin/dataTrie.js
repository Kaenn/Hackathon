(function($){
	// Parametre par defaut
	var defauts={
		data : []
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

			
			var menuContener=$("<ul>").addClass("nav navbar-nav");
			
			that.body=$("<div>").dataTrieBody();
			that.menu=$("<div>").dataTrieMenu();
			
			// Création du squelette du dataTrie
			that.append([
				$("<div>",{"id":"body-menu"}).addClass("col-md-3").append(
					that.menu
				),
				$("<div>").addClass("col-md-9").append(
					that.body
				)
			]);
			
			for(var i in that.parametres.data){
				var action=that.parametres.data[i][0];
				var date=new Date(that.parametres.data[i][1]);
				var params=that.parametres.data[i][2];
				
				that.body.dataTrieBody("addContent",action,date,params);
			}
			
			
			return that;
		};
		
		
		
		that.on("dataTrieBodyAdd",function(data){
			that.menu.dataTrieMenu("addAction",data.message);
		});
		
		that.on("dataTrieMenuActivate",function(data){
			that.body.dataTrieBody("showAction",data.message);
		});
		
		
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