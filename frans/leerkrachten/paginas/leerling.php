<?php
$leerling = new Leerling($_GET['inschrijvingsnummer'],"verbeterd ASC");

/*
 * GET EVENTS 
 * 
 */

/* Blad vergrendelen */
if(isset($_GET['vergrendel'])){
		$leerkracht->vergrendelBlad($_GET['vergrendel']);
	echo "<script>herladenleerling('".$leerling->geefInschrijvingsnummer()."');</script>";
}

if(isset($_GET['ontgrendel'])){
		$leerkracht->ontgrendelBlad($_GET['ontgrendel']);
	echo "<script>herladenleerling('".$leerling->geefInschrijvingsnummer()."');</script>";
}

if(isset($_GET['verbeterd'])){
		$leerkracht->verbeterBlad($_GET['verbeterd'],1);
	echo "<script>herladenleerling('".$leerling->geefInschrijvingsnummer()."');</script>";
}

if(isset($_GET['ontgrendelverbeterd'])){
		$leerkracht->verbeterBlad($_GET['ontgrendelverbeterd'],0);
	echo "<script>herladenleerling('".$leerling->geefInschrijvingsnummer()."');</script>";
}

if(isset($_GET['sterkpunt1_opnieuw'])){
		$leerkracht->toggleSterkPuntOpnieuw($leerling->geefInschrijvingsnummer());
	echo "<script>herladenleerling('".$leerling->geefInschrijvingsnummer()."');</script>";
}

if(isset($_GET['zwakpunt1_opnieuw'])){
		$leerkracht->toggleZwakPuntOpnieuw($leerling->geefInschrijvingsnummer());
	echo "<script>herladenleerling('".$leerling->geefInschrijvingsnummer()."');</script>";
}




?>
<div class="fullborderradius" >
<?php if($leerling->geefSterkpunt1_vorigjaar()){?>
<div style="float:left;position:absolute;margin-left:3px;margin-top:70px;"><?php echo $leerling->toonSterkeZwakkePuntenVorigJaar()?></div>
<?php }?>

<button style="float:right; margin-right:100px;" onclick="wijzigWachtwoord('<?php echo $leerling-> geefInschrijvingsnummer()?>');" >Wachtwoord veranderen</button>
<table width="100%">
<tr align="center">
	<td>

<?php
if($leerling->klasIDNaarJaar($leerling->geefKlasID()) >=5){
	echo $leerling->toonLeerlingHeaderHTML(true);
}else{ //toon geen sterke zwakke punten
	echo $leerling->toonNaamHeader(true);
}
?>
	</td>
</tr>
</table>
</div>
<br>
<?php 

$huidig_semester = HelperFuncties::geefSemester();
$ander_semester = HelperFuncties::geefAnderSemester($huidig_semester);

$bladen_huidig_semester = $leerling->geefBladenSem($huidig_semester); //bladen van het huidige semester ophalen (array)
	$aantal_huidig_sem = count($bladen_huidig_semester); //aantal bladen in huidig semester
$bladen_ander_semester = $leerling->geefBladenSem($ander_semester); //bladen van het andere semester ophalen (array)
	$aantal_andere_sem = count($bladen_ander_semester); //aantal bladen in ander sem
	
?>
<div name="semestermapheader" class="semestermapheader_leerkracht" ><?php echo HelperFuncties::semesterNaarTekst($huidig_semester)?>
<span style="float:right; margin-right:100px;">
<button onclick="puntenInvoeren('<?php echo $leerling->geefInschrijvingsnummer(); ?>','<?php echo $huidig_semester; ?>')">Punten ingeven voor het <?php echo HelperFuncties::semesterNaarTekst($huidig_semester)?></button>
	<?php if($leerling->geefSemesterVerbeterd($huidig_semester)){ //enkel tonen als semester verbeterd is?>
		<b>Score: </b><?php echo $leerling->geefSemesterPunten($huidig_semester)?>/<?php echo $leerling->geefSemesterTotaal($huidig_semester)?> (<?php echo $leerling->bepaalResultaat($huidig_semester)?>)
	<?php }?>
	</span>
</div>

<table border="1" class="bladentabel">
<th>Titel</th>
<th>Aangemaakt</th>
<th>Laatst bewerkt</th>
<th>Verbeterd</th>
<th>Opties</th>

