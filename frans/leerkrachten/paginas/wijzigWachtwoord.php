<?php

$leerling = $leerkracht->geefLeerling($_GET['inschrijvingsnummer']);
$inschrijvingsnummer = $leerling->geefInschrijvingsnummer();
$voornaam = $leerling->geefVoornaam();
$achternaam = $leerling->geefAchternaam();
$gebruiker_id = $leerling->geefGebruikerID();

if(!isset($_POST['wijzigwachtwoord'])){

echo <<<HTML
<h3>$voornaam $achternaam</h3><br><br>

<form method="post">
<table>
	<tr>
		<td><b>Nieuw wachtwoord invoeren</b></td>
		<td><input type="password" name="wachtwoord1" /></td>
	</tr>
	<tr>
		<td><b>Nieuw wachtwoord herhalen</b></td>
		<td><input type="password" name="wachtwoord2" /></td>
	</tr>

	<tr>
		<td><input type="submit" name="wijzigwachtwoord" value="Wijzig het wachtwoord" /> </td>
HTML;
echo"
		<td></td>
	</tr>

</table>
</form>
<button onclick=\"herladenleerling('$inschrijvingsnummer');\">Annuleren</button>
";

}else{
	if ($leerkracht->veranderWachtwoord($gebruiker_id, $_POST['wachtwoord1'], $_POST['wachtwoord2'])){
		echo"Het wachtwoord is succesvol gewijzigd.";
		echo"<br><br	
			<button onclick=\"herladenleerling('$inschrijvingsnummer');\">Ga terug naar de leerling</button>
		";
	}else{
		echo"O jee! Er is iets foutgelopen.";
	}
}
?>