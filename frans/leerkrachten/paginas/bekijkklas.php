
<br><br><div align="center">Leerlingen in <?php  echo $leerkracht->klasIDNaarKlas($_GET['klas_id']); ?> <button onclick="vergrendelBladenKlas('<?php echo $_GET['klas_id'] ?>');" title="Vergrendel de bladen van alle leerlingen van deze klas"><img src='../images/locked.png' /> Bladen Vergrendelen </button></div><br><br>
<?php
$leerlingen = $leerkracht->geefLeerlingen($_GET['klas_id']); //leerlingen van de klas ophalen

/* Blad vergrendelen */
if(isset($_GET['vergrendelbladen'])){
	foreach($leerlingen as $nr=>$leerling2){
		$bladen = $leerling2->geefBladen();
		foreach($bladen as $nummer=>$blad){
			$leerkracht->vergrendelBlad($blad->geefID());
		}
	}

	echo "<script>herladenklas('".$_GET['klas_id']."');</script>";
	
}


echo"<table border='1' style='border-collapse:collapse; margin-left:auto; margin-right:auto;'>
<th>Nummer</th>
<th>Naam</th>
<th>Klas</th>
<th>Eerste Semester</th>
<th>Tweede Semester</th>

";

foreach($leerlingen as $nr=>$leerling){
	echo'<tr>
		
		<td align="center"><div style="padding-left:4px;padding-right:4px;">'.$leerling->geefKlasnr().'</div></td>
		<td align="left"><div style="padding-left:4px;padding-right:4px;"><a style="padding-left:3px;padding-right:3px;" href="?pag=leerling.php&inschrijvingsnummer='.$leerling->geefInschrijvingsnummer().'">'.$leerling->geefVoornaam().'&nbsp;'.$leerling->geefAchternaam().'</a></div></td>
		<td align="center"><div style="padding-left:20px;padding-right:20px;">'.$leerkracht->klasIDNaarKlas($leerling->geefKlasID()).'</div></td>
		
		<td align="center"><div style="padding-left:20px;padding-right:20px;">';
		if($leerling->geefSemesterVerbeterd(1) == 0){
			echo"";
		}else{
			echo "".$leerling->geefSemesterPunten(1)."/".$leerling->geefSemesterTotaal(1)." (".$leerling->bepaalResultaat(1).")";
		
		}
			echo'</div></td>
			
		<td align="center"><div style="padding-left:20px;padding-right:20px;">'; 
		if($leerling->geefSemesterVerbeterd(2) == 0){
			echo"";
		}else{
			echo "".$leerling->geefSemesterPunten(2)."/".$leerling->geefSemesterTotaal(2)." (".$leerling->bepaalResultaat(2).")";
		}
			echo'</div></td>';
}
echo"</table>";
?>