<?php 
foreach($bladen_huidig_semester as $nr=>$blad){
?>
<tr class="tabelrij">
	<td width="35%" align="center">
	<?php if($blad->geefVerbeterd()){echo "<img src='../images/verbeterd.gif' title='Verbeterd'/>";} ?>		
	<?php if(!$blad->geefVerbeterd() && !$blad->geefKanBewerken()){echo "<img src='../images/locked.png' title='Je kan dit blad niet meer bewerken: Je leerkracht is je blad aan het verbeteren'/>";} ?>		
			<?php echo $blad->geefTitel(); ?> 

	</td>
	<td width="10%" align="center"><?php echo $blad->geefAangemaakt(); ?></td>
	<td width="15%" align="center"><?php echo $blad->geefLaatstBewerkt(); ?></td>
	<td width="10%" align="center"><?php if($blad->geefVerbeterd()){echo"Ja";}else{echo"Nee";} ?></td>
	<td width="40%"  align="center">
<button onclick="corrigeerBlad(<?php echo $blad->geefID(); ?>,'<?php echo $blad->geefInschrijvingsnummer(); ?>');"><img src='../images/open.png' height="13" /> Openen</button>
		
		<?php
		 if(!$blad->geefVerbeterd()){
			if($blad->geefKanBewerken()){?>
			<button onclick="vergrendelBlad(<?php echo $blad->geefID(); ?>,'<?php echo $blad->geefInschrijvingsnummer(); ?>');" title="Zorgen dat de leerling het blad niet meer kan bewerken"><img src='../images/locked.png' /> Vergrendelen</button>
	    <?php }else{
	    ?>
	  	  <button onclick="ontgrendelBlad(<?php echo $blad->geefID(); ?>,'<?php echo $blad->geefInschrijvingsnummer(); ?>');" title="Zorgen dat de leerling het blad TERUG kan bewerken"><img src='../images/unlock.gif' width="13"/> Ontgrendelen</button>
	    <?php }
		 }
		 if(!$blad->geefVerbeterd()){
		 ?>
	  	  <button onclick="verbeterBlad(<?php echo $blad->geefID(); ?>,'<?php echo $blad->geefInschrijvingsnummer(); ?>');" title="Markeren als verbeterd" ><img src='../images/verbeterd.gif'  /> Verbeterd</button>
		<?php }else{?>
		 <button onclick="ontgrendelverbeterdBlad(<?php echo $blad->geefID(); ?>,'<?php echo $blad->geefInschrijvingsnummer(); ?>');" title="Blad terug markeren als 'niet verbeterd' " > <img src='../images/undo.png' height="13" /> Ontgrendel verbeterd</button>
		<?php }?>
		</td>
</tr>

<?php 
}
?>
</table>
<br>
<div name="semestermapheader" class="semestermapheader_leerkracht" ><?php echo HelperFuncties::semesterNaarTekst($ander_semester)?>
<span style="float:right; margin-right:100px;">
<button onclick="puntenInvoeren('<?php echo $leerling->geefInschrijvingsnummer(); ?>','<?php echo $ander_semester; ?>')">Punten ingeven voor het <?php echo HelperFuncties::semesterNaarTekst($ander_semester)?></button>
	<?php if($leerling->geefSemesterVerbeterd($ander_semester)){ //enkel tonen als semester verbeterd is?>
		<b>Score: </b><?php echo $leerling->geefSemesterPunten($ander_semester)?>/<?php echo $leerling->geefSemesterTotaal($ander_semester)?> (<?php echo $leerling->bepaalResultaat($ander_semester)?>)
	<?php }?>
	</span>
</div>

<table border="1" class="bladentabel">
<th>Titel</th>
<th>Aangemaakt</th>
<th>Laatst bewerkt</th>
<th>Verbeterd</th>
<th>Opties</th>

<?php 
foreach($bladen_ander_semester as $nr=>$blad){
?>
<tr class="tabelrij">
	<td width="35%" align="center">
	<?php if($blad->geefVerbeterd()){echo "<img src='../images/verbeterd.gif' title='Verbeterd'/>";} ?>		
	<?php if(!$blad->geefVerbeterd() && !$blad->geefKanBewerken()){echo "<img src='../images/locked.png' title='Je kan dit blad niet meer bewerken: Je leerkracht is je blad aan het verbeteren'/>";} ?>		
			<?php echo $blad->geefTitel(); ?> 

	</td>
	<td width="10%" align="center"><?php echo $blad->geefAangemaakt(); ?></td>
	<td width="15%" align="center"><?php echo $blad->geefLaatstBewerkt(); ?></td>
	<td width="10%" align="center"><?php if($blad->geefVerbeterd()){echo"Ja";}else{echo"Nee";} ?></td>
	<td width="40%"  align="center">
<button onclick="corrigeerBlad(<?php echo $blad->geefID(); ?>,'<?php echo $blad->geefInschrijvingsnummer(); ?>');"><img src='../images/open.png' height="13" /> Openen</button>
		
		<?php
		 if(!$blad->geefVerbeterd()){
			if($blad->geefKanBewerken()){?>
			<button onclick="vergrendelBlad(<?php echo $blad->geefID(); ?>,'<?php echo $blad->geefInschrijvingsnummer(); ?>');" title="Zorgen dat de leerling het blad niet meer kan bewerken"><img src='../images/locked.png' /> Vergrendelen</button>
	    <?php }else{
	    ?>
	  	  <button onclick="ontgrendelBlad(<?php echo $blad->geefID(); ?>,'<?php echo $blad->geefInschrijvingsnummer(); ?>');" title="Zorgen dat de leerling het blad TERUG kan bewerken"><img src='../images/unlock.gif' width="13"/> Ontgrendelen</button>
	    <?php }
		 }
		 if(!$blad->geefVerbeterd()){
		 ?>
	  	  <button onclick="verbeterBlad(<?php echo $blad->geefID(); ?>,'<?php echo $blad->geefInschrijvingsnummer(); ?>');" title="Markeren als verbeterd" ><img src='../images/verbeterd.gif'  /> Verbeterd</button>
		<?php }else{?>
		 <button onclick="ontgrendelverbeterdBlad(<?php echo $blad->geefID(); ?>,'<?php echo $blad->geefInschrijvingsnummer(); ?>');" title="Blad terug markeren als 'niet verbeterd' " > <img src='../images/undo.png' height="13" /> Ontgrendel verbeterd</button>
		<?php }?>
		</td>
</tr>

<?php 
}
?>
</table>