<?php
function __autoload($class){
	require_once '../phpklassen/'.$class.'.php';
}

	$verbinding = new Verbinding();
	$verbinding->connect();
	

	

	

	$leerkracht = new Leerkracht();
	$id = rawurldecode($_GET['klas_id']);
	$klasnaam = rawurldecode($_GET['klasnaam']);
	$jaar = rawurldecode($_GET['jaar']);
	$leerkracht->klasWijzigen($id, $klasnaam, $jaar);
	
	?>