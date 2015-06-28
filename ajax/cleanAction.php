<?php
	require_once("../config.php");
 								
 	$bdd = new PDO('mysql:host='.BDD_HOST.';dbname='.BDD_NAME.';charset=utf8', BDD_USER, BDD_PASS);

 	$name=$_POST['action'];
 	
 	$nbSuppressParam=0;
 	$nbSuppressAction=0;
 	if($name!="all"){
	 	$requete1="SELECT id FROM getter_action WHERE name='".$name."'";
	 	echo $requete1;
	 	$res=$bdd->query($requete1);
	 	
	 	while($row=$res->fetch()){
	 		$id_action=$row['id'];
	 		
 		
	 		$requete2="DELETE FROM getter_value WHERE id_action=".$id_action;
	 		$requete3="DELETE FROM getter_action WHERE id=".$id_action;
	 		
	 		$nbSuppressParam+=$bdd->exec($requete2);
	 		$nbSuppressAction+=$bdd->exec($requete3);
	 	}
 	}else{
 		$requete2="DELETE FROM getter_value";
 		$requete3="DELETE FROM getter_action";	
 		
 		$nbSuppressParam=$bdd->exec($requete2);
 		$nbSuppressAction=$bdd->exec($requete3);
 	} 		
 	
 	
 			

 	echo "Param : ".$nbSuppressParam." / Action : ".$nbSuppressAction;
 
?>