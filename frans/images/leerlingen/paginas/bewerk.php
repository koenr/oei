<?php 
	$blad = new Blad($_GET['blad_id']);
	$fouten = $blad->geefFouten(); //bladen van het huidige semester ophalen (array)
		$aantalfouten = count($fouten);
		//echo $aantalfouten;
?>
<script type="text/javascript" src="../js/foutinfoOphalen.js"></script>

<script>
var verantwoordingnr = 0;

/* Kopieer de verantwoording van de div foutnr_info naar het tekstveld waarvan je de foutinfo ophaalt */
function kopieerVerantwoording(){
	id = "verantwoording_"+verantwoordingnr+"";
	document.getElementById(id).value = document.getElementById('omschrijving').innerHTML;
}


function setVerantwoordingnr(nr){
	verantwoordingnr = nr;
}
</script>
<?php 
/*
 * GET FUNCTIES
 * 
 */

/* Voeg fouten toe */
if(isset($_GET['voegfoutentoe'])){
	for($i=0;$i<$_GET['voegfoutentoe'];$i++){
		$blad->maakFout();
	}
	echo "<script>herladenbewerk(".$blad->geefID().");</script>";
}


/* Verwijder fouten */
if(isset($_GET['verwijderfout'])){
		$blad->verwijderFout($_GET['verwijderfout'], $leerling->geefInschrijvingsnummer());
	echo "<script>herladenbewerk(".$blad->geefID().");</script>";
}



