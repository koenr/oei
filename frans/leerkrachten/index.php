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
		<link rel="stylesheet" type="text/css" href="../styles/leerkrachten.css" />		
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/> 

		<script LANGUAGE="JavaScript" SRC="../js/scripts.js"></script>
		<script LANGUAGE="JavaScript" SRC="../js/foutomschrijvingOpslaan.js"></script>
		<script LANGUAGE="JavaScript" SRC="../js/klasOpslaan.js"></script>
		<script LANGUAGE="JavaScript" SRC="../js/sterkzwakpuntOpslaan.js"></script>
		
	</head>

<body background="../images/achtergronden/gnome-green.png">


<?php 
/* mysql verbinding */
$verbinding = new Verbinding();
$verbinding->connect();






if(isset($_SESSION['fff_gebruikersnaam'])){
$leerkracht = new Leerkracht($_SESSION['fff_gebruikersnaam']);
?>
<!-- EGG LAYOUT -->

	<script>
document.body.style.backgroundImage='url(../images/achtergronden/gnome-green.png)';
</script>

<?php 

if($leerkracht->verifieerSessie("".$_SESSION['fff_gebruikersnaam']."","".$_SESSION['login_hash']."") && ($leerkracht->controleerType($leerkracht->geefDefaultType(),$leerkracht->geefType()))){
	
	if(!isset($_GET['pag'])){
		$pag="home.php";
	}else{
		$pag=$_GET['pag'];
	}

	if(strpos($pag,"./")){
		$pag = "home.php";
	}
	
	
	?>
	<!-- <div class="leerkrachtenheader">
		<div class="menuitem" onclick="herladen();">Home</div>
		<div class="menuitem" onclick="uitloggen();">Uitloggen</div>
	</div>-->
	<div class="uitloggen" onclick="uitloggen();"><img src='../images/logoff.png' height="17"/> Uitloggen</div>
	<div class="settings" onclick="instellingen();"><img src='../images/settings.png' height="17"/> Instellingen</div>
	<div class="locatieinfo">
	
	<?php 
		if(isset($_GET['pag']) && substr($_GET['pag'],0,12) == "instellingen"){ echo "<a href='?pag=home.php'>Home</a> > <a href='?pag=instellingen/instellingen.php'>Instellingen</a>"; }
		if(isset($_GET['pag']) && $_GET['pag']=="instellingen/foutomschrijvingenBeheren.php"){ echo " > Foutomschrijvingen beheren"; }
		if(isset($_GET['pag']) && $_GET['pag']=="instellingen/klassenBeheren.php"){ echo " > Klassen beheren"; }
		if(isset($_GET['pag']) && $_GET['pag']=="instellingen/sterkezwakkepuntenBeheren.php"){ echo " > Actiepunten beheren"; }
		
		if(!isset($_GET['pag']) || $_GET['pag']=="home.php"){ echo "Klassen"; }
		if(isset($_GET['klas_id'])){echo "<a href='?pag=home.php'>Klassen</a> > ";echo $leerkracht->klasIDNaarKlas($_GET['klas_id']); }
		if(isset($_GET['inschrijvingsnummer'])){$leerling= new Leerling($_GET['inschrijvingsnummer']); echo "<a href='?pag=home.php'>Klassen</a> > "; echo "<a href='?pag=bekijkklas.php&klas_id=".$leerling->geefKlasID()."'>".$leerling->klasIDNaarKlas($leerling->geefKlasID()).""; echo"</a> > "; if($_GET['pag']=="bladverbeteren.php" || $_GET['pag']=="wijzigWachtwoord.php" || $_GET['pag']=="wijzigKlas.php" || $_GET['pag']=="wijzigSterkeZwakkePunten.php" || $_GET['pag'] == "puntenInvoeren.php"){echo"<a href='?pag=leerling.php&inschrijvingsnummer=".$leerling->geefInschrijvingsnummer()."'>";}echo "".$leerling->geefVoornaam()."&nbsp;".$leerling->geefAchternaam()."</a> (".$leerling->geefKlasNr().")";}

		if(isset($_GET['pag']) && ($_GET['pag'] == "bladverbeteren.php")){echo " > Blad verbeteren ";}
		if(isset($_GET['pag']) && ($_GET['pag'] == "wijzigWachtwoord.php")){echo " > Wachtwoord wijzigen ";}
		if(isset($_GET['pag']) && ($_GET['pag'] == "wijzigKlas.php")){echo " > Klas wijzigen ";}
		if(isset($_GET['pag']) && ($_GET['pag'] == "wijzigSterkeZwakkePunten.php")){echo " > Actiepunten wijzigen ";}
		if(isset($_GET['pag']) && ($_GET['pag'] == "puntenInvoeren.php")){echo " > Punten invoeren ";}
	
	?>
	
	</div>
	<div class="leerkrachteninclude">
	<?php 
	if(!include_once("paginas/".$pag."")){
		die("De pagina kon niet geladen worden");
	}
	?>
	</div>
	<?php 
}else{
	$leerkracht->uitloggen();
}

}else{
	include "login.php";
}
?>
<br>

<div style="margin-top:300px;">
<hr>
&copy; Copyright Thomas Goossens - OEI 1.0 
</div>

</body>

</html>