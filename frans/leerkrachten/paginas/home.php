<?php
/* ******************
 *                  *
 * GET EVENTS       *
 *                  *
 * ******************/

/* uitloggen */
if(isset($_GET['uitloggen'])){
	$leerkracht->uitloggen();
	echo"<script>herladen();</script>";
}
?>

<div style="margin-left:200px; margin-right:auto;">
<?php 
for($i=1;$i<=6;$i++){
	$jaarklassen = "klassen_".$i."";
	$$jaarklassen = $leerkracht->geefKlassen($i);
?>

<div class="klassenlijst">
<b><?php echo $i; if($i>1){echo "de";}else{echo "ste";}?> jaar</b><br>
<hr>
<?php 
$klassen = "klassen_".$i."";
foreach($$klassen as $nr=>$klas){
	echo"<a href='?pag=bekijkklas.php&klas_id=".$klas['klas_id']."'>".$klas['klas']."</a><br>";
}

?></div>




<?php }?></div>
<div class="klassenlijst">
<b>Wegklas</b><br>
<hr>


<a href='?pag=bekijkklas.php&klas_id=0'>Wegklas</a><br>

</div>
