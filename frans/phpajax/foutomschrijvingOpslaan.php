<?php
function __autoload($class){
	require_once '../phpklassen/'.$class.'.php';
}

	$verbinding = new Verbinding();
	$verbinding->connect();
	
	/*
	function wijzig($return){
		$return = str_ireplace("<br />", "\n", $return);
		$return = str_ireplace('"', "'", $return);
		return $return;
	}
	*/
	
	
	

	$leerkracht = new Leerkracht();
	$id = rawurldecode($_GET['id']);
	$foutnr = rawurldecode($_GET['foutnr']);
	$titel = rawurldecode($_GET['titel']);
	$omschrijving = rawurldecode($_GET['omschrijving']);
	$grammatica = rawurldecode($_GET['grammatica']);
	$leerkracht->wijzigFoutomschrijving($id,$foutnr,$titel,$omschrijving,$grammatica);
?>