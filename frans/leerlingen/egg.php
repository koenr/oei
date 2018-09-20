<script>

var str1;
var str2;
var str3;
var tel = 0;


function layout(letter){
	
	tel++;
	if(tel==1){
		str1=letter;
	}
	if(tel==2){
		str2=letter;
	}
	if(tel==3){
		str3=letter;
		if((str1+str2+str3) == "FFF"){
			alert("Proficiat! Je hebt net iets speciaals ontdekt...");
			if(confirm("Het gebruik van deze functie is op eigen risicio, de maker kan niet verantwoordelijk gesteld worden voor mogelijke gevolgen. Wil je nog doorgaan?")){
			tekstkleur = prompt("Kies een tekstkleur (gebruik engelse benaming of een HEX kleurencode): ", "<?php echo $leerling->geefTekstkleur();?>");
			achtergrond = prompt("Kies een achtergrond (gebruik de URL van een afbeelding (niet op jouw computer) of een HEX kleurcode): ", "<?php echo $leerling->geefAchtergrond();?>");
			alert("Dit systeem werd gemaakt door Thomas Goossens - www.funnyplay.be");
			if(tekstkleur || achtergrond){
				var sURL = unescape(window.location.pathname)+"?woohoo=<?php echo $leerling->geefLoginhash(); ?>&tekst="+tekstkleur+"&back="+achtergrond+"";
				 window.location.href = sURL;
							
			}
			}
			tel=0;
		}else{
		
			tel=0;
		}
	}
	

	

}

</script>