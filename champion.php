<?php
//Turn on error reporting
ini_set('display_errors', 'On');
//Connects to the database
$mysqli = new mysqli("oniddb.cws.oregonstate.edu","lieny-db","Yu11vLvDOEigJONz","lieny-db");
if($mysqli->connect_errno){
	echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}
?>

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
	
	input[type=text], select {
    	width: 180px;
    	padding: 12px 20px;
    	margin: 8px 0;
    	display: inline-block;
    	border: 1px solid #ccc;
    	border-radius: 4px;
    	box-sizing: border-box;
	}

	input[type=submit] {
    	width: 120px;
    	background-color: #ffb6c1;
    	color: white;
    	padding: 14px 20px;
    	margin: 8px 0;
    	border: none;
    	border-radius: 4px;
    	cursor: pointer;
	}

	input[type=submit]:hover {
    	background-color: #ffc0cb;
	}

	</style>
	
	<title>League of Legends Project</title>
	</head>
    <body>

<!-- -------------------------------- Display Champion Information  ------------------------ -->
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

    
<!-- ------------------------------------  Region Filter ---------------------------------------- -->        
 	<div>
	<form method="post" action="regionFilter.php">
		<fieldset>
			<legend>Filter By Region</legend>
			<select name="Region">
				<?php
				if(!($stmt = $mysqli->prepare("SELECT regionID, name FROM Region"))){
					echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
				}

				if(!$stmt->execute()){
					echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
				}
				if(!$stmt->bind_result($id, $rname)){
					echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
				}
				while($stmt->fetch()){
					 echo '<option value=" '. $id . ' "> ' . $rname . '</option>\n';
				}
				$stmt->close();
				?>
			</select>
			<p>
			<input type="submit" value="Run Filter" />
			</p>
		</fieldset>
	</form>
</div>
 

<!-- -------------------------------- Add Champion -------------------------------------------- -->
<div>
        <form method="post" action="addChampion.php">  
            <fieldset>
                <legend>Enter Champion Information</legend>
                <p>Name: <input type="text" name="name" /></p>
                <label>Base AD: </label>
		<input type="text" name="baseAD" />
                <label>Base Armor: </label>
		<input type="text" name="baseArmor" /><br>
                <label>Base Mana: </label>
		<input type="text" name="baseMP" />
                <label>Base Health: </label>
		<input type="text" name="baseHP" /><br>

                <legend>Region</legend>
                <select name="region">
                <?php
		if(!($stmt = $mysqli->prepare("SELECT regionID, name FROM Region"))){
			echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
		}

		if(!$stmt->execute()){
			echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
		}
		if(!$stmt->bind_result($rid, $rname)){
			echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
		}
		while($stmt->fetch()){
			echo '<option value=" '. $rid . ' "> ' . $rname . '</option>\n';
		}
		$stmt->close();
		?>    
                </select>

                <legend>Damage Type</legend>
                <select name="damage">
                <?php
		if(!($stmt = $mysqli->prepare("SELECT damageID, type FROM Damage"))){
			echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
		}

		if(!$stmt->execute()){
			echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
		}
		if(!$stmt->bind_result($did, $dname)){
			echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
		}
		while($stmt->fetch()){
			echo '<option value=" '. $did . ' "> ' . $dname . '</option>\n';
		}
		$stmt->close();
		?>    
                </select>
            	<p><input type="submit" name="submit" value="Add Champion"></p>
            </fieldset>
        
        </form>       
    </div> 
<!-- ------------------------------------ Add Region ----------------------------------------- -->
<div>
        <form method="post" action="addRegion.php">  
            <fieldset>
                <legend>Add a Region</legend>
                <label>Region Name: </label>
		<input type="text" name="regionName" /><br>
            	<p><input type="submit" name="submit" value="Add Region"></p>
	   </fieldset>
	</form>
</div>


