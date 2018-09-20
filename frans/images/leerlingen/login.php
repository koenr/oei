
<?php 
	/* leerling */
	if(isset($_POST['fff_inloggen'])){
	$leerling = new Leerling(""); // nog geen leerlingencode bekend
	
	if($login = $leerling->login("".$_POST['gebruikersnaam']."", "".$_POST['wachtwoord']."",1)){
		$_SESSION['fff_gebruikersnaam'] = $login['gebruikersnaam'];
		$_SESSION['login_hash'] = $login['login_hash'];
		
		echo"Even geduld...";
		echo"<script>herladen();</script>";
	}else{
		echo"O jee! Je hebt geen toegang.";
	}
	}else{
	
?>
<span style="font-size:3em;">OEI 1.0 </span>- <span style="font-size:1em;">Thomas Goossens</span><br><br>

<form method="post">
<table>
<tr>
	<td><b>Gebruikersnaam: </b></td>
	<td><input type="text" name="gebruikersnaam" /></td>
</tr>

<tr>
	<td><b>Wachtwoord</b></td>
	<td><input type="password" name="wachtwoord" /></td>
</tr>

<tr><td><input type="submit" name="fff_inloggen" value="inloggen"></td></tr>

</table>
</form> 

<br>

<?php 
	}
	?>