<?php
//Turn on error reporting
ini_set('display_errors', 'On');
//Connects to the database
$mysqli = new mysqli("oniddb.cws.oregonstate.edu","lieny-db","Yu11vLvDOEigJONz","lieny-db");
if($mysqli->connect_errno){
	echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}
	
if(!($stmt = $mysqli->prepare("INSERT INTO Champion(name, baseAD, baseArmor, baseMP, baseHP, fk_regionID, fk_damageID) VALUES (?,?,?,?,?,?,?)"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!($stmt->bind_param("sssssii",$_POST['name'],$_POST['baseAD'],$_POST['baseArmor'],$_POST['baseMP'],$_POST['baseHP'],$_POST['region'], $_POST['damage']))){
	echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->execute()){
	echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
} else {
	echo "Added " . $stmt->affected_rows . " rows to Champion.";
}
?>
