<?php
abstract class Gebruiker {
	
	private $id;
	private $gebruikersnaam; //voor leerlingen is dit de inschrijvingsnummer, voor leerkrachten de naamcode
	private $wachtwoord;
	private $type;
	private $login_hash;
	
	
	/* LOGIN 
	 * 
	 * Gebruikersnaam wordt sql injectie veilig gemaakt
	 * Wachtwoord wordt gecodeerd
	 * Type omgeving:: 1:leerling 2:leerkracht 3: admin Dit wordt gebruikt om te zien of de gebruiker in de juiste omgeving inlogt
	 * controleerLogin: controleren of de ingegeven gebruikersdata geldig is -> return het type gebruiker als geldig en false als ongeldig
	 * 
	 * Er wordt gecontroleerd of het type omgeving waar ingelogd wordt gelijk is aan het type gebruiker
	 * 
	 * Er wordt een login hash gegenereerd: deze zal gebruikt worden om te controleren of de sessie geldig is.
	 * 
	 * Het type gebruiker, de gebruikersnaam en de login hash worden in een array gereturned
	 * Deze data uit deze array (behalve het type) worden in index.php in een SESSION variabele gestoken
	 * 
	 */
	
	
	public function login($gebruikersnaam,$wachtwoord,$type_omgeving){
		$gebruikersnaam = HelperFuncties::safety($gebruikersnaam);
		$wachtwoord = HelperFuncties::codeer($wachtwoord);
  
		$this->type = $this->controleerLogin($gebruikersnaam, $wachtwoord);
		if($this->type && ($this->type == $type_omgeving)){ 
			
			/*Gebruikersdata verzamelen */
			
			$this->login_hash = $this->bepaalHash();
			$this->gebruikersnaam = $gebruikersnaam;
			$this->wachtwoord = $wachtwoord;
			$this->id = $this->getId();
			
			$this->hashInGebruiker($this->login_hash); //login hash in gebruik plaatsen
			
			$array =  array("gebruikersnaam"=>$this->gebruikersnaam,"login_hash"=>$this->login_hash,"type"=>$this->type);
			
			return $array;//de eerste twee data uit deze array wordt gebruikt om 2 sessievariabelen aan te maken $_SESSION['gebruikersnaam'] en $_SESSION['login_hash'] de type variabele dient om te controleren of persoon op juiste plaats inlogt
			
		}else{ //type omgeving is niet gelijk aan type gebruiker
			return false;
		}
		
	}
	
	
	/* verifieerSessie
	 * 
	 * er wordt gecontoleerd of de gebruikersnaam en de overeenkomende login hash in de databank te vinden is
	 * indien
	 * TRUE: de login sessie is geldig
	 * FALSE/ de login sessie is ongeldig
	 * 
	 */
	public function verifieerSessie($gebruikersnaam,$login_hash){ /* controleren of de huidige sessie nog geldig is */
		
	$query = mysqli_query(Verbinding::$link,"SELECT * FROM gebruikers WHERE gebruikersnaam='".$gebruikersnaam."' && login_hash='".$login_hash."'")	or die (mysqli_error(Verbinding::$link));
		
		if($sessie = mysqli_fetch_object($query)){
			$this->type = $sessie->type;
			return true; //als sessie bestaat
		}else{
			return false; //als niet bestaat: return false
		}
	}
	
	//controleren of types overeenkomen (vergelijkingsfunctie)
	public function controleerType($default_type,$type){
		if($default_type == $type){
		
			return true;
		}else{
			return false;
		}
	}
	
	/* Uitloggen van de gebruiker
	 * er wordt een random login hash in de gebruiker gestoken waardoor sessie ongeldig wordt
	 * sessie wordt vernietigt
	 * */
	public function uitloggen(){
		$this->hashInGebruiker(md5(microtime())); //hash vervangen door andere -> komen niet meer overeen -> wordt uitgelogd
		session_destroy(); 
	}
	

	/* 
	 * Deze functie zorgt ervoor dat de bijkomende klasnaam bij een klas id wordt opgehaald
	 * Als de id 0 is: wegklas
	 */
	
	public function klasIDNaarKlas($id){
		
		if($id==0){
			return "Wegklas";
		}else{
			$query = mysqli_query(Verbinding::$link,"SELECT klasnaam FROM klassen WHERE id='".$id."'");
			$res = mysqli_fetch_assoc($query);
	
			return $res['klasnaam'];
		}
	}
	
	
	public function klasIDNaarJaar($id){
		
		$query = mysqli_query(Verbinding::$link,"SELECT jaar FROM klassen WHERE id='".$id."'");
		$res = mysqli_fetch_assoc($query);
		return $res['jaar'];
		
	}
	
	/* 
	 * Deze functie zorgt ervoor dat de bijkomende omschrijving bij een id van een sterk of zwak punt wordt opgehaald
	 */
	public function sterkzwakpuntIDNaarOmschrijving($id){
		$query = mysqli_query(Verbinding::$link,"SELECT omschrijving FROM sterkezwakke_punten WHERE id='".$id."'");
		$res = mysqli_fetch_assoc($query);
		return $res['omschrijving'];
	}
	/*
	 * controleerLogin: controleren of de ingegeven gebruikersdata geldig is -> return het type gebruiker als geldig en false als ongeldig
	 */
		
    private function controleerLogin($gebruikersnaam,$wachtwoord){
		$query = mysqli_query(Verbinding::$link,"SELECT * FROM gebruikers WHERE gebruikersnaam='".$gebruikersnaam."' && wachtwoord='".$wachtwoord."'")	;
		if($login = mysqli_fetch_object($query)){
		
			return $login->type; //als account bestaat: geef het type terug
		}else{
		
			return false; //als niet bestaat: return false
		}
	}
	
