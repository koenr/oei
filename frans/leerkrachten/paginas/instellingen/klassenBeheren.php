<div align="center" style="font-size:1.5em;">Klassen beheren</div>
<br>
<div align="center"><button  onclick="voegklassentoe();" ><img src='../images/add.png' height="13"/> Voeg klassen toe</button></div>
<?php 
	$klassen = $leerkracht->geefAlleKlassen();

	
	/*
	 * GET EVENTS
	 */
	
	/* klassen toevoegen */
	if(isset($_GET['voegklassentoe'])){
		for($i=0;$i<$_GET['voegklassentoe'];$i++){
			$leerkracht->nieuweKlas();
		}
		echo "<script>herladenpag('".$_GET['pag']."');</script>";
	}
		
	/* klassen verwijderen */
	if(isset($_GET['verwijderklas'])){			
			if($leerkracht->verwijderKlas($_GET['verwijderklas']) !== "0"){
				echo "<script>herladenpag('".$_GET['pag']."');</script>";
			}else{
				echo"<script> alert('Deze klas is nog niet leeg. Alle leerlingen van deze klas moeten in een andere klas geplaatst worden vooraleer je deze klas kan verwijderen');</script>";
				echo "<script>herladenpag('".$_GET['pag']."');</script>";
			}
	}	

?>
	
	<table class="fullborderradius" align="center" border="1" style="border-collapse:collapse;margin-top:30px;" >
		<th>Klasnaam</th>
		<!-- <th>Jaar</th> -->
		<th>Opties</th>
						
	<?php 
	foreach($klassen as $nr=>$klas){
		$id = $klas['klas_id'];
		$klasnaam = HelperFuncties::escapeForHtmlUse($klas['klas']);		
$html = <<<html
		<tr>
			<input type='hidden' id='id_$nr'  value='$id'/> 
			<td align='center'><input onChange=klassenOpslaan('$nr') type='text' id='klasnaam_$nr' class='inputveld' value='$klasnaam' /></td>
			<td align='center'><img src='../images/delete.gif' title='Verwijder deze klas' style='border:0px;' onclick=verwijderKlas('$id') /></td>
		</tr>
html;
		echo $html;
		/*		
		echo"<tr>" ;
			echo"
			<input type='hidden' id='id_".$nr."'  value='".$klas['klas_id']."'/> 
				<td align='center'><input onChange=\"klassenOpslaan('".$nr."');\" type='text' id='klasnaam_".$nr."' class='inputveld' value='".$klas['klas']."' /></td>
				<td align='center'><img src='../images/delete.gif' title='Verwijder deze klas' style='border:0px;' onclick=\"verwijderKlas('".$klas['klas_id']."');\" /></td>
			";
		echo"</tr>";
		*/
	}

?>
</table>

<div align="center" style="margin-top:20px;">
<button  onclick="voegklassentoe();" ><img src='../images/add.png' height="13"/> Voeg klassen toe</button>
</div>