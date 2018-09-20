<?php
function __autoload($class){
	require_once '../phpklassen/'.$class.'.php';
}

	$verbinding = new Verbinding();
	$verbinding->connect();
	

	

	

	$leerkracht = new Leerkracht();
	$id = rawurldecode($_GET['id']);
	$omschrijving = rawurldecode($_GET['omschrijving']);
	$jaar = rawurldecode($_GET['jaar']);
	$leerkracht->sterkzwakPuntWijzigen($id, $omschrijving, $jaar);
	
	?>