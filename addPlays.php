<?php
//Turn on error reporting
ini_set('display_errors', 'On');
//Connects to the database
$mysqli = new mysqli("oniddb.cws.oregonstate.edu","lieny-db","Yu11vLvDOEigJONz","lieny-db");
if($mysqli->connect_errno){
	echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}

if(!($stmt = $mysqli->prepare("INSERT INTO Plays(fk_championID, fk_roleID) VALUES (?,?)"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!($stmt->bind_param("ii",$_POST['champName'],$_POST['roleName']))){
	echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->execute()){
	echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
} else {
	echo "Added " . $stmt->affected_rows . " rows to the Plays Table.";
}
?>

<!-- -------------------------------- Display Champions with the Roles They Play  ------------------------ -->

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
	<h2>Champions and Their Roles</h2>
        <table>
            <tr>
                <th>Name</th>
                <th>Role Type</th>
            </tr>
            
        <?php
        if(!($stmt = $mysqli->prepare("SELECT Champion.name, Role.type FROM Champion 
        	INNER JOIN Plays ON Plays.fk_championID = Champion.championID
		INNER JOIN Role ON Role.roleID = Plays.fk_roleID"))){
            echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
        }

        if(!$stmt->execute()){
            echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
        }
        if(!$stmt->bind_result($name, $role)){
            echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
        }
        while($stmt->fetch()){
         echo "<tr>\n<td>\n" . $name . "\n</td>\n<td>\n" . $role . "\n</td>\n</tr>";
        }
        $stmt->close();
        ?>             
        </table>
    </div>
</body>
</html>

