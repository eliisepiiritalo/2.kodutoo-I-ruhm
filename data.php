<?php 

	require("function.php");

	// kas on sisseloginud, kui ei ole siis

	// suunata login lehele

	if (!isset ($_SESSION["userId"])) {

		header("Location: login.php");
		exit();

	}

	//kas ?logout on aadressireal

	if (isset($_GET["logout"])) {

		session_destroy();

		header("Location: login.php");
		exit();

	}

			// echo $date
			
	//muutujad
	$Gender="";
	$GenderError="";
	$Age="";
	$AgeError="";
	$Meal="";
	$MealError="";
	$Date="";
	$DateError="";
	
	//Kontrollin, kas kasutaja sisestas andmed
	if(isset($_POST["Age"])) {
			if (empty($_POST["Age"])){
			$AgeError="See väli on kohustuslik!";
			
			}else {
				$Age=$_POST["Age"];
			}
	}
	
	if(isset($_POST["Meal"])) {
		if(empty($_POST["Meal"])){
			$MealError="See väli on kohustuslik!";
			
		}else{
			$Meal=$_POST["Meal"];
		}
	}
	
	if(isset($_POST["Date"])) {
		if(empty($_POST["Date"])){
			$DateError="See väli on kohustuslik!";
			
		}else{
			$Date=$_POST["Date"];
		}
	}
	//Ühtegi viga ei olnud ja saan kasutaja andmed salvestada
	if ( isset($_POST["Gender"]) &&
		isset($_POST["Age"]) &&
		isset($_POST["Meal"]) &&
		isset($_POST["Date"]) &&
		
		
		empty($_POST["GenderError"]) &&
		empty($_POST["AgeError"]) &&
		empty($_POST["MealError"]) &&
		empty($_POST["DateError"])  

	  ) {
		  
		  echo "siin";
		  
			$Gender=cleanInput($_POST["Gender"]);
			$Age=cleanInput($_POST["Age"]);
			$Meal=cleanInput($_POST["Meal"]);
			//$Date=cleanInput($_POST["Date"]);

			$date = new Datetime ($_POST['Date']);
			$date = $date->format('Y-m-d');
		
			savePeople($_POST["Gender"], $_POST["Age"], $_POST["Meal"], $date);
	
	//header("Location: data.php");
	//exit();
	
	}

	$people = getAllPeople();
	
	//var_dump($people[1]);
	
?>

<h1>Toidukordade sisestamine</h1>

<p>

	Tere tulemast <?=$_SESSION["Email"];?>!

	<a href="?logout=1">Logi välja</a>

</p> 

<h1>Salvesta andmed</h1>

<form method="POST">

	<label>Sugu</label><br>
	
	<input type="radio" name="Gender" value="male" > Mees<br>

	<input type="radio" name="Gender" value="female" > Naine<br>
	
	<br><br>
	<label>Vanus</label><br>
	<input name="Age" type="number">

	<br><br>
	<label>Söögikord</label><br>
	<select name="Toidukord">
	<option value="" disabled selected>Vali söögikord</option>
	<option value="Hommikusöök">Hommikusöök</option>
	<option value="Lõunasöök">Lõunasöök</option>
	<option value="Õhtusöök">Õhtusöök</option>
	</select>
	
	
	<input name="Meal" type="text" placeholder="sisaldab">
	<br><br>
	
	<label>Kuupäev</label><br>
	<input name="Date" type="date" placeholder="Kuupäev">
	

	
	<br><br>
	<input type = "submit" value = "Salvesta">

	<!--<input type="text" name="gender" ><br>-->
	
	


</form>

<!--<h2>Varasemad andmed</h2>

		foreach($people as $p){
			
			echo "<h3 style=' Color:".$p->Color."; '>".$p->Gender."</h3>;
		}
		
	-->

<br><br>	
<h2> Kasutajate andmed </h2>
<?php

		$html="<table>";
				$html .="<tr>";
					$html .="<th>id</th>";
					$html .="<th>Sugu</th>";
					$html .="<th>Vanus</th>";
					$html .="<th>Söögikord</th>";
					$html .="<th>Kuupäev</th>";
				$html .="</tr>";
				
				foreach($people as $p){
					$html .="<tr>";
							$html .="<td>".$p->id."</td>";
							$html .="<td>".$p->Gender."</td>";
							$html .="<td>".$p->Age."</td>";
							$html .="<td>".$p->Meal."</td>";
							$html .="<td>".$p->date."</td>";
							//$html .="<td style=' backround-color:".$p->Color."; '>$p->Color."</td>";
							//<img width="200" src=' ".$url." '>
					
					$html .="</tr>";
									
							
				}
		$html .="</table>";
		echo $html;
	
?>