<!-- ------------------------------------ Add Damage Type ----------------------------------------- -->
<div>
        <form method="post" action="addDamage.php">  
            <fieldset>
                <legend>Add a Damage Type</legend>
                <label>Damage Type: </label>
		<input type="text" name="damageType" /><br>
            	<p><input type="submit" name="submit" value="Add Damage"></p>
	   </fieldset>
	</form>
</div>

  
<!-- ------------------------------------ Add Role ------------------------------------------------ -->

<div>
        <form method="post" action="addRole.php">  
            <fieldset>
                <legend>Add a Role Type</legend>
                <label>Role Type: </label>
		<input type="text" name="roleType" /><br>
            	<p><input type="submit" name="submit" value="Add Role"></p>
	   </fieldset>
	</form>
</div>

<!-- ---------------------------------------- Add Plays --------------------------------------------- -->
<div>
        <form method="post" action="addPlays.php">  
            <fieldset>
                <legend>Add Role Played by Champion</legend>
                <select name="champName">
                <?php
		if(!($stmt = $mysqli->prepare("SELECT championID, name FROM Champion"))){
			echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
		}

		if(!$stmt->execute()){
			echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
		}
		if(!$stmt->bind_result($cid, $cname)){
			echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
		}
		while($stmt->fetch()){
			echo '<option value=" '. $cid . ' "> ' . $cname . '</option>\n';
		}
		$stmt->close();
		?>    
                </select>

		<select name="roleName">
                <?php
		if(!($stmt = $mysqli->prepare("SELECT roleID, type FROM Role"))){
			echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
		}

		if(!$stmt->execute()){
			echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
		}
		if(!$stmt->bind_result($roid, $roname)){
			echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
		}
		while($stmt->fetch()){
			echo '<option value=" '. $roid . ' "> ' . $roname . '</option>\n';
		}
		$stmt->close();
		?>    
                </select>

            	<p><input type="submit" name="submit" value="Add "></p>
	   </fieldset>
	</form>
</div>



<!-- ------------------------------------ Add Starter Item ---------------------------------------- -->
<div>
        <form method="post" action="addItem.php">  
            <fieldset>
                <legend>Add a Starter Item</legend>
                <label>Item Name: </label>
		<input type="text" name="itemName" /><br>
            	<p><input type="submit" name="submit" value="Add Item"></p>
	   </fieldset>
	</form>
</div>


<!-- ------------------------------------ Add Uses ------------------------------------------------ -->
<div>
        <form method="post" action="addUses.php">  
            <fieldset>
                <legend>Add a Starter Item to a Champion</legend>
                <select name="champName">
                <?php
		if(!($stmt = $mysqli->prepare("SELECT championID, name FROM Champion"))){
			echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
		}

		if(!$stmt->execute()){
			echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
		}
		if(!$stmt->bind_result($cid, $cname)){
			echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
		}
		while($stmt->fetch()){
			echo '<option value=" '. $cid . ' "> ' . $cname . '</option>\n';
		}
		$stmt->close();
		?>    
                </select>

		<select name="itemName">
                <?php
		if(!($stmt = $mysqli->prepare("SELECT itemID, name FROM StarterItem"))){
			echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
		}

		if(!$stmt->execute()){
			echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
		}
		if(!$stmt->bind_result($roid, $roname)){
			echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
		}
		while($stmt->fetch()){
			echo '<option value=" '. $roid . ' "> ' . $roname . '</option>\n';
		}
		$stmt->close();
		?>    
                </select>

            	<p><input type="submit" name="submit" value="Add "></p>
	   </fieldset>
	</form>
</div>

