<?php
	require_once("config.php");

	if(isset($_GET['action'])){
		$action=$_GET['action'];
	}else{
		$action="undefined";
	}

	$date=new DateTime();
	$date->setTimezone(new DateTimeZone("Europe/Paris"));
	
	$ip=$_SERVER["REMOTE_ADDR"];
	
	
	$bdd = new PDO('mysql:host='.BDD_HOST.';dbname='.BDD_NAME.';charset=utf8', BDD_USER, BDD_PASS);
	
	
	$insert_action = "INSERT INTO getter_action 
					(name,date,ip) 
					VALUES 
					(:name,:date,:ip)";
	$stmt = $bdd->prepare($insert_action);
	$stmt->bindParam(':name', $action, PDO::PARAM_STR);
	$stmt->bindParam(':date', $date->format("Y-m-d H:i:s"));
	$stmt->bindParam(':ip', $ip);
	$stmt->execute();
	$action_id=$bdd->lastInsertId();
	
	$inser_value="INSERT INTO getter_value 
					(id_action,name,value) 
					VALUES 
					(:id_action,:name,:value)";
	foreach($_GET as $name => $value){
		if($name!="action"){
			$stmt = $bdd->prepare($inser_value);
			$stmt->bindParam(':id_action', $action_id, PDO::PARAM_INT);
			$stmt->bindParam(':name', $name,PDO::PARAM_STR);
			$stmt->bindParam(':value', $value,PDO::PARAM_STR);
			$stmt->execute();
		}
	}
	
?>