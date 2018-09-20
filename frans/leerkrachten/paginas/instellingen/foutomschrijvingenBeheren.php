<div align="center" style="font-size:1.5em;">Foutomschrijvingen beheren</div>
<br>
<div align="center"><button  onclick="voegfoutomschrijvingentoe();" ><img src='../images/add.png' height="13"/> Voeg foutomschrijvingen toe</button></div>
	<script>var arr = new Array();</script>
<?php 
	$foutomschrijvingen = $leerkracht->foutOmschrijvingenOphalen();

	foreach($foutomschrijvingen as $nr=>$fout){
			//<script>arr[".$nr."] = '".$fout['foutnr']."'</script>
			$foutnr = $fout['foutnr'];
			echo "<script>arr['$nr']='$foutnr'</script>";
	}
	
	/*
	 * GET EVENTS
	 */
	
	/* Omschrijvingen toevoegen */
	if(isset($_GET['voegomschrijvingentoe'])){
		for($i=0;$i<$_GET['voegomschrijvingentoe'];$i++){
			$leerkracht->nieuweFoutomschrijving();
		}
		echo "<script>herladenpag('".$_GET['pag']."');</script>";
	}
		
	/* Omschrijvingen verwijderen */
	if(isset($_GET['verwijderomschrijving'])){
	
			$leerkracht->verwijderFoutomschrijving($_GET['verwijderomschrijving']);
		echo "<script>herladenpag('".$_GET['pag']."');</script>";
	}	

?>
	<table class="fullborderradius" align="center" border="1" style="border-collapse:collapse;margin-top:30px;" >
		<th>Foutnr</th>
		<th>Titel</th>
		<th>Omschrijving</th>
		<th>Grammatica</th>
		<th>Opties</th>
				
	<?php
		
	foreach($foutomschrijvingen as $nr=>$fout){
		$foutnr = HelperFuncties::escapeForHtmlUse($fout['foutnr']);
		$foutid = $fout['id'];
		$fouttitel = HelperFuncties::escapeForHtmlUse($fout['titel']);
		$foutomschrijving = HelperFuncties::escapeForHtmlUse($fout['omschrijving']);
		$foutgrammatica = HelperFuncties::escapeForHtmlUse($fout['grammatica']);
		$html = <<<html
		<tr>
			<script>arr['$nr'] = '$foutnr'</script>
			
			<input type='hidden' id='id_$nr'  value='$foutid'/> 
				<td align='center'><input onChange=omschrijvingOpslaan('$nr'); type='text' id='foutnr_$nr' class='inputveld' value='$foutnr' size='2'/></td>
				<td align='center'><input onChange=omschrijvingOpslaan('$nr'); type='text' id='titel_$nr' class='inputveld' value='$fouttitel' /></td>
				<td align='center'><textarea onChange=omschrijvingOpslaan('$nr');  id='omschrijving_$nr' class='inputveld' rows='3' cols='50' wrap='hard'/>$foutomschrijving</textarea></td>
				<td align='center'><input onChange=omschrijvingOpslaan('$nr'); type='text' id='grammatica_$nr' class='inputveld' value='$foutgrammatica' /></td>
				<td align='center'><img src='../images/delete.gif' title='Verwijder deze omschrijving' style='border:0px;' onclick=verwijderOmschrijving('$foutid'); /></td>
			</tr>
html;
		echo $html;
	}

?>
</table>

<div align="center" style="margin-top:20px;">
<button  onclick="voegfoutomschrijvingentoe();" ><img src='../images/add.png' height="13"/> Voeg foutomschrijvingen toe</button>
</div>