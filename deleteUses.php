<?php
//Turn on error reporting
ini_set('display_errors', 'On');
//Connects to the database
$mysqli = new mysqli("oniddb.cws.oregonstate.edu","lieny-db","Yu11vLvDOEigJONz","lieny-db");
if($mysqli->connect_errno){
	echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}
	
if(!($stmt = $mysqli->prepare("DELETE FROM Uses WHERE fk_championID=? AND fk_itemID=?"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!($stmt->bind_param("ii",$_POST['champName'],$_POST['itemName']))){
	echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->execute()){
	echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
} else {
	echo "Removed " . $stmt->affected_rows . " rows to the Usess Table.";
}
?>
<!-- -------------------------------- Display Starter Item Information  ------------------------ -->
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
	<h2>Champions and Their Starter Items</h2>
        <table>
            <tr>
                <th>Name</th>
                <th>Item Name</th>
            </tr>
            
        <?php
        if(!($stmt = $mysqli->prepare("SELECT Champion.name, StarterItem.name FROM Champion 
        	INNER JOIN Uses ON Uses.fk_championID = Champion.championID
		INNER JOIN StarterItem ON StarterItem.itemID = Uses.fk_itemID
		ORDER BY Champion.name"))){
            echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
        }

        if(!$stmt->execute()){
            echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
        }
        if(!$stmt->bind_result($name, $item)){
            echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
        }
        while($stmt->fetch()){
         echo "<tr>\n<td>\n" . $name . "\n</td>\n<td>\n" . $item . "\n</td>\n</tr>";
        }
        $stmt->close();
        ?>             
        </table>
    </div>
</body>
</html>
