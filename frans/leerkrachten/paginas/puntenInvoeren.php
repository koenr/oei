
<?php
$leerling = new Leerling($_GET['inschrijvingsnummer']);
$voornaam = $leerling->geefVoornaam();
$achternaam = $leerling->geefAchternaam();

$semester = $_GET['semester'];
if($semester == 1){
	$punten_db = $leerling->geefSem1Punten();
	$totaal_db = $leerling->geefSem1Totaal();
}else{
	$punten_db = $leerling->geefSem2Punten();
	$totaal_db = $leerling->geefSem2Totaal();
}
?>

<div align="center" style="font-size:1.5em;">
Punten invoeren voor <span style="font-weight:bold;"><?php echo $voornaam." ".$achternaam;?></span>
<br>
Semester <?php echo $semester; ?>
</div>
<div align="center" class="fullborderradius" style="margin-left:40%;margin-top:20px;width:300px;" >
<form method="post" >
	<b>Punten invoeren: </b><br>
	<input type="text" size="1" style="border:none;" name="punten" value="<?php echo $punten_db?>" /> op <input type="text" style="border:none;" size="1" name="totaal" value="<?php echo $totaal_db; ?>"/><br> 
	
	<input type="submit" name="punteninvoeren" value="Voer punten in" />
	<input type="submit" name="semesternietverbeterd" value="Semester terug instellen als NIET verbeterd"/>
</form>
</div>
<?php 
if(isset($_POST['punteninvoeren'])){
	if($leerkracht->voerPuntenIn($_GET['inschrijvingsnummer'], $_GET['semester'], $_POST['punten'], $_POST['totaal'])){
		echo"<script>herladenleerling('".$_GET['inschrijvingsnummer']."');</script>";
	}else{
		echo"O jee! Er is iets misgelopen.";
	}
}

if(isset($_POST['semesternietverbeterd'])){
	if($leerkracht->semesterNietVebeterd($_GET['inschrijvingsnummer'],  $_GET['semester'])){
		echo"<script>herladenleerling('".$_GET['inschrijvingsnummer']."');</script>";
	}else{
		echo"O jee! Er is iets misgelopen.";
	}
}
?>