<!-- --------------------------------- Delete Item from Champion ----------------------------------------- -->
<div>
        <form method="post" action="deleteUses.php">  
            <fieldset>
                <legend>Delete a Starter Item from a Champion</legend>
                <select name="champName">
                <?php
		if(!($stmt = $mysqli->prepare("SELECT Champion.championID, Champion.name FROM Champion 
						INNER JOIN Uses ON Uses.fk_championID=Champion.championID
						GROUP BY Champion.name"))){
			echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
		}

		if(!$stmt->execute()){
			echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
		}
		if(!$stmt->bind_result($cid, $cname)){
			echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
		}
		while($stmt->fetch()){
			echo '<option value=" '. $cid . ' "> ' . $cname . '</option>\n';
		}
		$stmt->close();
		?>   
                </select>

		<select name="itemName">
                <?php
		if(!($stmt = $mysqli->prepare("SELECT StarterItem.itemID, StarterItem.name FROM StarterItem
						INNER JOIN Uses ON Uses.fk_itemID=StarterItem.itemID
						GROUP BY StarterItem.name"))){
			echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
		}

		if(!$stmt->execute()){
			echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
		}
		if(!$stmt->bind_result($sid, $sname)){
			echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
		}
		while($stmt->fetch()){
			echo '<option value=" '. $sid . ' "> ' . $sname . '</option>\n';
		}
		$stmt->close();
		?>    
                </select>


            	<p><input type="submit" name="submit" value="Delete "></p>
	   </fieldset>
	</form>
</div>

<!-- -------------------------------- Add Champion -------------------------------------------- -->
<div>
        <form method="post" action="updateChampion.php">  
            <fieldset>
                <legend>Update Champion Information</legend>
                <legend>Name: </legend>
		<select name="name">
                <?php
		if(!($stmt = $mysqli->prepare("SELECT championID, name FROM Champion"))){
			echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
		}

		if(!$stmt->execute()){
			echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
		}
		if(!$stmt->bind_result($cid, $cname)){
			echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
		}
		while($stmt->fetch()){
			echo '<option value=" '. $cid . ' "> ' . $cname . '</option>\n';
		}
		$stmt->close();
		?>    
                </select>

                <label>Base AD: </label>
		<input type="text" name="baseAD" />
                <label>Base Armor: </label>
		<input type="text" name="baseArmor" /><br>
                <label>Base Mana: </label>
		<input type="text" name="baseMP" />
                <label>Base Health: </label>
		<input type="text" name="baseHP" /><br>

                <legend>Region</legend>
                <select name="region">
                <?php
		if(!($stmt = $mysqli->prepare("SELECT regionID, name FROM Region"))){
			echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
		}

		if(!$stmt->execute()){
			echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
		}
		if(!$stmt->bind_result($rid, $rname)){
			echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
		}
		while($stmt->fetch()){
			echo '<option value=" '. $rid . ' "> ' . $rname . '</option>\n';
		}
		$stmt->close();
		?>    
                </select>

                <legend>Damage Type</legend>
                <select name="damage">
                <?php
		if(!($stmt = $mysqli->prepare("SELECT damageID, type FROM Damage"))){
			echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
		}

		if(!$stmt->execute()){
			echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
		}
		if(!$stmt->bind_result($did, $dname)){
			echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
		}
		while($stmt->fetch()){
			echo '<option value=" '. $did . ' "> ' . $dname . '</option>\n';
		}
		$stmt->close();
		?>    
                </select>
            	<p><input type="submit" name="submit" value="Update Champion"></p>
            </fieldset>
        
        </form>       
    </div> 

<!-- --------------------------------- Delete a Champion ----------------------------------------- -->
<div>
        <form method="post" action="deleteChampion.php">  
            <fieldset>
                <legend>Delete a Champion</legend>
                <select name="champName">
                <?php
		if(!($stmt = $mysqli->prepare("SELECT Champion.championID, Champion.name FROM Champion"))){
			echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
		}

		if(!$stmt->execute()){
			echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
		}
		if(!$stmt->bind_result($cid, $cname)){
			echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
		}
		while($stmt->fetch()){
			echo '<option value=" '. $cid . ' "> ' . $cname . '</option>\n';
		}
		$stmt->close();
		?>  
                </select>
            	
		<p><input type="submit" name="submit" value="Delete "></p>
    	 </fieldset>
        
     </form>       
</div> 


    </body>
</html>
