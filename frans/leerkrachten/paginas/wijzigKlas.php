<?php 
$leerling = $leerkracht->geefLeerling($_GET['inschrijvingsnummer']);
$inschrijvingsnummer = $leerling->geefInschrijvingsnummer();
$voornaam = $leerling->geefVoornaam();
$achternaam = $leerling->geefAchternaam();
$gebruiker_id = $leerling->geefGebruikerID();
?>




<div align="center" style="font-size:1.5em;">
Verander klas voor <span style="font-weight:bold;"><?php echo $voornaam." ".$achternaam;?></span>
</div>

<?php 
if(!isset($_POST['wijzigklas'])){
?>
<div style="margin-left:200px; margin-right:auto;">
<form method="post" name="klassen">
	
<?php 
for($i=1;$i<=6;$i++){
	$jaarklassen = "klassen_".$i."";
	$$jaarklassen = $leerkracht->geefKlassen($i);
?>

<div class="klassenlijst">
<b><?php echo $i; if($i>1){echo "de";}else{echo "ste";}?> jaar</b><br>
<hr>


<table>
<?php 
$klassen = "klassen_".$i."";
foreach($$klassen as $nr=>$klas){
	echo"<tr><td><input ";
		if($leerling->geefKlasID() == $klas['klas_id']){echo "checked='checked'";}
	echo "type='radio' name='klas_id' value='".$klas['klas_id']."'/></td><td>".$klas['klas']."</td></tr>";
}

?>
</table>
</div>

<?php }?>
<div class="klassenlijst">
<b>Wegklas</b><br>
<hr>


<input type='radio' name='klas_id' value="0" <?php if($leerling->geefKlasID() == 0){echo "checked='checked'";} ?>/>Wegklas<br>

</div>
<br><br><br><br><br><br><br><br>
<b>Klasnr: </b><input size="2" type="text" name="klasnr" value="<?php echo $leerling->geefKlasNr();?>"></input> 
<input type="submit" name="wijzigklas" value="Wijzig de klas en klasnr"/>
</form>
<?php 
}else{
	if ($leerkracht->wijzigKlas($inschrijvingsnummer, $_POST['klas_id'], $_POST['klasnr'])){
		echo"De klas is succesvol gewijzigd.";
		echo"<br><br>
			<button onclick=\"herladenleerling('$inschrijvingsnummer');\">Ga terug naar de leerling</button>
		";
	}else{
		echo"O jee! Er is iets foutgelopen.";
	}
}
?>

</div>