	/* login hash aanmaken */
	private function bepaalHash(){
		return HelperFuncties::codeer(microtime()); //"random" hash
	}
	
	/* de login hash in de gebruiker plaatsen */
	private function hashInGebruiker($hash){ //id moet al opgehaald zijn
		if(mysqli_query(Verbinding::$link,"UPDATE gebruikers SET login_hash = '".$hash."' WHERE id='".$this->id."'")){
			return true;
		}else{
			return false;
		}
	}
	
 	/* gebruikersId ophalen op basis van gebruikersnaam en wachtwoord*/
	private function getId(){
		$query = mysqli_query(Verbinding::$link,"SELECT id FROM gebruikers WHERE wachtwoord='".$this->wachtwoord."' && gebruikersnaam='".$this->gebruikersnaam."'");
		$res = mysqli_fetch_assoc($query);
		return $res['id'];
	}
	
	
	/* GETTERS */
	
	
	public function geefLoginhash(){
		return $this->login_hash;
	}
	
	public function geefType(){
		return $this->type;
	}
	
	
	public function geefSterkeZwakkePunten($jaar){
		
		$array = array();
		$query = mysqli_query(Verbinding::$link,"SELECT * FROM sterkezwakke_punten WHERE jaar='".$jaar."' ORDER BY omschrijving ASC") or die (mysqli_error(Verbinding::$link));
		
		while($punt = mysqli_fetch_assoc($query)){
			$array[] = array("id"=>$punt['id'],"omschrijving"=>$punt['omschrijving']);
		}
		
		return $array;
	}
	

	/*MAAK GEBRUIKER
	 * gebruikersnaam:: van de gebruiker
	 * wachtwoord:: NOG NIET GECODEERD!
	 * type:: type gebruiker 1, 2, 3
	 */
	
	public function maakGebruiker($gebruikersnaam, $wachtwoord, $type){
		$wachtwoord = HelperFuncties::codeer($wachtwoord);
		
		$query = "SELECT * FROM gebruikers WHERE gebruikersnaam='$gebruikersnaam'";
		$result = mysqli_query(Verbinding::$link,$query);
		$num_rows = mysqli_num_rows($result);
		if ($num_rows==0) {
			$query = "INSERT INTO gebruikers (gebruikersnaam,wachtwoord,type) VALUES ('".$gebruikersnaam."','".$wachtwoord."','".$type."')";						
			if(mysqli_query(Verbinding::$link,$query)){
				$query2 = mysqli_query(Verbinding::$link,"SELECT * FROM gebruikers WHERE gebruikersnaam='".$gebruikersnaam."' && wachtwoord='".$wachtwoord."'");
				if($a = mysqli_fetch_object($query2)){
					return $a->id;
				}else{
					return false;
				}
			}else{
				return false;
			}
		}
		else {
			return false;
		}
	}
	
	/* VERWIJDER GEBRUIKER 
	 * 
	 * id:: id van de gebruiker die verwijderd moet worden
	 */
	public function verwijderGebruiker($id){
		$query = "DELETE FROM gebruikers WHERE id='".$id."'";
		
		if(mysqli_query(Verbinding::$link,$query)){
			return true;
		}else{
			return false;
		}
	}
	
	/*
	private function bepaalIdentificatieCode(){ //inschrijvingsnummer of naamcode
		switch($type){
			case 0:
				$query = mysqli_query(Verbinding::$link,"SELECT inschrijvingsnr FROM leerlingen WHERE gebruiker_id='".$this->id."'");
				$lln = mysqli_fetch_assoc($query);
				$identificatiecode = $lln['inschrijvingsnr'];
	
			break;
			case 1:
				$query = mysqli_query(Verbinding::$link,"SELECT naamcode FROM leerkrachten WHERE gebruiker_id='".$this->id."'");
				$lk = mysqli_fetch_assoc($query);
				$identificatiecode = $lk['naamcode'];
			break;
			
			case 2:
				$query = mysqli_query(Verbinding::$link,"SELECT naamcode FROM administrators WHERE gebruiker_id='".$this->id."'");
				$admin = mysqli_fetch_assoc($query);
				$identificatiecode = $admin['naamcode'];
			break;
		}
		return $identificatiecode;
		
	}*/
	
	/* BESTAAT GEBRUIKER
	 * 
	 *  gebruikersnaam:: script controleert of de gebruikersnaam al bestaat
	 *
	 */
	public static function bestaatGebruiker($gebruikersnaam){

	$query = mysqli_query(Verbinding::$link,"SELECT * FROM gebruikers WHERE gebruikersnaam='".$gebruikersnaam."' ")or die (mysqli_error(Verbinding::$link));
		
		if(mysqli_fetch_object($query)){ //true or false
			return true; //als sessie bestaat
		}else{
			return false; //als niet bestaat: return false
		}
	}
	
	/*
	 * Sterke & Zwakke punten ophalen
	 * 
	 * steekt een array(id, omschrijving, jaar) in de array 'punten'
	 * 
	 */
	public function sterkezwakkePuntenOphalen(){
		$punten = array();
		
		$sz_punten = mysqli_query(Verbinding::$link,"SELECT * FROM sterkezwakke_punten ORDER BY jaar ASC , omschrijving ASC");
		while($punt = mysqli_fetch_assoc($sz_punten)){
			$punten[] = array("id"=>$punt['id'],"omschrijving"=>$punt['omschrijving'],"jaar"=>$punt['jaar']);
		}
		return $punten;
	}
}