<html>
	<head>
		<link rel="stylesheet" href="css/bootstrap-3.3.5/css/bootstrap.min.css">
		<link rel="stylesheet" href="css/bootstrap-3.3.5/css/bootstrap-theme.min.css">
		
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
	
	
	
		<div class="container">
			<div class="row">
				<div class="col-lg-4">
					<div class="input-group">
						<select class="form-control">
							<option>1</option>
							<option>2</option>
						</select>
						<div class="input-group-btn">
	        				<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action <span class="caret"></span></button>
	        				<ul class="dropdown-menu dropdown-menu-right">
				          		<li><a href="#">Supprimer all</a></li>
	        				</ul>
	      				</div>
	      			</div>
				</div>
				
				<div class="col-lg-4">
					<div class="input-group">
						<input type="text" class="form-control" placeholder="Search for...">
			      		<span class="input-group-btn">
			        		<button class="btn btn-default" type="button">Search</button>
			      		</span>
				    </div>
				</div>
			</div>
			
		
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
	</body>
</html>