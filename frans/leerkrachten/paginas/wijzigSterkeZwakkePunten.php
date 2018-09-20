<?php 
$leerling = $leerkracht->geefLeerling($_GET['inschrijvingsnummer']);
$inschrijvingsnummer = $leerling->geefInschrijvingsnummer();
$voornaam = $leerling->geefVoornaam();
$achternaam = $leerling->geefAchternaam();
$gebruiker_id = $leerling->geefGebruikerID();

$klas_id = $leerling->geefKlasID();
$jaar = $leerling->klasIDNaarJaar($klas_id);


?>



<div align="center" style="font-size:1.5em;">
Verander de actiepunten van <span style="font-weight:bold;"><?php echo $voornaam." ".$achternaam;?></span>
</div>

<?php 
if(!isset($_POST['wijzigpunt'])){
?>
<div style="margin-left:200px; margin-right:auto;">
<form method="post" name="klassen">
	
<?php 


for($semester=1;$semester<=2;$semester++){ //eerste en tweede semester
?>

<div class="sterkezwakkepuntenlijst">
<b>Semester <?php echo $semester;?></b><br>
<hr>


<table><tr>
<?php 
for($i=0;$i<=0;$i++){ //Sterk/zwak
if($i=="0"){$type="sterk";}else{$type="zwak";}
	?>
	<td>
	<div class="sterkezwakkepuntensublijst">
	<b><?php if($i==0){echo"Point d’action";}else{echo"Point Faible";}?></b><br><hr>
		<table>
	<?php 
$sterkezwakkepunten = $leerkracht->geefSterkeZwakkePunten($jaar);
		


	foreach($sterkezwakkepunten as $nr=>$punt){
		$hash = md5(microtime()); //random id maken
		$checked = "";
		$omschrijving = HelperFuncties::escapeForHtmlUse($punt['omschrijving']);
		$puntid = HelperFuncties::escapeForHtmlUse($punt['id']);
		$semestertype = $semester . " " . $type;
		if($leerling->geefSterkZwakPunt($type,$semester) == $punt['id'])
			$checked = "checked='checked'";
		$html = <<<html
		<tr><td><input $checked type='radio' name='sem_$semestertype' id='$hash' value='$puntid'/></td><td><div onclick=javascript:document.getElementById('$hash').checked = 'checked'>$omschrijving</div></td></tr>
html;
		echo $html;
		/*
		//echo $punt['id'];
		echo"<tr><td><input ";
			if($leerling->geefSterkZwakPunt($type,$semester) == $punt['id']){echo "checked='checked'";}
		echo "type='radio' name='sem".$semester."_".$type."' id='".$hash."' value='".$punt['id']."'/></td><td><div onclick=\"javascript:document.getElementById('".$hash."').checked = 'checked'\">".$punt['omschrijving']."</div></td></tr>";
		*/
	}
	echo "</table></div></td>";
}
?>
</tr>

</table>
</div>
</div>
<?php } ?><br><br><br><br><br><br><br>
<input type="submit" name="wijzigpunt" value="Wijzigingen opslaan"/>

</form>
<button onclick="herladenleerling('<?php echo $inschrijvingsnummer; ?>');">Annuleren</button>

<?php 
}else{
	foreach($_POST as $naam=>$waarde){
		$$naam = $waarde;
	}
	$sem1_sterk = $_POST['sem_1_sterk'];
	$sem2_sterk = $_POST['sem_2_sterk'];
	$sem1_zwak = $_POST['sem_1_zwak'];
	$sem2_zwak = $_POST['sem_2_zwak'];
	if ($leerkracht->wijzigSterkeZwakkePunten($inschrijvingsnummer, $sem1_sterk, $sem1_zwak, $sem2_sterk, $sem2_zwak)){
		echo"De actiepunten zijn succesvol gewijzigd.";
		echo"<br><br>
			<button onclick=\"herladenleerling('$inschrijvingsnummer');\">Ga terug naar de leerling</button>
		";
	}else{
		echo"O jee! Er is iets foutgelopen.";
	}
}
?>

</div>


