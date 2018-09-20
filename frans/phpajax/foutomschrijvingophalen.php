<?php
function __autoload($class){
	require_once '../phpklassen/'.$class.'.php';
}

	$verbinding = new Verbinding();
	$verbinding->connect();
	
	$blad = new Blad();
	$array = $blad->geefFoutOmschrijving($_GET['foutnr']); //array(titel,omschrijving)
	if($array[0]!==""){
	echo "".$_GET['foutnr'].".<b>$array[0]</b>&nbsp; <img src='../images/copy.gif' onclick='kopieerVerantwoording();' alt='Kopieer' title='Kopieer de omschrijving naar de fout '/> <br>";
	echo "<span id='omschrijving' >".$array[1]."</span><br><br>";
	echo "<i>".$array[2]."</i>";
	}
?>