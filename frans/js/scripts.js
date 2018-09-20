
// Prompt voor blad aan te maken -> doorverwijzen naar home.php?nieuwblad=titel
function maakblad() {
	var titel = prompt("Geef de naam van het nieuwe OEI-blad op", "");
	if(titel){
	var sURL = unescape(window.location.pathname)+"?nieuwblad="+ titel +"";
	 window.location.href = sURL;

	}
}

//terug naar home.php
function herladen(){
	var herlaad = unescape(window.location.pathname);
	 window.location.href = herlaad;

}
//terug naar bewerk.php?blad_id=blad_id
function herladenbewerk(blad_id){
	var herlaad = unescape(window.location.pathname);
	 window.location.href = herlaad+"?pag=bewerk.php&blad_id="+blad_id;

}



//herladen naar about:blank
function herladenblank(){
	var herlaad = unescape(window.location.pathname);
	 window.location.href = "about:blank";

}

//gebruiker uitloggen
function uitloggen(){
	if(confirm("Ben je zeker dat je wil uitloggen?")){
		var herlaad = unescape(window.location.pathname);
		window.location.href = herlaad+"?uitloggen";
	}else{
		return false;
	}
}

//blad verwijderen: naar home.php?verwijderblad=id
function verwijderBlad(blad_id,titel){
	if(confirm("Ben je zeker dat je het blad '"+titel+"' wil verwijderen?")){
		var pagina = unescape(window.location.pathname);
		window.location.href = pagina+"?verwijderblad="+blad_id;
	}else{
		return false;
	}
}

//fout verwijderen: naar bewerk.php&verwijderfout=id
function verwijderFout(fout_id,blad_id){
	if(confirm("Ben je zeker dat je deze fout wil verwijderen?")){
		var pagina = unescape(window.location.pathname);
		window.location.href = pagina+"?pag=bewerk.php&verwijderfout="+fout_id+"&blad_id="+blad_id;
	}else{
		return false;
	}
}


function setAchtergrond(achtergrond){
	var pagina = unescape(window.location.pathname);
	window.location.href = pagina+"?pag=home.php&woohoo="+achtergrond+"&back="+achtergrond+"&tekst=black";
}


// naar bekijk.php?blad_id=id
function bekijkBlad(blad_id){

	var pagina = unescape(window.location.pathname);
	window.location.href = pagina+"?pag=bekijk.php&blad_id="+blad_id;

}

//naar bewerk.php?blad_id=id
function bewerkBlad(blad_id){

	var pagina = unescape(window.location.pathname);
	window.location.href = pagina+"?pag=bewerk.php&blad_id="+blad_id;

}

/*
 *Autosave functie
 *
 * 
 */
function autobewaar() {


document.getElementById('autobewaar').innerHTML = "Bezig met opslaan...";
document.invulform.target = "autosaveframe";
document.invulform.bladopslaan.click();
document.invulform.target = "autosaveframe";

/* tijd invullen van autosave */
var d = new Date();

var curr_hour = d.getHours();
var curr_minutes = d.getMinutes();

var curr_sec = d.getSeconds();

document.getElementById('autobewaar').innerHTML = "Blad opgeslagen! "+ d.getDate() +"/"+ d.getMonth() +"/"+ d.getUTCFullYear() +" - "+ curr_hour +":"+ curr_minutes +":"+ curr_sec +"";
} 






/*Fouten toevoegen
 * 
 * blad_id:: id van het blad waaraan je fouten wil toevoegen
 * toevoegen:: een boolean flag die false meegegeven moet worden.
 * 	als toevoegen false is gaat de functie eerste de autosave functie aanspreken 
 * 	als toevoegen true is gaat hij vragen hoeveel fouten je wil toevoegen en je 
 * 	doorsturen naar bewerk.php
 */
function voegfoutentoe(blad_id,toevoegen){
	if(!toevoegen){
		document.getElementById('toevoegen').value = "Even geduld a.u.b.";
		document.getElementById('toevoegen').disabled = "disabled";
		autobewaar();
		setTimeout("voegfoutentoe("+blad_id+",true)","2000");
	}else{
		var aantal = prompt("Aantal fouten (max 5): ", "1");
		if(aantal<=5){
				var gaURL = unescape(window.location.pathname)+"?pag=bewerk.php&blad_id="+blad_id+"&voegfoutentoe="+aantal+"";
				window.location.href = gaURL;
		}else{
			document.getElementById('toevoegen').disabled = false;
			document.getElementById('toevoegen').value = "Voeg fouten toe";
		}
	//document.getElementById('autobewaar').innerHTML = "Blad opgeslagen! "+ d.getDate() +"/"+ d.getMonth() +"/"+ d.getUTCFullYear() +" - "+ curr_hour +":"+ curr_minutes +":"+ curr_sec +"";
	}

}