/* IS HET BLAD VAN DE LEERLING? */
if($blad->controleerEigenaar($leerling->geefInschrijvingsnummer())){
	 //leerling is eigenaar

/* MAG DE LEERLING BEWERKEN ? */

if(!$blad->geefVerbeterd() && $blad->geefKanBewerken()){

?>
<!-- AUTOSAVE FUNCTIE: elke 30 seconden -->
<script>setInterval("autobewaar()","30000");</script>




<button name="bewaarblad" id="bewaarblad"   onclick="autobewaar();"><img src='../images/save.gif' height="13" /> Bewaren</button>&nbsp;
<form method='post'   name='invulform'  action='index.php?pag=bewerk.php&blad_id=<?php echo $blad->geefID();?>'>

	
		<input type='hidden' name="blad_id" value="<?php echo $blad->geefID(); ?>" />
		<input type='hidden' name="aantalfouten" value="<?php echo $aantalfouten; ?>" />

		
		
		<input type="submit" name="bladopslaan" style="display:none;" />
		
		<button name="toevoegen" id="toevoegen" onclick="voegfoutentoe(<?php echo $blad->geefID();?>,false);" ><img src='../images/add.png' /> Voeg fouten toe</button>&nbsp;
		<!-- <input type='button' name="kopieer"  onclick="kopieer();" value='Kopieer uitleg' /> -->
		<span id='autobewaar'>Dit blad wordt elke 30 seconden opgeslagen</span><br>


		<button style="float:right;margin-right:20px;" onclick="sluitBewerkblad(false);" id="sluiten" >Sluit</button>
<br>
		<b>Titel:</b><input type='text' name="titel" value="<?php echo $blad->geefTitel();?>" size='100%'  /><br><br>

		<table class="foutentabel" border="1" style="border-collapse:collapse;">
			<th>Faute Nr</th>
			<th>Erreur</th>
			<th>Correction</th>
			<th>Explication</th>
			<th>Opties</th>
	<?php 
	foreach($fouten as $nr=>$fout){
	?>	
	<input type="hidden" name="foutid_<?php echo $nr;?>" value="<?php echo $fout->geefID(); ?>" />
	<tr id="rij<?php echo $nr;?>" class="tabelrij">
	
		<td width=""  align="center"><input  type="text" size="2"  name="foutnr_<? echo $nr;?>" id="foutnr_<? echo $nr;?>" value="<?php echo $fout->geefFoutnr(); ?>" onkeyup="foutOmschrijvingOphalen(this.value,this.name);setVerantwoordingnr(<?php echo $nr; ?>);" onclick = "foutOmschrijvingOphalen(this.value,this.name);setVerantwoordingnr(<?php echo $nr; ?>);" /></td>
		<td width="" align="center"><input type="text" size="26" name="fout_<? echo $nr;?>" value="<?php echo $fout->geefFout(); ?>"/></td>
		<td width="" align="center"><input type="text" size="26" name="verbetering_<? echo $nr;?>" value="<?php echo $fout->geefVerbetering(); ?>"/></td>
		<td width="" align="center"><input type="text" size="75" name="verantwoording_<? echo $nr;?>" id="verantwoording_<? echo $nr;?>" value="<?php echo $fout->geefVerantwoording(); ?>" />&nbsp;</td>
		<td align="center">
		    <img src='../images/copy.gif' onmouseover="foutOmschrijvingOphalen(document.getElementById('foutnr_<?php echo $nr;?>').value);setVerantwoordingnr(<?php echo $nr;?>);" onclick='kopieerVerantwoording();' alt='Kopieer' title='Kopieer de omschrijving naar de fout '/> 
			<a href="#" onmouseover="document.getElementById('rij<?php echo $nr;?>').className='tabelrijdelete';this.style.color='yellow';"  onmouseout="document.getElementById('rij<?php echo $nr;?>').className='tabelrij';this.style.color='black';" onclick="verwijderFout(<?php echo $fout->geefID(); ?>,<?php echo $blad->geefID(); ?>)"><img src="../images/delete.gif" alt="Verwijderen" title="Deze fout verwijderen" style="border:0px;"/></a></td>
	</tr>
	
	<?php } ?>
	</table>
	</form>
	
	<button  onclick="voegfoutentoe(<?php echo $blad->geefID();?>);" ><img src='../images/add.png' height="13"/> Voeg fouten toe</button>
	<br><br>
	<iframe height="0" width="0" style="display:none;" name="autosaveframe" id="autosaveframe" ></iframe>
	<div class="fullborderradius" style="padding:10px;" >
		
		<div onclick="kopieerVerantwoording();" id="foutnr_info" >Hier wordt de info over fouten geladen</div>
	</div>
	
	
	<?php 
	/* POST EVENT : opslaan van het blad */
	if(isset($_POST['bladopslaan'])){
		
		/* GETTERS VAN KLASSE FOUT AFWERKEN */
		
		
		$aantal = $_POST['aantalfouten'];
		$titel = $_POST['titel'];
		$blad->bewaarBlad("".$titel."");
		
		
		for($i=0;$i<$aantal;$i++){
			
			$fout_obj = $fouten[$i];
			
			$foutid = "foutid_".$i."";
			
			$foutnr = "foutnr_".$i."";
			$fout = "fout_".$i."";
			$verbetering = "verbetering_".$i."";
			$verantwoording = "verantwoording_".$i."";	
			
			if($fout_obj->bewaarFout($_POST[$foutid],$_POST[$foutnr],$_POST[$fout],$_POST[$verbetering],$_POST[$verantwoording])){
				echo "ok";
			}else{
				echo"fout";
			}
		}
	echo"<script>herladenbewerk(".$blad->geefID().");</script>";
		
	}
}else{
	/* LEERLING MAG NIET MEER BEWERKEN 	 */
	echo"<br><br><br><br><br><div align='center' valign='middle' style='position:relative;vertical-align:middle;margin-top:auto;margin-bottom:auto; margin-left:auto; margin-right:auto;'>";
	echo "Je kan dit blad niet meer bewerken<br>";
	echo "Klik <a href='?pag=bekijk.php&blad_id=".$blad->geefID()."'>hier</a> om het blad te bekijken.";
	echo "</span>";
}
}else{
	// LEERLING IS NIET EIGENAAR
	
	echo"<br><br><br><br><br><br> <div align='center'>Dit blad is niet van jou</div>";
}
	
	?>
