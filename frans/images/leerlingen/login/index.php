<?php

function __autoload($class){
	require_once '../../phpklassen/'.$class.'.php';
}
?>

<html>
	<head>
		<link rel="stylesheet" type="text/css" href="../../styles/style.css" />
		<link rel="stylesheet" type="text/css" href="../../styles/leerkrachten.css" />
		
		<link rel="shortcut icon" href="../images/favicon.png">
		
		<script LANGUAGE="JavaScript" SRC="../../js/scripts.js"></script>
		<script LANGUAGE="JavaScript" SRC="../../js/layoutEGG.js"></script>
	</head>

<body style="text-align:center"; background="../../images/achtergronden/gnome-green.png">
<div align="center" style="margin-top:50px;">

<span style="font-size:3em;">OEI 1.0 </span>- <span style="font-size:1em;">Thomas Goossens</span><br><br>

<?php 
$verbinding = new Verbinding();
$verbinding->connect();

$inschrijvingsnummer = $_GET['inschrijvingsnummer'];
$voornaam = $_GET['voornaam'];
$achternaam = $_GET['achternaam'];

$leerkracht = new Leerkracht(); //leerkrachtfuncties gebruiken

/* INSCHRIJVINGSNUMMER MOET TEN ALLENTIJDE MEEGEGEVEN WORDEN 
 * enkel bij registratie moeten ook naam en voornaam meegegeven worden
 */
