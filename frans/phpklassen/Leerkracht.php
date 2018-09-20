<?php
class Leerkracht extends Gebruiker {
	//private $leerlingen;
	//private $leerlingen_inschrijvingsnummer; //zelfde array als $leerlingen maar met de inschrijvingsnummer als index
	//private $klassen;
	
	private $default_type = 2; //type van de gebruiker
	
	
	/*
	 * CONSTRUCTOR 
	 * 
	 * Eerst data van leerkracht invullen in variabelen
	 * 
	 * Dan alle leerlingen ophalen in array : leerlingen
	 * Dan alle klassen ophalen in array: klassen
	 * 
	 */
	
	public function __construct(){
		
		/*leerlingen ophalen */
		/*
			$this->leerlingen = array();
		
		$leerlingen = mysqli_query(Verbinding::$link,"SELECT inschrijvingsnummer FROM leerlingen ORDER BY klas_id ASC, klasnr");
		while($leerling = mysqli_fetch_assoc($leerlingen)){
			$this->leerlingen[] = new Leerling($leerling['inschrijvingsnummer']);
			$this->leerlingen_inschrijvingsnummer[$leerling['inschrijvingsnummer']] = new Leerling($leerling['inschrijvingsnummer']);
		}
		*/
		
			
		
		
	}
	/*
	public function geefLeerlingen($klas) {
	
			
		
					
		
		
	} 
	*/
	
	public function geefKlassen($jaar){
		$klassen = array();
		$query = mysqli_query(Verbinding::$link,"SELECT * FROM klassen WHERE jaar = $jaar ORDER BY klasnaam ASC");
		while($klas = mysqli_fetch_assoc($query)){
			$klassen[] = array("klas_id"=>$klas['id'],"klas"=>$klas['klasnaam'],"jaar"=>$klas['jaar']);
		}
	
		return $klassen;
	}
	
	
	
	
	public function geefAlleKlassen(){
		$klassen = array();
		$query = mysqli_query(Verbinding::$link,"SELECT * FROM klassen ORDER BY jaar,klasnaam ASC");
		while($klas = mysqli_fetch_assoc($query)){
			$klassen[] = array("klas_id"=>$klas['id'],"klas"=>$klas['klasnaam'],"jaar"=>$klas['jaar']);
		}

		return $klassen;
	}
	
	public function geefLeerlingen($klas_id){
		$klas_id = HelperFuncties::safety($klas_id);
		
		$leerlingen = array();
		$query = mysqli_query(Verbinding::$link,"SELECT inschrijvingsnummer FROM leerlingen WHERE klas_id=$klas_id ORDER BY klas_id ASC, klasnr");
		while($leerling = mysqli_fetch_assoc($query)){
			$leerlingen[] = new Leerling($leerling['inschrijvingsnummer']);
			//$this->leerlingen_inschrijvingsnummer[$leerling['inschrijvingsnummer']] = new Leerling($leerling['inschrijvingsnummer']);
		}
				
		return $leerlingen;
	}
	
	public function geefLeerling($inschrijvingsnummer){
		$inschrijvingsnummer = HelperFuncties::safety($inschrijvingsnummer);
		$llobj = new Leerling($inschrijvingsnummer);
		return $llobj;
	}
	
	
	public function geefDefaultType(){
		return $this->default_type;
	}
	
	
	public function vergrendelBlad($blad_id){
		$query = "UPDATE bladen SET kan_bewerken='0' WHERE id='".$blad_id."'";
		if(mysqli_query(Verbinding::$link,$query)){
			return true;
		}else{
			return false;
		}
	}
	
	public function ontgrendelBlad($blad_id){
		$query = "UPDATE bladen SET kan_bewerken='1' WHERE id='".$blad_id."'";
		if(mysqli_query(Verbinding::$link,$query)){
			return true;
		}else{
			return false;
		}
	}
	
