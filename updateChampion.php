<?php
//Turn on error reporting
ini_set('display_errors', 'On');
//Connects to the database
$mysqli = new mysqli("oniddb.cws.oregonstate.edu","lieny-db","Yu11vLvDOEigJONz","lieny-db");
if($mysqli->connect_errno){
	echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}

if(!($stmt = $mysqli->prepare("UPDATE Champion SET
				baseAD=?, baseArmor=?, baseMP=?, baseHP=?, fk_regionID=?, fk_damageID=?
				WHERE championID=?"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}

if(!($stmt->bind_param("ssssiii",$_POST['baseAD'],$_POST['baseArmor'],$_POST['baseMP'],$_POST['baseHP'],$_POST['region'], $_POST['damage'], $_POST['name']))){
	echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
}

if(!$stmt->execute()){
	echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
} else {
	echo "Added " . $stmt->affected_rows . " rows to the Plays Table.";
}
?>

<!-- -------------------------------- Display Champions   ------------------------ -->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
	 <meta charset="utf-8">
	<style>
	table {
    		border-collapse: collapse;
    		width: 100%;
	}

	th, td {
 		text-align: left;
  		padding: 8px;
	}

	tr:nth-child(even){background-color: #f2f2f2}

	th {
   		background-color: #ffb6c1;
   		color: white;
	}
	</style>
	<title>Champion Roles</title>
	</head>
<body>
 <div>
	<h2>League of Legends Champions</h2>
        <table>
            <tr>
                <th>Name</th>
                <th>Base Attack Damage</th>
                <th>Base Armor</th>
                <th>Base Mana</th>
                <th>Base Health</th>
                <th>Region</th>
                <th>Damage Type</th>
            </tr>
            
        <?php
        if(!($stmt = $mysqli->prepare("SELECT Champion.name, Champion.baseAD, Champion.baseArmor, 
	Champion.baseMP, Champion.baseHP, Region.name, Damage.type FROM Champion 
        	INNER JOIN Region ON Region.regionID = Champion.fk_regionID
        	INNER JOIN Damage ON Damage.damageID = Champion.fk_damageID
		GROUP BY Champion.name"))){
            echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
        }

        if(!$stmt->execute()){
            echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
        }
        if(!$stmt->bind_result($name, $baseAD, $baseArmor, $baseMP, $baseHP, $region, $damage)){
            echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
        }
        while($stmt->fetch()){
         echo "<tr>\n<td>\n" . $name . "\n</td>\n<td>\n" . $baseAD . "\n</td>\n<td>\n" . $baseArmor . 
		"\n</td>\n<td>\n". $baseMP . "\n</td>\n<td>\n" . $baseHP . 
		"\n</td>\n<td>\n" . $region . "\n</td>\n<td>\n" . $damage . 
		"\n</td>\n</tr>";
        }
        $stmt->close();
        ?>             
        </table>
    </div>
 

</body>
</html>

