<?php

if(isset($_POST['maakleerkracht'])){
	foreach($_POST as $naam=>$waarde){
		$$naam = $waarde;
	}
	//echo $_POST['wachtwoord'];die();
	//var_dump($_POST);die();
	if($admin->maakLeerkracht($_POST['naamcode'],$_POST['wachtwoord'],$_POST['voornaam'],$_POST['achternaam'])){
		echo"Leerkracht aangemaakt!";
	}else{
		echo"Leerkracht kan niet aangemaakt worden!";
	}

}else{

	?>
	<form method="post">
	
		<b>Naamcode: </b><input type="text" name="naamcode" /><br>
		<b>Voornaam: </b><input type="text" name="voornaam" /><br>
		<b>Achternaam: </b><input type="text" name="achternaam" /><br>
		<b>Wachtwoord: </b><input type="password" name="wachtwoord" /><br><br>
		
		<input type="submit" name="maakleerkracht" value="Maak Leerkracht aan"/>
		
		
		
	</form>
	<?php 	
}


?>
