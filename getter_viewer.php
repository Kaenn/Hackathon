<html>
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
</html>