<?php 
/* ******************
 *                  *
 * GET EVENTS       *
 *                  *
 * ******************/

/* uitloggen */
if(isset($_GET['uitloggen'])){
	$leerling->uitloggen();
	echo"<script>herladen();</script>";
}

/* nieuw blad aanmaken */
if(isset($_GET['nieuwblad'])){
	$leerling->maakBlad($_GET['nieuwblad']); 
	echo"<script>herladen();</script>";
}

/* verwijder blad */
if(isset($_GET['verwijderblad'])){
	$leerling->verwijderBlad($_GET['verwijderblad']); 
	echo"<script>herladen();</script>";
}

/* LAYOUTEGG*/
if(isset($_GET['woohoo'])){
	$leerling->setAchtergrond($_GET['back']);
	$leerling->setTekstkleur($_GET['tekst']);
	echo"<script>herladen();</script>";
}

include "egg.php";
?>



<?php if($leerling->geefSterkpunt1_vijfde() !=="false" && $leerling->geefSterkpunt1_vijfde() !== NULL){?>

<div style="float:left;position:absolute;margin-left:3px;margin-top:45px;"><?php echo $leerling->toonSterkeZwakkePuntenVorigJaar()?></div>
<?php }?>

<table class="fullborderradius"  style="margin-top:5px;" width="100%">

<tr align="center">
<td>
<div style="height:20px;float:right;width:27px;background-color:white;margin-right:20px;" onclick="setAchtergrond('')"></div>  
<img src="../images/achtergronden/gnome-blue.png" height="20px" border="0" style="float:right;width:27px;" onclick="setAchtergrond('../images/achtergronden/gnome-blue.png')";/>
<img src="../images/achtergronden/gnome-green.png" height="20px" border="0" style="float:right;width:27px;" onclick="setAchtergrond('../images/achtergronden/gnome-green.png')";/>

<?php
if($leerling->klasIDNaarJaar($leerling->geefKlasID()) >=5){
	echo $leerling->toonLeerlingHeaderHTML(false);
}else{ //toon geen sterke zwakke punten
	echo $leerling->toonNaamHeader(false);
}
?>
	<button onclick="maakblad();"><img src='../images/add.png' style="border:0px;" /> Maak een nieuw blad</button>&nbsp;
	<button onclick="uitloggen();"><img src='../images/logoff.png' height="14" /> Uitloggen</button>
</td>
</tr>
</table>

<br>

<?php 
$huidig_semester = HelperFuncties::geefSemester();
$ander_semester = HelperFuncties::geefAnderSemester($huidig_semester);

$bladen_huidig_semester = $leerling->geefBladenSem($huidig_semester); //bladen van het huidige semester ophalen (array)
	$aantal_huidig_sem = count($bladen_huidig_semester); //aantal bladen in huidig semester
$bladen_ander_semester = $leerling->geefBladenSem($ander_semester); //bladen van het andere semester ophalen (array)
	$aantal_andere_sem = count($bladen_ander_semester); //aantal bladen in ander sem
	
?>
<div name="semestermapheader" class="semestermapheader" ><?php echo HelperFuncties::semesterNaarTekst($huidig_semester)?>
<span style="float:right; margin-right:100px;">
	<?php if($leerling->geefSemesterVerbeterd($huidig_semester)){ //enkel tonen als semester verbeterd is?>
		<b>Score: </b><?php echo $leerling->geefSemesterPunten($huidig_semester)?>/<?php echo $leerling->geefSemesterTotaal($huidig_semester)?> (<?php echo $leerling->bepaalResultaat($huidig_semester)?>)
	<?php }?>
	</span>
</div>

<table border="1" class="bladentabel">
<th>Titel</th>
<th>Aangemaakt</th>
<th>Laatst bewerkt</th>
<th>Opties</th>

