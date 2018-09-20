<div align="center" style="font-size:1.5em;">Actiepunten beheren</div>
<br>
<div align="center"><button  onclick="voegsterkezwakkepuntentoe();" ><img src='../images/add.png' height="13"/> Voeg actiepunten toe</button></div>
<?php 
	$punten = $leerkracht->sterkezwakkePuntenOphalen();
	
	/*
	 * GET EVENTS
	 */
	
	/* klassen toevoegen */
	if(isset($_GET['voegpuntentoe'])){
		for($i=0;$i<$_GET['voegpuntentoe'];$i++){
			$leerkracht->nieuwSterkZwakPunt();
		}
		echo "<script>herladenpag('".$_GET['pag']."');</script>";
	}
		
	/* klassen verwijderen */
	if(isset($_GET['verwijderpunt'])){
	
			$leerkracht->verwijderSterkZwakPunt($_GET['verwijderpunt']);
		echo "<script>herladenpag('".$_GET['pag']."');</script>";
	}	

?>
	
	<table class="fullborderradius" align="center" border="1" style="border-collapse:collapse;margin-top:30px;" >
		<th>Omschrijving</th>
		<th>Jaar</th>
		<th>Opties</th>
						
	<?php 
	foreach($punten as $nr=>$punt){
		$omschrijving = HelperFuncties::escapeForHtmlUse($punt['omschrijving']);
		$jaar = HelperFuncties::escapeForHtmlUse($punt['jaar']);
		$puntid = HelperFuncties::escapeForHtmlUse($punt['id']);
		$html = <<<html
		<tr>
			<input type='hidden' id='id_$nr'  value='$puntid'/> 
			<td align='center'><input onChange=sterkzwakpuntOpslaan('$nr'); type='text' id='omschrijving_$nr' class='inputveld' value='$omschrijving'/></td>
			<td align='center'><input onChange=sterkzwakpuntOpslaan('$nr'); type='text' id='jaar_$nr' class='inputveld' value='$jaar' /></td>
			<td align='center'><img src='../images/delete.gif' title='Verwijder deze klas' style='border:0px;' onclick=verwijderSterkZwakPunt('$puntid') /></td>
		</tr>
html;
		echo $html;
	/*	
		echo"<tr>" ;
			echo"
			
			<input type='hidden' id='id_".$nr."'  value='".$punt['id']."'/> 
				<td align='center'><input onChange=\"sterkzwakpuntOpslaan('".$nr."');\" type='text' id='omschrijving_".$nr."' class='inputveld' value='".$punt['omschrijving']."' /></td>
				<td align='center'><input onChange=\"sterkzwakpuntOpslaan('".$nr."');\" type='text' id='jaar_".$nr."' class='inputveld' value='".$punt['jaar']."' /></td>
				<td align='center'><img src='../images/delete.gif' title='Verwijder deze klas' style='border:0px;' onclick=\"verwijderSterkZwakPunt('".$punt['id']."');\" /></td>
			";
		echo"</tr>";
	*/
	}

?>
</table>

<div align="center" style="margin-top:20px;">
<div align="center"><button  onclick="voegsterkezwakkepuntentoe();" ><img src='../images/add.png' height="13"/> Voeg actiepunten toe</button></div>
</div>