	public function verbeterBlad($blad_id,$waarde){
		$query = "UPDATE bladen SET verbeterd='".$waarde."' WHERE id='".$blad_id."'";
		if(mysqli_query(Verbinding::$link,$query)){
			return true;
		}else{
			return false;
		}
	}
	
	
public function veranderWachtwoord($gebruikers_id,$wachtwoord,$wachtwoord2){
		if($wachtwoord !== ""){
			$wachtwoord = HelperFuncties::codeer($wachtwoord);
			$wachtwoord2 = HelperFuncties::codeer($wachtwoord2);
		
			if($wachtwoord == $wachtwoord2){
				$query = "UPDATE gebruikers SET wachtwoord='".$wachtwoord."' WHERE id='".$gebruikers_id."'";
				if(mysqli_query(Verbinding::$link,$query)){
					return true;
				}else{
					return false;
				}
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	
	public function wijzigKlas($inschrijvingsnummer,$klas_id,$klasnr){
		
			$inschrijvingsnummer = HelperFuncties::safety($inschrijvingsnummer);
			$klas_id = HelperFuncties::safety($klas_id);
			$klasnr = HelperFuncties::safety($klasnr);
		
			
				$query = "UPDATE leerlingen SET klas_id='".$klas_id."', klasnr='".$klasnr."' WHERE inschrijvingsnummer='".$inschrijvingsnummer."'";
				if(mysqli_query(Verbinding::$link,$query)){
					return true;
				}else{
					return false;
				}
			
		
	}

	
	public function wijzigSterkeZwakkePunten($inschrijvingsnummer,$sem1_sterk,$sem1_zwak,$sem2_sterk,$sem2_zwak){
		
			$inschrijvingsnummer = HelperFuncties::safety($inschrijvingsnummer);
			$sem1_sterk = HelperFuncties::safety($sem1_sterk);
			$sem1_zwak = HelperFuncties::safety($sem1_zwak);
			$sem2_sterk = HelperFuncties::safety($sem2_sterk);
			$sem2_zwak = HelperFuncties::safety($sem2_zwak);
		
			
				$query = "UPDATE leerlingen SET sterkpunt1_id='".$sem1_sterk."', zwakpunt1_id='".$sem1_zwak."', sterkpunt2_id='".$sem2_sterk."', zwakpunt2_id='".$sem2_zwak."' WHERE inschrijvingsnummer='".$inschrijvingsnummer."'";
				if(mysqli_query(Verbinding::$link,$query)){
					return true;
				}else{
					return false;
				}
			
		
	}
	
	public function voerPuntenIn($inschrijvingsnummer,$semester,$punten,$totaal){
		$inschrijvingsnummer = HelperFuncties::safety($inschrijvingsnummer);
		$semester = HelperFuncties::safety($semester);
		$punten = HelperFuncties::kommaNaarPunt($punten);
		$totaal = HelperFuncties::kommaNaarPunt($totaal);
		
		$query = "UPDATE leerlingen SET sem".$semester."_verbeterd = '1', sem".$semester."_punten='".$punten."',sem".$semester."_totaal='".$totaal."' WHERE inschrijvingsnummer='".$inschrijvingsnummer."'";
		$query2 = "UPDATE bladen SET verbeterd='1' WHERE inschrijvingsnummer='".$inschrijvingsnummer."'";
		if(mysqli_query(Verbinding::$link,$query) && mysqli_query(Verbinding::$link,$query2)){
			return true;
		}else{
			return false;
		}

	}
	
	/* semester instellen als niet verbeterd */
	public function semesterNietVebeterd($inschrijvingsnummer,$semester){
			$query = "UPDATE leerlingen SET sem".$semester."_verbeterd = '0' WHERE inschrijvingsnummer='".$inschrijvingsnummer."'";
	
		if(mysqli_query(Verbinding::$link,$query)){
				return true;
			}else{
				return false;
		}
	}
	
	/* */
	public function toggleSterkPuntOpnieuw($inschrijvingsnummer){
		$huidig = $this->geefLeerling($inschrijvingsnummer)->geefSterkPunt1_opnieuw();
		if($huidig == 1){$nieuw=0;}else{$nieuw=1;}
		
		$query = "UPDATE leerlingen SET sterkpunt1_opnieuw= '".$nieuw."' WHERE inschrijvingsnummer='".$inschrijvingsnummer."'";
	
		if(mysqli_query(Verbinding::$link,$query)){
				return true;
			}else{
				return false;
		}
	}
	
	public function toggleZwakPuntOpnieuw($inschrijvingsnummer){
		$huidig = $this->geefLeerling($inschrijvingsnummer)->geefZwakPunt1_opnieuw();
		if($huidig == 1){$nieuw=0;}else{$nieuw=1;}
		
		$query = "UPDATE leerlingen SET zwakpunt1_opnieuw= '".$nieuw."' WHERE inschrijvingsnummer='".$inschrijvingsnummer."'";
	
		if(mysqli_query(Verbinding::$link,$query)){
				return true;
			}else{
				return false;
		}
	}
	
	/* INSTELLINGEN */ 
	 
				/* De lijst van sterke en zwakke punten waaruit leerlingen kunnen kiezen wijzigen
				 * 
				 * punt_id: id van het sterk of zwak punt
				 * omschrijving  : het jaar waarin
				 * */


	
	public function foutOmschrijvingenOphalen(){
		$query = mysqli_query(Verbinding::$link,"SELECT * FROM foutomschrijvingen ORDER BY foutnr ASC ");
		$foutomschrijvingen = array();
		
		while($fout = mysqli_fetch_assoc($query)){
			$foutomschrijvingen[] = array("id"=>$fout['id'],"foutnr"=>$fout['foutnr'],"titel"=>$fout['titel'],"omschrijving"=>$fout['omschrijving'],"grammatica"=>$fout['grammatica']);
		}
		return $foutomschrijvingen;
	}
	
public function wijzigFoutomschrijving($id,$foutnr,$titel,$omschrijving,$grammatica){
		
		$id = HelperFuncties::safety($id);
		$foutnr = HelperFuncties::safety($foutnr);
		$titel = HelperFuncties::safety($titel);
		$omschrijving = HelperFuncties::safety($omschrijving);
		$grammatica = HelperFuncties::safety($grammatica);
		
		$query = "UPDATE foutomschrijvingen SET titel='".$titel."', foutnr='".$foutnr."', omschrijving='".$omschrijving."', grammatica= '".$grammatica."' WHERE id='".$id."'";
		if(mysqli_query(Verbinding::$link,$query)){
			return true;
		}else{			
			return false;
		}
	
	}
	
	public function klasWijzigen($klas_id,$klasnaam,$jaar){
		
		$klas_id = HelperFuncties::safety($klas_id);
		$klasnaam = HelperFuncties::safety($klasnaam);
		$jaar = HelperFuncties::safety($jaar);
		
		
		$query = "UPDATE klassen SET klasnaam='".$klasnaam."', jaar='".$jaar."' WHERE id='".$klas_id."'";
		if(mysqli_query(Verbinding::$link,$query)){
			return true;
		}else{
			
			return false;
		}
	
	}
	
	public function sterkzwakPuntWijzigen($id,$omschrijving,$jaar){
		
		$id = HelperFuncties::safety($id);
		$omschrijving = HelperFuncties::safety($omschrijving);
		$jaar = HelperFuncties::safety($jaar);
		
		$query = "UPDATE sterkezwakke_punten SET omschrijving='".$omschrijving."', jaar='".$jaar."' WHERE id='".$id."'";
		if(mysqli_query(Verbinding::$link,$query)){
			return true;
		}else{
			
			return false;
		}
	
	}
	
	public function nieuweFoutomschrijving(){
	
		$query = "INSERT INTO foutomschrijvingen () VALUES ()";
		if(mysqli_query(Verbinding::$link,$query)){
			return true;
		}else{
			
			return false;
		}
	}
	
	
	public function nieuwSterkZwakPunt(){
	
		$query = "INSERT INTO sterkezwakke_punten () VALUES ()";
		if(mysqli_query(Verbinding::$link,$query)){
			return true;
		}else{
			
			return false;
		}
	}
	
	public function nieuweKlas(){
		
		$query = "INSERT INTO klassen () VALUES ()";
		if(mysqli_query(Verbinding::$link,$query)){
			return true;
		}else{
			
			return false;
		}
	}
	
	
	public function verwijderSterkZwakPunt($id){
	$query = "DELETE FROM sterkezwakke_punten WHERE id='".$id."'";
		if(mysqli_query(Verbinding::$link,$query)){
			return true;
		}else{
			
			return false;
		}
	}
	
	public function verwijderFoutomschrijving($id){
	$query = "DELETE FROM foutomschrijvingen WHERE id='".$id."'";
		if(mysqli_query(Verbinding::$link,$query)){
			return true;
		}else{
			
			return false;
		}
	}
	
	public function verwijderKlas($klas_id){
		if(count($this->geefLeerlingen($klas_id)) == 0){			
			$query = <<<query
				DELETE FROM klassen WHERE id='$klas_id';
query;
			echo $query;
			if(mysqli_query(Verbinding::$link,$query)){
				return true;
			}else{
			
			return false;
			}
		}else{
			return 0; //er zitten nog leerlingen in de klas
		}
	}
	

	
}