if(isset($_GET['inschrijvingsnummer'])){

if(Gebruiker::bestaatGebruiker("".$_GET['inschrijvingsnummer']."")){
	/* LOGIN */ 
	$leerling = new Leerling($_GET['inschrijvingsnummer']);
	$voornaam = $leerling->geefVoornaam();
	$achternaam = $leerling->geefAchternaam();
	
	echo<<<HTML
	Hallo $voornaam,<br><br>
		Gelieve je wachtwoord op te geven:<br><br>
	<form method="post" action="../index.php">
<table>
<tr>
	<td></td>
	<td><input type="hidden" name="gebruikersnaam" value="$inschrijvingsnummer"/></td>
</tr>

<tr>
	<td><b>Wachtwoord:</b></td>
	<td><input type="password" name="wachtwoord" /></td>
</tr>

<tr><td><input type="submit" name="fff_inloggen" value="Inloggen"></td></tr>

</table>
</form> 
	
HTML;
	
}else{
	/* REGISTRATIE */
	
	//VOORNAAM & ACHTERNAAM MOETEN MEEGEGEVEN WORDEN
	if(isset($_GET['voornaam']) && isset($_GET['achternaam'])){
	
	if(!isset($_POST['stap'])){$stap = 1;}else{$stap = $_POST['stap'];}
	
	echo "<h2>Stap ".$stap."</h2>";
	
	if(!isset($_POST['stap'])){
	echo<<<HTML
	Hallo $voornaam $achternaam,<br><br>
		
		Om te beginnen moet je eerst wat gegevens opgeven:
		<br><br>
		
		
HTML;

	$klassen_ophalen = mysqli_query(Verbinding::$link,"SELECT * FROM klassen WHERE jaar != '0' ORDER BY jaar ASC, klasnaam ASC ");
	
	?>
		<form method="post" >
<table>
<tr>
	<td><input type="hidden" name="stap" value="2"/></td>
	<td><input type="hidden" name="gebruikersnaam" value="<?php echo $inschrijvingsnummer ?>"/></td>
</tr>

<tr>
	<td>Klas: </td>
	<td>
		<select name="klas_id">
	<?php 
		while($klassen = mysqli_fetch_assoc($klassen_ophalen)){
			echo"<option value='".$klassen['id']."' >".$klassen['klasnaam']."</option>";
		}
	?>
		</select>
	</td>
</tr>

<tr>
	<td><b>Klasnr</b></td>
	<td><input type="text	" name="klasnr" value=""/></td>
</tr>

<tr><td><input type="submit" name="opslaan" value="Volgende stap"></td></tr>

</table>
</form> 
	
<?php 
	}elseif($_POST['stap'] == 2){
		/* STAP 2 */
		
		$leerling = new Leerling();
		
/* DATA UIT VORIGE STAP DAT DOORGSTUURD MOET WORDEN NAAR VOLGENDE STAP */
$klas_id = $_POST['klas_id'];
$klasnr = $_POST['klasnr'];

//////////////////////:

		
		if($leerling->klasIDNaarJaar($_POST['klas_id'])>=5){
				//enkel 5 & 6 krijgen dit te zien
$jaar = $leerling->klasIDNaarJaar($_POST['klas_id']);				
?>
		
		
				
<div align="center" style="font-size:1.5em;">
Sterke & Zwakke punten aanduiden<span style="font-weight:bold;"></span>
</div>

<?php 

?>

		<script>
		// wordt niet meer gebruikt
			function checksterkezwakkepunten(){
				var sterkpunt1 = sem1_sterk_var;
				var sterkpunt2 = sem2_sterk_var;
				var zwakpunt1 = sem1_zwak_var;
				var zwakpunt2 = sem2_zwak_var;

				//alert(sterkpunt1);
				var punten = new Array();
				punten[0] = sterkpunt1;
				punten[1] = sterkpunt2;
				punten[2] = zwakpunt1;
				punten[3] = zwakpunt2;

				var ok = true;
				for(var i=0;i<4;i++){

					for(var a=0;a<4;a++){
						if(a!==i){
							if(punten[a] == punten[i]){
								ok = false;
							}
						}
					}
				}
				
				if(ok){
				
						document.getElementById('info').innerHTML = "<span style='color:green' >BETA Alles ok</span><br> ";
						document.getElementById('registreren').style.visibility = "visible";
				
				}else{
					document.getElementById('info').innerHTML = "<span style='color:red' >BETA Je hebt twee maal hetzelfde gekozen</span>";
					document.getElementById('registreren').style.visibility = "hidden";
				}
			}
			
		</script>
<div style="margin-left:200px; margin-right:auto;">
<form method="post" name="klassen">
	<input type="hidden" name="klas_id" value="<?php echo $klas_id;?>">
	<input type="hidden" name="klasnr" value="<?php echo $klasnr;?>">
	<input type="hidden" name="stap" value="3">
<?php 


for($semester=1;$semester<=2;$semester++){ //eerste en tweede semester
?>

<div class="sterkezwakkepuntenlijst">
<b>Semester <?php echo $semester;?></b><br>
<hr>


<table><tr>
<?php 
for($i=0;$i<=1;$i++){ //Sterk/zwak
if($i=="0"){$type="sterk";}else{$type="zwak";}
	?>
	<td>
	<div class="sterkezwakkepuntensublijst">
	<b><?php if($i==0){echo"Point Fort";}else{echo"Point Faible";}?></b><br><hr>
		<table>
	<?php 
$sterkezwakkepunten = $leerling->geefSterkeZwakkePunten($jaar);
		
	foreach($sterkezwakkepunten as $nr=>$punt){
		$hash = md5(microtime()); //random id maken
		echo "<script>var sem".$semester."_".$type."_var = '".$punt['id']."'</script>";
		//echo $punt['id'];
		echo"<tr><td><input onclick='checksterkezwakkepunten()'";
			if($leerling->geefSterkZwakPunt($type,$semester) == $punt['id']){echo "checked='checked'";}
		echo "type='radio' name='sem".$semester."_".$type."' id='".$hash."' value='".$punt['id']."'/></td><td><div onclick=\"javascript:document.getElementById('".$hash."').checked = 'checked'; checksterkezwakkepunten();\">".$punt['omschrijving']."</div></td></tr>";
	}
	?></table></div></td>
	<?php 
}
?>

</tr>

</table>

</div>
</div>

<?php } ?>
<br><br><br><br><br><br><br>

<input type="submit" name="wijzigpunt" value="Volgende stap"/>
<div class="fullborderradius" id='info' style="background-color:lightgrey;width:300px;float:right;"> </div>

</form>


</div>

<?php 
	/* GEEN 3DE GRAAD*/
	}else{
		$klas_id = $_POST['klas_id'];
		$klasnr = $_POST['klasnr'];
		echo"
		<form method='post' >
		<table>
		<tr>
		
			<td>
			<input type='hidden' name='klas_id' value ='".$klas_id."'/>
			<input type='hidden' name='klasnr' value ='".$klasnr."' />
			<input type='hidden' name='stap' value='3' />
			<input type='submit' name='opslaan' value='Volgende stap'></td>
		</tr>

		</table>
		</form> 
		
		";
	}
	
	
	}elseif($_POST['stap'] == 3){
		
		/*
		 *STAP 3 
		 */
		
		// GEGEVENS UIT VORIGE STAP DIE VERDERGSTUURD MOETEN WORDE
		$klas_id = $_POST['klas_id'];
		$klasnr = $_POST['klasnr'];
		$sem1_sterk = $_POST['sem1_sterk'];
		$sem2_sterk = $_POST['sem2_sterk'];
		$sem1_zwak = $_POST['sem1_zwak'];
		$sem2_zwak = $_POST['sem2_zwak'];
		
		
		
		///
		
		?>
		
		<script>
		
			function checkwachtwoorden(){
				var pass1 = document.getElementById('pass1').value;
				var pass2 = document.getElementById('pass2').value;
				if(pass1 == pass2){
					if(pass1 != ""){
						document.getElementById('info').innerHTML = "<span style='color:green' >Wachtwoorden komen overeen</span><br> ";
						document.getElementById('registreren').style.visibility = "visible";
					}else{
						document.getElementById('info').innerHTML = "<span style='color:red' >Gebruik een iets langer wachtwoord aub </span>";
						document.getElementById('registreren').style.visibility = "hidden";
						}
				}else{
					document.getElementById('info').innerHTML = "<span style='color:red' >Wachtwoorden komen NIET overeen </span>";
					document.getElementById('registreren').style.visibility = "hidden";
				}
			}
			
		</script>
		
		<form method="post">
			<input type="hidden" name="klas_id" value ="<?php echo $klas_id?>"/>
			<input type="hidden" name="klasnr" value ="<?php echo $klasnr?>" />
			<input type="hidden" name="sem1_sterk" value ="<?php echo $sem1_sterk; ?>" />
			<input type="hidden" name="sem2_sterk" value ="<?php echo $sem2_sterk; ?>" />
			<input type="hidden" name="sem1_zwak" value ="<?php echo $sem1_zwak; ?>" />
			<input type="hidden" name="sem2_zwak" value ="<?php echo $sem2_zwak; ?>" />
			
			<input type="hidden" name="stap" value ="4" />
			
			<table>
			<tr>
				<td><b>Wachtwoord</b></td>
				<td><input type="password" name="wachtwoord" id="pass1" onkeyup="checkwachtwoorden();"/></td>
			</tr>
			
			<tr>
				<td><b>Wachtwoord herhalen</b></td>
				<td><input type="password" name="wachtwoord2" id="pass2" onkeyup="checkwachtwoorden();"/></td>
			</tr>
			
			<tr>
				<td><input type="submit" name="registreer" id="registreren" value="Registreren" /></td>
			</tr>
			
			</table>
			<div class="fullborderradius" id='info' style="background-color:lightgrey;width:300px;"> </div>
		</form>
		<script>document.getElementById('registreren').style.visibility = "hidden";</script>
		<?php 
	}elseif(isset($_POST['registreer'])){
			$wachtwoord = $_POST['wachtwoord'];
			$wachtwoord2 = $_POST['wachtwoord2'];
			
			$voornaam = $_GET['voornaam'];
			$achternaam = $_GET['achternaam'];
			$klas_id = $_POST['klas_id'];
			$klasnr = $_POST['klasnr'];
			
			$sterkpunt1_id = $_POST['sem1_sterk'];
			$sterkpunt2_id = $_POST['sem2_sterk'];
			$zwakpunt1_id = $_POST['sem1_zwak'];
			$zwakpunt2_id = $_POST['sem2_zwak'];
			
			
			
		if($wachtwoord == $wachtwoord2){
			if(Leerling::registreerLeerling($_GET['inschrijvingsnummer'],$wachtwoord,$voornaam,$achternaam,$sterkpunt1_id,$sterkpunt2_id,$zwakpunt1_id,$zwakpunt2_id,$klas_id,$klasnr)){
				echo"<a href='../login?inschrijvingsnummer=".$_GET['inschrijvingsnummer']."'>Klik hier om in te loggen</a>";
			}else{
			
			}

		}else{
			echo"Wachtwoorden komen niet overeen";
		}
	}
	
	}else{//voornaam &/of achternaam ontbreken
		echo "Oei! Er ontbreken gegevens";
	}
}

}else{
	//Er ontbreken gegevens
	
	echo"Oei! Er ontbreken gegevens";
}
?>
</div>

<br>
<hr>
&copy; Copyright Thomas Goossens - OEI 1.0 
</body>
</html>