/* Het blad sluiten terwijl je aan het bewerken bent
 * Eerst autosave
 */
function sluitBewerkblad(sluiten){ 
	if(!sluiten){
		document.getElementById('sluiten').innerHTML = "Blad opslaan...";
		document.getElementById('sluiten').disabled = "disabled";
		autobewaar();
		setTimeout("sluitBewerkblad(true)","2000");
	}else{
		herladen(); //Terug naar home
	//document.getElementById('autobewaar').innerHTML = "Blad opgeslagen! "+ d.getDate() +"/"+ d.getMonth() +"/"+ d.getUTCFullYear() +" - "+ curr_hour +":"+ curr_minutes +":"+ curr_sec +"";
	}

}





/* LEERKRACHTEN */


// naar bladverbeteren.php?blad
function corrigeerBlad(blad_id,inschrijvingsnummer){

	var pagina = unescape(window.location.pathname);
	window.location.href = pagina+"?pag=bladverbeteren.php&blad_id="+blad_id+"&inschrijvingsnummer="+inschrijvingsnummer;

}

//naar naar bladverbeteren.php
function herladenverbeteren(blad_id,inschrijvingsnummer){
	var herlaad = unescape(window.location.pathname);
	 window.location.href = herlaad+"?pag=bladverbeteren.php&blad_id="+blad_id+"&inschrijvingsnummer="+inschrijvingsnummer;

}

//naar leerling.php
function herladenleerling(inschrijvingsnummer){
	
	var herlaad = unescape(window.location.pathname);
	
	 window.location.href = herlaad+"?pag=leerling.php&inschrijvingsnummer="+inschrijvingsnummer;
	 

}

//naar leerling.php?sterkpunt1_opnieuw
function sterkpuntOpnieuw(inschrijvingsnummer){
	
	var herlaad = unescape(window.location.pathname);
	
	 window.location.href = herlaad+"?pag=leerling.php&inschrijvingsnummer="+inschrijvingsnummer+"&sterkpunt1_opnieuw";
	 

}
//naar leerling.php?zwakpunt1_opnieuw
function zwakpuntOpnieuw(inschrijvingsnummer){
	
	var herlaad = unescape(window.location.pathname);
	
	 window.location.href = herlaad+"?pag=leerling.php&inschrijvingsnummer="+inschrijvingsnummer+"&zwakpunt1_opnieuw";
	
}



//naar index.php?pag=pag
function herladenpag (pag){
	
	var herlaad = unescape(window.location.pathname);
	
	 window.location.href = herlaad+"?pag="+pag;
	 

}


//naar bekijkklas.php
function herladenklas(klas_id){
	
	var herlaad = unescape(window.location.pathname);
	
	 window.location.href = herlaad+"?pag=bekijkklas.php&klas_id="+klas_id;
	 
}

//naar leerling.php&vergrendel=blad_id
function vergrendelBlad(blad_id,inschrijvingsnummer){
	var herlaad = unescape(window.location.pathname);
	 window.location.href = herlaad+"?pag=leerling.php&inschrijvingsnummer="+inschrijvingsnummer+"&vergrendel="+blad_id;

}

//naar leerling.php&ontgrendel=blad_id
function ontgrendelBlad(blad_id,inschrijvingsnummer){
	var herlaad = unescape(window.location.pathname);
	 window.location.href = herlaad+"?pag=leerling.php&inschrijvingsnummer="+inschrijvingsnummer+"&ontgrendel="+blad_id;

}

//naar leerling.php&verbeterd=blad_id
function verbeterBlad(blad_id,inschrijvingsnummer){
	var herlaad = unescape(window.location.pathname);
	 window.location.href = herlaad+"?pag=leerling.php&inschrijvingsnummer="+inschrijvingsnummer+"&verbeterd="+blad_id;

}

//naar leerling.php&ontgrendelverbeterd=blad_id
function ontgrendelverbeterdBlad(blad_id,inschrijvingsnummer){
	var herlaad = unescape(window.location.pathname);
	 window.location.href = herlaad+"?pag=leerling.php&inschrijvingsnummer="+inschrijvingsnummer+"&ontgrendelverbeterd="+blad_id;

}

//naar wijzigWachtwoord.php
function wijzigWachtwoord(inschrijvingsnummer){
	var herlaad = unescape(window.location.pathname);
	 window.location.href = herlaad+"?pag=wijzigWachtwoord.php&inschrijvingsnummer="+inschrijvingsnummer;

}

//naar wijzigklas.php
function wijzigKlas(inschrijvingsnummer){
	var herlaad = unescape(window.location.pathname);
	 window.location.href = herlaad+"?pag=wijzigKlas.php&inschrijvingsnummer="+inschrijvingsnummer;

}

