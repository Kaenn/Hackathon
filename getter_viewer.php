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
 			$actions[$row['id_action']]=array($row['action_name'],$row['date'],array());
 		}
 									
 		$actions[$row['id_action']][2][]=array($row["param_name"],$row["param_value"]);
 	}
 								
 
?>
<!DOCTYPES html>
<html>
	<head>
		<link rel="stylesheet" href="css/bootstrap-3.3.5/css/bootstrap.min.css">
		<link rel="stylesheet" href="css/bootstrap-3.3.5/css/bootstrap-theme.min.css">
		
		<link rel="stylesheet" href="css/plugin/dataTrieMenu.css">
		<link rel="stylesheet" href="css/plugin/dataTrieBody.css">
		
		<link rel="stylesheet" href="css/getter_viewer.css">
		
		<script src="js/jquery-2.1.4.min.js"></script>
		<script src="css/bootstrap-3.3.5/js/bootstrap.min.js"></script>
		
		<script src="js/plugin/dataTrieMenu.js"></script>
		<script src="js/plugin/dataTrieBody.js"></script>
		<script src="js/plugin/dataTrie.js"></script>
		
		<script src="js/getter_viewer.js"></script>
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
 			<script>
 			$(function(){
 				$("#body-content").dataTrie(
 						
 						{
 							"data" : <?php echo json_encode($actions);?>
 						}
 				)
 			});

 			</script>
				 

			 
			
		
			
		</div>
	</body>
</html>