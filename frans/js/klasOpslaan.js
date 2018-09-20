
function nl2br(text){
	text = text.replace(/\n/g,'<br />')
	return text;
}



function klassenOpslaan(rijnr){ //rij met rijnummer x opslaan
	
	id = document.getElementById('id_'+rijnr).value;
	
	klasnaam = document.getElementById('klasnaam_'+rijnr).value;
	
		
	jaar = document.getElementById('klasnaam_'+rijnr).value.substr(0,1);
	 id = encodeURIComponent(id);
	 klasnaam = encodeURIComponent(klasnaam);
	 jaar = encodeURIComponent(jaar);
	klasOpslaan(''+id+'',''+klasnaam+'',''+jaar+'');
}




var http = createRequestObject(); 



function createRequestObject() { 

   var req; 

   if(window.XMLHttpRequest){ 
      req = new XMLHttpRequest(); 

   } else if(window.ActiveXObject) { 

      req = new ActiveXObject("Microsoft.XMLHTTP"); 

   } else { 

      alert('Probleem'); 
   } 

   return req; 

}


 function klasOpslaan(id,klasnaam,jaar) { 

	
	
	 	
       http.open('get', '../phpajax/klasOpslaan.php?klas_id='+id+'&klasnaam='+klasnaam+'&jaar='+jaar); 
       http.onreadystatechange = handleResponseSearch; 
       http.send(null); 
      
    }

 function handleResponseSearch() { 
     
       if(http.readyState == 4 && http.status == 200){ 
    	  // alert(http.responseText);
       }

 }