<?php 
foreach($bladen_huidig_semester as $nr=>$blad){
?>
<tr class="tabelrij">
	<td width="35%" align="center">
	<?php if($blad->geefVerbeterd()){echo "<img src='../images/verbeterd.gif' title='Verbeterd'/>";} ?>		
	<?php if(!$blad->geefVerbeterd() && !$blad->geefKanBewerken()){echo "<img src='../images/locked.png' title='Je kan dit blad niet meer bewerken: Je leerkracht is je blad aan het verbeteren'/>";} ?>		
			<?php echo $blad->geefTitel(); ?> 
	<?php if(!$blad->geefGelezen()){?><img onclick="bekijkBlad(<?php echo $blad->geefID(); ?>)" src="../images/ballon.png" height="20" style="border:0px;" title="Je leerkracht heeft commentaar gegeven"/><?php }?>
	
	</td>
	<td width="10%" align="center"><?php echo $blad->geefAangemaakt(); ?></td>
	<td width="15%" align="center"><?php echo $blad->geefLaatstBewerkt(); ?></td>
	<td width="40%"  align="center">
		<button onclick="bekijkBlad(<?php echo $blad->geefID(); ?>)"><img src='../images/open.png'  /> Bekijk</button>
		<?php if($blad->geefVerbeterd() || !$blad->geefKanBewerken()){}else{?>
		
		<button onclick="bewerkBlad(<?php echo $blad->geefID(); ?>);"><img src='../images/edit.gif' /> Bewerk</button>
		<button onclick="verwijderBlad(<?php echo $blad->geefID();?>,'<?php echo $blad->geefTitel(); ?>')"><img src='../images/delete.gif' /> Verwijderen</button>
		<?php }?>
		</td>
</tr>

<?php 
}
?>
</table>
<br>

<div name="semestermapheader" class="semestermapheader" ><?php echo HelperFuncties::semesterNaarTekst($ander_semester)?>  
	<span style="float:right; margin-right:100px;">
	<?php if($leerling->geefSemesterVerbeterd($ander_semester)){ //enkel tonen als semester verbeterd is?>
		<b>Score: </b><?php echo $leerling->geefSemesterPunten($ander_semester)?>/<?php echo $leerling->geefSemesterTotaal($ander_semester)?> (<?php echo $leerling->bepaalResultaat($ander_semester)?>)
	<?php }?>
	</span>
</div>
<table border="1" class="bladentabel">
<th>Titel</th>
<th>Aangemaakt</th>
<th>Laatst bewerkt</th>
<th>Opties</th>
<?php 
	
foreach($bladen_ander_semester as $nr=>$blad){
?>
<tr class="tabelrij">
	<td width="35%" align="center">
		<?php if($blad->geefVerbeterd()){echo "<img src='../images/verbeterd.gif' title='Verbeterd'/>";} ?>		
		<?php if(!$blad->geefVerbeterd() && !$blad->geefKanBewerken()){echo "<img src='../images/locked.png' title='Je kan dit blad niet meer bewerken: Je leerkracht is je blad aan het verbeteren'/>";} ?>		
			<?php echo $blad->geefTitel(); ?> 
		<?php if(!$blad->geefGelezen()){?><img onclick="bekijkBlad(<?php echo $blad->geefID(); ?>)" src="../images/ballon.png" height="20" style="border:0px;" title="Je leerkracht heeft commentaar gegeven"/><?php }?>
	
	</td>
	<td width="10%" align="center"><?php echo $blad->geefAangemaakt(); ?></td>
	<td width="15%" align="center"><?php echo $blad->geefLaatstBewerkt(); ?></td>
	<td width="40%"  align="center">
		<button onclick="bekijkBlad(<?php echo $blad->geefID(); ?>)"><img src='../images/open.png'  /> Bekijk</button>
		<?php if($blad->geefVerbeterd() || !$blad->geefKanBewerken()){}else{?>
		
		<button onclick="bewerkBlad(<?php echo $blad->geefID(); ?>);"><img src='../images/edit.gif' /> Bewerk</button>
		<button onclick="verwijderBlad(<?php echo $blad->geefID();?>,'<?php echo $blad->geefTitel(); ?>')"><img src='../images/delete.gif' /> Verwijderen</button>
		<?php }?>
		</td>
</tr>

<?php 
}
?>
</table>


