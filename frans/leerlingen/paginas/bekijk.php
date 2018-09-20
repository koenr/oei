<?php 
	$blad = new Blad($_GET['blad_id']);
		$blad->setGelezen(1);
	$fouten = $blad->geefFouten(); //bladen van het huidige semester ophalen (array)
		$aantalfouten = count($fouten);
		//echo $aantalfouten;
?>


		<?php 
		
/* IS HET BLAD VAN DE LEERLING? */
if($blad->controleerEigenaar($leerling->geefInschrijvingsnummer())){
	 //leerling is eigenaar
	 ?>
		<button style="float:right;margin-right:20px;" onclick="herladen();" id="sluiten" >Sluit</button>

<br>
		<table width="100%" border="1" style="border-collapse:collapse;">
			<caption>
				<div align="center"><?php echo $leerling->toonNaamHeader();?></div>
				<div style="margin-left:auto; margin-right:auto;text-decoration:underline;font-weight:bold;" align="center"><?php echo $blad->geefTitel();?></div><br>
			</caption>
			
			<th>Faute Nr</th>
			<th>Erreur</th>
			<th>Correction</th>
			<th>Explication</th>
			<th>Commentaire</th>
		
	<?php 
	foreach($fouten as $nr=>$fout){
	?>	

	<tr width="100%" id="rij<?php echo $nr;?>" class="tabelrij">
	
		<td  align="center"><?php echo $fout->geefFoutnr(); ?></td>
		<td  align="center"><div style="overflow:hidden;width:200px"><?php echo $fout->geefFout(); ?></div></td>
		<td  align="center"><div style="overflow:hidden;width:200px;"><?php echo $fout->geefVerbetering(); ?></div></td>
		<td  align="center"><div style="overflow:hidden;width:300px;"><?php echo $fout->geefVerantwoording(); ?></div></td>
		<td  align="center"><div style="overflow:hidden;width:200px;"><?php echo $fout->geefCommentaar(); ?></div></td>
		
	</tr>
	
	<?php } ?>
	</table>
	<br><br>
	<?php if($blad->geefVerbeterd()){?>
		<fieldset class="fullborderradius">
	<u>Commentaire</u><br>	
	<?php echo $blad->geefCommentaar(); ?></fieldset>
	<?php }?>
	
	<?php }else{
	// LEERLING IS NIET EIGENAAR
	
	echo"<br><br><br><br><br><br> <div align='center'>Dit blad is niet van jou</div>";
}
	
	?>
	
