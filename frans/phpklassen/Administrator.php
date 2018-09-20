<?php
class Administrator extends Gebruiker {
	private $default_type = 3; //type van de gebruiker
	
	public function geefDefaultType(){
		return $this->default_type;
	}
	
	/* RESET FUNCTIE 
	 * 
	 * 1. sterke & zwakke puntenarchief maken (enkel voor frans nodig)
	 * 2. Leerlingen verwijderen: gebruiker & leerling wordt verwijderd
	 * 3. ALle bladen en fouten verwijderen 
	 *
	 *
	 *Enkel als stap n gelukt is zal stap n+1 uitgevoerd worden
	 *
	 * output moet: 0123 zijn
	 * 
	 */
	
	public function resetSysteem(){
		echo"0";
		if($this->maakSterkeZwakkePuntenArchief()){
			echo"1";
			if($this->verwijderLeerlingen()){
				echo"2";
				if($this->verwijderBladen()){
					echo"3";
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
	
	
	/* Verwijder Leerlingen */
	/*
	 *Eerst de gebruikeraccount verwijderen
	 *Dan de rijen in de tabel leerlingen verwijderen 
	 * 
	 */
	public function verwijderLeerlingen(){
		$query = "DELETE FROM gebruikers WHERE type='1' "; 
		$query2 = "TRUNCATE TABLE leerlingen"; 
		
		if(mysqli_query(Verbinding::$link,$query) & mysqli_query(Verbinding::$link,$query2)){
			return true;
		}else{
			return false;
		}
			
	}
	
	/* Verwijder bladen 
	 * 
	 * Eerst bladen verwijderen dan alle fouten
	 */
	public function verwijderBladen(){
	
		$query = "TRUNCATE TABLE bladen"; 
		$query2 = "TRUNCATE TABLE fouten"; 
		
		if(mysqli_query(Verbinding::$link,$query) & mysqli_query(Verbinding::$link,$query2)){
			return true;
		}else{
			return false;
		}
			
	}
	

	
	/* ARCHIVEREN VAN STERKE & ZWAKKE PUNTEN
	 * 
	 * 1. vorig archief verwijderen
	 * 2. leerlingen ophalen waarvan een archief gemaakt moet worden: vijfde en zesdejaars
	 * 3. per leerling de sterke en zwakke punten ophalen in tekstvorm
	 * 4. Gegevens archviveren
	 */
	public function maakSterkeZwakkePuntenArchief(){ 
		ini_set("display_errors",true);
		$query = "TRUNCATE TABLE sterkezwakke_punten_vorigjaar"; //verwijder vorig archief
		
		if(mysqli_query(Verbinding::$link,$query) ){
			
		// leerlingen ophalen van 5de & 6de jaar
		$leerlingen_5 = $this->geefLeerlingen(5);
		$leerlingen_6 = $this->geefLeerlingen(6);
			
			
		
		//sterke en zwakke punten ophalen
		//echo "test: ".$leerlingen_5[0]->geefVoornaam()."";
		
		$flag=false;
		
			if(count($leerlingen_5)>0){
		foreach($leerlingen_5 as $nr=>$leerling){
		
			$sterkpunt1 = $this->sterkzwakpuntIDNaarOmschrijving($leerling->geefSterkZwakPunt("sterk", 1));
			
			$sterkpunt2 = $this->sterkzwakpuntIDNaarOmschrijving($leerling->geefSterkZwakPunt("sterk", 2));
			$zwakpunt1 = $this->sterkzwakpuntIDNaarOmschrijving($leerling->geefSterkZwakPunt("zwak", 1));
			$zwakpunt2 = $this->sterkzwakpuntIDNaarOmschrijving($leerling->geefSterkZwakPunt("zwak", 2));
		
			//in archief plaatsen
				if($this->zetInArchief("".$leerling->geefInschrijvingsnummer()."", "".$sterkpunt1."", "".$sterkpunt2."", "".$zwakpunt1."", "".$zwakpunt2."")){
					$flag=true;
				}else{
					$flag=false;
				}
		
						
			
		}
			}
		
			if(count($leerlingen_6)>0){
		//sterke en zwakke punten ophalen
		foreach($leerlingen_6 as $nr=>$leerling){
			
			$sterkpunt1 = $this->sterkzwakpuntIDNaarOmschrijving($leerling->geefSterkZwakPunt("sterk", 1));
			$sterkpunt2 = $this->sterkzwakpuntIDNaarOmschrijving($leerling->geefSterkZwakPunt("sterk", 2));
			$zwakpunt1 = $this->sterkzwakpuntIDNaarOmschrijving($leerling->geefSterkZwakPunt("zwak", 1));
			$zwakpunt2 = $this->sterkzwakpuntIDNaarOmschrijving($leerling->geefSterkZwakPunt("zwak", 2));
		
			//in archief plaatsen
				if($this->zetInArchief("".$leerling->geefInschrijvingsnummer()."", "".$sterkpunt1."", "".$sterkpunt2."", "".$zwakpunt1."", "".$zwakpunt2."")){
					$flag=true;
				}else{
					$flag=false;
				}
		}
			}
		
		}
		
		if($flag){
			return true;
		}else{
			return false;
		}
	}
	
	/* Geef leerlingen
	 * 
	 * jaar:: het studiejaar van de leerlingen die je wil opvragen bv.: 5 -> leerlingen in het vijfde middelbaar
	 * 
	 */
	
	public function geefLeerlingen($jaar){
		$leerlingen_arr = array();
		//alle leerlingen ophalen 
		$leerlingen = mysqli_query(Verbinding::$link,"SELECT inschrijvingsnummer FROM leerlingen ORDER BY klas_id ASC, klasnr ASC");
		while($leerling = mysqli_fetch_assoc($leerlingen)){
			$leerlingen_arr[] = new Leerling($leerling['inschrijvingsnummer']);
		}
		
		//leerlingen in het ingegeven 'jaar' selecteren en plaatsen in een array 'leerlingen_return'
		$jaar = HelperFuncties::safety($jaar);
		$leerlingen_return = array();
		for($i=0;$i<count($leerlingen_arr);$i++){
			echo"--".$this->klasIDNaarJaar($leerlingen_arr[$i]->geefKlasID())."--";
			if($this->klasIDNaarJaar($leerlingen_arr[$i]->geefKlasID()) == $jaar) {
				$leerlingen_return[] = new Leerling($leerlingen_arr[$i]->geefInschrijvingsnummer());
			
			}
		}
	
		//print_r($leerlingen_return);
		return $leerlingen_return;
	}
	
	/* Archiveren van sterke & zwak punten
	 * 
	 * een record maken in de tabel 'sterkezwakke_punten_punten' 
	 * 
	 * inschrijvingsnummer:: van de leerling
	 * sterkpunt1:: sterk punt eerste semester in tekstvorm
	 */
	public function zetInArchief($inschrijvingsnummer,$sterkpunt1,$sterkpunt2,$zwakpunt1,$zwakpunt2){
		
		$query = "INSERT INTO sterkezwakke_punten_vorigjaar (inschrijvingsnummer,sterkpunt1,sterkpunt2,zwakpunt1,zwakpunt2) VALUES ('".$inschrijvingsnummer."','".$sterkpunt1."','".$sterkpunt2."','".$zwakpunt1."','".$zwakpunt2."')";
			mysqli_query(Verbinding::$link,$query) or die(mysqli_error(Verbinding::$link));
		if(mysqli_query(Verbinding::$link,$query)){
			//echo"ja";
			return true;
		}else{
			//echo"probleem";
			return false;
		}
	}
	
	
	/* LEERKRACHT AANMAKEN
	 * 
	 * naamcode:: van leerkracht
	 * wachtwoord:: NIET GECODEERD!
	 * voornaam:: van leerkracht
	 * achternaam:: van leerkracht
	 * 
	 * Eerst gebruiker type 2 aanmaken dan leerkracht 
	 */
	
	
	public function maakLeerkracht($naamcode,$wachtwoord,$voornaam,$achternaam){
		
	
		$gebruiker_id = Gebruiker::maakGebruiker($naamcode,$wachtwoord,2);
		if($gebruiker_id){
			
echo"id: ".$gebruiker_id."";
		$query = "INSERT INTO leerkrachten (gebruiker_id, naamcode, voornaam, achternaam) VALUES ('".$gebruiker_id."','".$naamcode."','".$voornaam."','".$achternaam."') ";
			//echo $query;	
		if(mysqli_query(Verbinding::$link,$query)){
				return true;
			}else{//leerkracht kon niet aangemaakt worden
				return false;
			}
			
		}else{
			return false;
		}
	}
			
			
	
}
