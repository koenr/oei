<?php
session_start();

function __autoload($class){
	require_once '../phpklassen/'.$class.'.php';
}
?>
<html>
	<head>
		<title>OEI 1.0 - Thomas Goossens</title>
		<link rel="stylesheet" type="text/css" href="../styles/style.css" />
		
		<script LANGUAGE="JavaScript" SRC="../js/scripts.js"></script>
		<script LANGUAGE="JavaScript" SRC="../js/layoutEGG.js"></script>
	</head>

<body background="../images/achtergronden/gnome-green.png">


<?php 
/* mysql verbinding */
$verbinding = new Verbinding();
$verbinding->connect();






if(isset($_SESSION['fff_gebruikersnaam'])){
$leerling = new Leerling($_SESSION['fff_gebruikersnaam']);
?>
<!-- EGG LAYOUT -->



<?php 

if($leerling->verifieerSessie("".$_SESSION['fff_gebruikersnaam']."","".$_SESSION['login_hash']."") && ($leerling->controleerType($leerling->geefDefaultType(),$leerling->geefType()))){
	
	?>
	<script>
document.body.style.backgroundColor='<?php echo $leerling->geefAchtergrond()?>'; 
document.body.style.color='<?php echo $leerling->geefTekstkleur()?>';
document.body.style.backgroundImage='url(<?php echo $leerling->geefAchtergrond()?>)';
</script>
	
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
	$leerling->uitloggen();
}

}else{
	include "login.php";
}
?>

<br>
<hr>
&copy; Copyright Thomas Goossens - OEI (Online Error Inventory) 1.0 

</body>

</html>