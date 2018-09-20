<?php
ini_set("display_errors",true);
if(isset($_POST['resetsysteem']) && $_POST['resetsysteem'] == "true"){
	
if($admin->resetSysteem()){
		echo "Het systeem is succesvol gereset";
}else{
	echo" Oei! Er is iets foutgelopen.";
}

}else{
	
	?>
	<form method="post">
	<b>Ben je zeker dat je wil resetten?</b><br><br>
		Ja: <input type="radio" name="resetsysteem" value="true" />
		Nee: <input type="radio" name="resetsysteem" value="false" >
		<input type="submit" name="reset"  value = "Reset"/>
	</form>
	
	<?php 

}
?>