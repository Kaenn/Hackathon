(function($){
	// Parametre par defaut
	var defauts={
		"data" : []
	};


	$.fn.dataTrieMenu=function(methodOrOptions){
		var methodArgs=arguments;	
		this.each(function(){
			var dataTrieMenu=$(this).data('dataTrieMenu');
			if (typeof dataTrieMenu === "undefined") {
				// On initialise la classe
				var options=methodOrOptions;
			
				dataTrieMenu=$.dataTrieMenu($(this),options);
			}else{
				// On applique une method public sur la classe
				var method=methodOrOptions;
			
				dataTrieMenu.doPublicMethod(method,methodArgs);
			}
			
			$(this).data('dataTrieMenu',dataTrieMenu);
		});
		
		return this;
	};



	$.dataTrieMenu=function(that,methodOrOptions){
		var initialize = function(){
			// On vide le conteneur
			that.empty();

			
			that.menuContener=$("<ul>").addClass("nav navbar-nav");
			loadMenu(that.parametres.data);
			
			// Création du squelette du dataTrieMenu
			that.append(
				$("<div>",{"class":"navbar navbar-inverse","role":"navigation"}).append([
					$("<div>").addClass("navbar-header").append([
						$("<button>",{"type":"button","class":"navbar-toggle","data-toggle":"collapse","data-target":".sidebar-navbar-collapse"}).append([
						    $("<span>").addClass("sr-only").text("Toggle navigation"),
						    $("<span>").addClass("icon-bar"),
						    $("<span>").addClass("icon-bar"),
						    $("<span>").addClass("icon-bar")
						]),
						$("<span>").addClass("visible-xs navbar-brand").text("Menu")
					]),
					$("<div>").addClass("navbar-collapse collapse sidebar-navbar-collapse").append(
						that.menuContener
					)
				])
			).addClass("sidebar-nav");
			
			active('all');
			
			return that;
		};
		
		var loadMenu = function(data){
			that.menuContener.empty();
			
			var nbAll=0;
			for(var i in data){
				var name=data[i][0];
				var nb=data[i][1];
				
				that.menuContener.append(
					$("<li>",{"menu-name" : name}).append(
						$("<a>",{"href":"#"+name}).text(name).append(
							$("<span>").addClass('badge').text(nb)
						)
					).on("click",function(){
						active($(this).attr("menu-name"));
					})
				);
				
				nbAll+=nb;
			}
			
			that.menuContener.prepend(
				$("<li>",{"menu-name" : "all"}).append(
					$("<a>",{"href":"#"+name}).text("All").append(
							$("<span>").addClass('badge').text(nbAll)
					)
				).on("click",function(){
					active($(this).attr("menu-name"));
				})
			);
			
			return that;
		}
		
		var addAction = function(action){
			var actionMenu=that.menuContener.find("li[menu-name='"+action+"']");
			
			if(actionMenu.length > 0){
				var nbAction=parseInt(actionMenu.find(".badge").text());
				
				actionMenu.find(".badge").text(nbAction+1);
			}else{
				that.menuContener.append(
					$("<li>",{"menu-name" : action}).append(
						$("<a>",{"href":"#"+action}).text(action).append(
							$("<span>").addClass('badge').text(1)
						)
					).on("click",function(){
						active($(this).attr("menu-name"));
					})
				);
			}
			
			var allBadge=that.menuContener.find("li[menu-name='all'] .badge");
			var nbAction=parseInt(allBadge.text());
			
			allBadge.text(nbAction+1);
			
			return that;
		}
		
		var active = function(name){
			that.menuContener.find("li.active").each(function(){
				$(this).removeClass("active");	
			});
			
			that.menuContener.find('li[menu-name="'+name+'"]').addClass("active");
			
			that.parent().trigger({
				type: "dataTrieMenuActivate",
				message: name,
				time: new Date()
			});
			
			return that;
		};
		
		var methods={
			active : function(name){ return active(name)},
			loadMenu : function(data){ return loadMenu(data)},
			addAction : function(action){ return addAction(action)}
		};
		
		
		
		that.doPublicMethod=function(method,args){
			if ( methods[method] ) {
				return methods[ method ].apply( that, Array.prototype.slice.call( args, 1 ));
			} else{
				$.error( 'Method ' +  method + ' does not exist on jQuery.dataTrieMenu' );
			}
		}
		
		
		// Prise en compte des options utilisateurs
		that.parametres=$.extend(defauts, methodOrOptions);
		return initialize();
		
    };
	
	
	
})(jQuery);