//naar wijzigsterkezwakkePunten.php
function wijzigSterkeZwakkePunten(inschrijvingsnummer){
	var herlaad = unescape(window.location.pathname);
	 window.location.href = herlaad+"?pag=wijzigSterkeZwakkePunten.php&inschrijvingsnummer="+inschrijvingsnummer;

}

/* Sluiten van blad tijdens verbeteren
 * 
 * EERST autosave DAN sluit 
 * 
 *sluit false -> autosave & sluit=true
 *sluit true -> sluit
 */
function sluitVerbeterblad(sluiten,inschrijvingsnummer){ 
	if(!sluiten){
		document.getElementById('sluiten').innerHTML = "Blad opslaan...";
		document.getElementById('sluiten').disabled = "disabled";
		autobewaar();
		setTimeout("sluitVerbeterblad(true,'"+inschrijvingsnummer+"')","2000");
	}else{
		 //Terug naar home
	//document.getElementById('autobewaar').innerHTML = "Blad opgeslagen! "+ d.getDate() +"/"+ d.getMonth() +"/"+ d.getUTCFullYear() +" - "+ curr_hour +":"+ curr_minutes +":"+ curr_sec +"";
	
		var herlaad = unescape(window.location.pathname);
		 window.location.href = herlaad+"?pag=leerling.php&inschrijvingsnummer="+inschrijvingsnummer;

	
	}

}

//naar bekijkklas.php&vergrendelbladen=true
function vergrendelBladenKlas(klas_id){
		if(confirm("Ben je zeker dat je wil doorgaan? Alle bladen van alle leerlingen van deze klas zullen worden vergrendeld.")){
		var herlaad = unescape(window.location.pathname);
		window.location.href = herlaad+"?pag=bekijkklas.php&klas_id="+klas_id+"&vergrendelbladen=true";
	}
}

//naar instellingen/instellingen.php
function instellingen(){
	var herlaad = unescape(window.location.pathname);
	 window.location.href = herlaad+"?pag=instellingen/instellingen.php";
}

//naar puntenInvoeren.php&inschrijvingsnummer= &semester= 
function puntenInvoeren(inschrijvingsnummer,semester){
	var herlaad = unescape(window.location.pathname);
	 window.location.href = herlaad+"?pag=puntenInvoeren.php&inschrijvingsnummer="+inschrijvingsnummer+"&semester="+semester;
}

//naar instellingen/foutomschrijvingenBeheren.php&verwijderomschrijving=id
function verwijderOmschrijving(id){
	if(confirm("Ben je zeker dat je deze foutomschrijving wil verwijderen?")){
		var herlaad = unescape(window.location.pathname);
		window.location.href = herlaad+"?pag=instellingen/foutomschrijvingenBeheren.php&verwijderomschrijving="+id;
	}
}

//naar instellingen/klassenBeheren.php&verwijderklas=id
function verwijderKlas(id){
	if(confirm("Ben je zeker dat je deze klas wil verwijderen?")){
		var herlaad = unescape(window.location.pathname);
		window.location.href = herlaad+"?pag=instellingen/klassenBeheren.php&verwijderklas="+id;
	}
}

// naar instellingen/sterkezwakkepuntenBeheren.php&verwijderpunt=id
function verwijderSterkZwakPunt(id){
	if(confirm("Ben je zeker dat je dit sterk/zwak punt wil verwijderen?")){
		var herlaad = unescape(window.location.pathname);
		window.location.href = herlaad+"?pag=instellingen/sterkezwakkepuntenBeheren.php&verwijderpunt="+id;
	}
}


// naar instellingen/foutomschrijvingenBeheren.php&voegomschrijvingentoe=aantal
function voegfoutomschrijvingentoe(){
	
	var aantal = prompt("Aantal nieuwe omschrijvingen: ", "1");
	if(aantal){
			var gaURL = unescape(window.location.pathname)+"?pag=instellingen/foutomschrijvingenBeheren.php&voegomschrijvingentoe="+aantal+"";
			window.location.href = gaURL;
	}
}

//naar instellingen/klassenBeheren.php&voegklassentoe=aantal
function voegklassentoe(){
	
	var aantal = prompt("Aantal nieuwe klassen: ", "1");
	if(aantal){
			var gaURL = unescape(window.location.pathname)+"?pag=instellingen/klassenBeheren.php&voegklassentoe="+aantal+"";
			window.location.href = gaURL;
	}
}


//naar instellingen/sterkezwakkepuntenBeheren.php&voegpuntentoe=aantal
function voegsterkezwakkepuntentoe(){
	
	var aantal = prompt("Aantal nieuwe sterke en/of zwakke punten: ", "1");
	if(aantal){
			var gaURL = unescape(window.location.pathname)+"?pag=instellingen/sterkezwakkepuntenBeheren.php&voegpuntentoe="+aantal+"";
			window.location.href = gaURL;
	}
}







