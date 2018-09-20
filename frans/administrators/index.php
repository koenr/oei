<?php
session_start();
ini_set("display_errors",TRUE);
function __autoload($class){
	require_once '../phpklassen/'.$class.'.php';
}
?>
<html>
	<head>
		<title>OEI 1.0 - Thomas Goossens</title>
		<link rel="stylesheet" type="text/css" href="../styles/style.css" />
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/> 
		
		<script LANGUAGE="JavaScript" SRC="../js/scripts.js"></script>
		<script LANGUAGE="JavaScript" SRC="../js/layoutEGG.js"></script>
	</head>

<body background="../images/achtergronden/gnome-green.png">


<?php 
/* mysql verbinding */
$verbinding = new Verbinding();
$verbinding->connect();






if(isset($_SESSION['fff_gebruikersnaam'])){
$admin = new Administrator($_SESSION['fff_gebruikersnaam']);
?>
<!-- EGG LAYOUT -->



<?php 

if($admin->verifieerSessie("".$_SESSION['fff_gebruikersnaam']."","".$_SESSION['login_hash']."") && ($admin->controleerType($admin->geefDefaultType(),$admin->geefType()))){
	
	?>

	
	<?php 
	
	if(!isset($_GET['pag'])){
		$pag="home.php";
	}else{
		$pag=$_GET['pag'];
	}

	if(strpos($pag,"./")){
		$pag = "home.php";
	}
	
	if(!include_once("paginas/".$pag."")){
		die("De pagina kon niet geladen worden");
	}

}else{
	$admin->uitloggen();
}

}else{
	include "login.php";
}
?>

<br>
<div style="margin-top:300px;"> 
<hr>
&copy; Copyright Thomas Goossens - OEI (Online Error Inventory) 1.0 
</div>

</body>

</html>