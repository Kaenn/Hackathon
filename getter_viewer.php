<html>
	<head>
		<link rel="stylesheet" href="css/bootstrap-3.3.5/css/bootstrap.min.css">
		<link rel="stylesheet" href="css/bootstrap-3.3.5/css/bootstrap-theme.min.css">
		
		<link rel="stylesheet" href="css/getter_viewer.css">
		
		<script src="js/jquery-2.1.4.min.js"></script>
		<script src="css/bootstrap-3.3.5/js/bootstrap.min.js"></script>
	</head>
	<body>
	
		<nav class="navbar navbar-default">
			<div class="container-fluid">
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="#">Hackathon</a>
				</div>
				
				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav">
						<li class="active"><a href="#">Viewer</a></li>
					</ul>
					
				</div><!-- /.navbar-collapse -->
			</div><!-- /.container-fluid -->
		</nav>
	
	
	
		<div>
			<div class="row" id="body-content">
 				<div class="col-md-3" id="body-menu">
 					<div class="sidebar-nav">
						<div class="navbar navbar-inverse" role="navigation">
							<div class="navbar-header">
								<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-navbar-collapse">
									<span class="sr-only">Toggle navigation</span>
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
								</button>
								<span class="visible-xs navbar-brand">Sidebar menu</span>
							</div>
							<div class="navbar-collapse collapse sidebar-navbar-collapse">
								<ul class="nav navbar-nav">
									<li><a href="#progressBar">Progresse Bar</a></li>
											
									<li><a href="#gauge">Gauge</a></li>
									
									<li><a href="#alerte">Alerte</a></li>
									
									<li class="active"><a href="#checker">Checker</a></li>
									<li><a href="#chat">Chat</a></li>
									
									<li><a href="#scenario">Scenario</a></li>
								</ul>
							</div><!--/.nav-collapse -->
						</div>
					</div>
 				</div>
 				
 				
 				
 				<div class="col-md-9">
 					<?php
						require_once("config.php");
						
						$bdd = new PDO('mysql:host='.BDD_HOST.';dbname='.BDD_NAME.';charset=utf8', BDD_USER, BDD_PASS);
						
						$res=$bdd->query("SELECT ga.id as id_action, ga.name as action_name, ga.date, ga.ip, gv.name as param_name, gv.value as param_value
									FROM getter_action as ga
									INNER JOIN getter_value as gv
										ON ga.id=gv.id_action
									ORDER BY id_action desc;");
						
						$actions=array();
						while($row=$res->fetch()){
							if(!isset($actions[$row['id_action']])){
								$actions[$row['id_action']]=array(
									"action_name" => $row['action_name'],
									"date" => $row['date'],
									"ip" => $row['ip'],
									"param" => array()
								);
							}
							
							$actions[$row['id_action']]["param"][]=array(
								"param_name" => $row["param_name"],
								"param_value" => $row["param_value"]
							);
						}
						
						foreach($actions as $action){
							echo "<h3>".$action["action_name"]." le ".$action['date']." : ".$action['ip']."</h3>";
							echo "<ul>";
							foreach($action['param'] as $param){
								echo "<li>".$param['param_name']." : ".$param['param_value']."</li>";
							}
							echo "</ul>";
						}
					?>
 				</div>
			</div>
				 

			 
			
		
			
		</div>
	</body>
</html>