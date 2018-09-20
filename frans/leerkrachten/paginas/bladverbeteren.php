<?php 
	$blad = new Blad($_GET['blad_id']);
	$fouten = $blad->geefFouten(); //bladen van het huidige semester ophalen (array)
		$aantalfouten = count($fouten);
		//echo $aantalfouten;
?>
<script type="text/javascript" src="../js/foutinfoOphalen.js"></script>

<?php 
/*
 * GET FUNCTIES
 * 
 */



?>
<!-- AUTOSAVE FUNCTIE: elke 30 seconden -->
<script>setInterval("autobewaar()","30000");</script>

<button name="bewaarblad" onclick="autobewaar();"><img src='../images/save.gif' /> Bewaren</button>&nbsp;
<form method='post'  name='invulform' style="float:left;" action='index.php?pag=bladverbeteren.php&blad_id=<?php echo $blad->geefID();?>&inschrijvingsnummer=<?php echo $blad->geefInschrijvingsnummer();?>'>

	
		<input type='hidden' name="blad_id" value="<?php echo $blad->geefID(); ?>" />
		<input type='hidden' name="aantalfouten" value="<?php echo $aantalfouten; ?>" />

		
		
		<input type="submit" name="bladopslaan" style="display:none;" />
		
	
		<span id='autobewaar'>Deze verbetering wordt elke 30 seconden opgeslagen</span><br>


		<button style="float:right;margin-right:20px;" onclick="sluitVerbeterblad(false,'<?php echo $blad->geefInschrijvingsnummer() ?>');" id="sluiten" >Sluit</button>
<br>
		
		<table class="foutentabel" border="1" style="border-collapse:collapse;">
			<caption>
				<div align="center"><?php echo $leerling->toonNaamHeader();?></div>
				<div style="margin-left:auto; margin-right:auto;text-decoration:underline;font-weight:bold;" align="center"><?php echo $blad->geefTitel();?></div><br>
			</caption>
			
			<th>Foutnr</th>
			<th>Fout</th>
			<th>Verbetering</th>
			<th>Verantwoording</th>
			<th>Commentaar</th>
			<th>Bekeken</th>
	<?php 
	foreach($fouten as $nr=>$fout){
	?>	
	<input type="hidden" name="foutid_<?php echo $nr;?>" value="<?php echo $fout->geefID(); ?>" />
	<tr id="rij<?php echo $nr;?>" class="tabelrij">
	
		<td width=""  align="center"><div style="width:60px;"><?php echo $fout->geefFoutnr(); ?></div></td>
		<td width=""  align="center"><?php echo $fout->geefFout(); ?></td>
		<td width=""  align="center"><?php echo $fout->geefVerbetering(); ?></td>
		<td width=""  align="center"><?php echo $fout->geefVerantwoording(); ?></td>
		<td width=""  align="center"><input type="text" size="26" name="commentaar_<?php echo $nr;?>" value="<?php echo $fout->geefCommentaar(); ?>"/></td>
		
		<td width=""  align="center"><input type="checkbox" name="bekeken_<?php echo $nr;?>" <?php if($fout->geefLeerkrachtBekeken()){echo'checked="true" ';}?>  value="1"/></td>
	</tr>
	
	<?php } ?>
	</table>
	<br>
	<b>Commentaar</b><br>
		<textarea name="algemene_commentaar" rows="4" cols="60" ><?php echo $blad->geefCommentaar(); ?></textarea>
	</form>
	
	
	<br><br>
	<iframe height="800" width="800" style="display:none;" name="autosaveframe" id="autosaveframe" ></iframe>

	
	
	<?php 

	/* POST EVENT : opslaan van het blad */
	if(isset($_POST['bladopslaan'])){
		
		
		$aantal = $_POST['aantalfouten'];
	
		
		
		
		for($i=0;$i<$aantal;$i++){
			
			$fout_obj = $fouten[$i];
			
			$foutid = "foutid_".$i."";
			
			$commentaar = "commentaar_".$i."";
			$bekeken = "bekeken_".$i."";
		
			
		
			if(isset($_POST[$bekeken])){
				if($blad->setCommentaar(''.$_POST["algemene_commentaar"].''));
				
				
				if($fout_obj->bewaarFoutVerbetering($_POST[$foutid],$_POST[$commentaar],$_POST[$bekeken])){
					echo "ok";
				}else{
					echo"fout";
				}
			}else{ //bekeken niet gechecked
				$fout_obj->bewaarFoutVerbetering($_POST[$foutid],$_POST[$commentaar],0);
				if($blad->setCommentaar(''.$_POST["algemene_commentaar"].''));
			}
		}
	echo"<script>herladenblank();</script>";
		
	}
	
	
	?>
