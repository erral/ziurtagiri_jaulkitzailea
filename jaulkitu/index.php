<?

include("../header.php");

if ($_GET["kodea"]){

	$kodea =  $_GET["kodea"];
	$jaulkitakoak = "/users/sar0009/apache/conf/ZJ/jaulkitakoak.txt";
	$fp = fopen($jaulkitakoak,"r");
	$edukia = fread($fp,filesize($jaulkitakoak));
	$edukia = str_replace("\n"," ",$edukia);
	$edukia = str_replace("\r"," ",$edukia);
	preg_match("/Kodea\:".$kodea."[^\)]*\) /i", $edukia, $match);
	var_dump($match);
	fclose($fp);
?>
	<h2>Onartu datuak</h2>

	<form action="index.php" method="GET">
		<p><input type="hidden" name="onartu" value="<?=$kodea; ?>"/></p>
		<p><input type="submit" value="Datuak onartu"/>
        <input type="button" value="Datuak ez onartu" onclick="javascript:history.back(1)"/></p>
	</form>

<?
}

else if ($_GET["onartu"]){
	$onartu = $_GET["onartu"];
	$path = "/users/sar0009/apache/conf";
	$kodea = rand(0,10000000);
	$bool = copy($path."/ziurtagiriak/".$onartu."ziurtagiria.crt", "/users/sar0009/apache/htdocs/deskargatu/".$kodea."ziurtagiria.crt");
	if(!unlink($path."/ziurtagiriak/".$onartu."ziurtagiria.crt")){
		die("Errorea. Abisatu administratzaileari");
	}

	$bool = copy($path."/gakoak/".$onartu."bikotea.p12","/users/sar0009/apache/htdocs/deskargatu/".$kodea."bikotea.p12");
	if(!unlink($path."/gakoak/".$onartu."bikotea.p12")){
		die("Errorea. Abisatu administratzaileari");
	}
	
	$jaulkitakoak = "/users/sar0009/apache/conf/ZJ/jaulkitakoak.txt";
	

	// jaulkitakoak.txt fitxategitik onartutako ziurtagiriaren erreferentzia ezabatu
        $fp = fopen($jaulkitakoak,"r");
        $edukia = fread($fp,filesize($jaulkitakoak));
        $edukia = str_replace("\n"," ",$edukia);
        $edukia = str_replace("\r"," ",$edukia);
	$berria = preg_replace("/Kodea\:".$onartu."[^\)]*\) /i","", $edukia);	
	fclose($fp);

	if(!unlink($jaulkitakoak)){
		die("Errorea. Abisatu administratzaileari");
	}
	$fp = fopen($jaulkitakoak,"w");
	fwrite($fp,$berria);
	fclose($fp);
	


?>
	<h2>Datuak onartuta</h2>
	<p>Eskerrik asko gure zerbitzuak erabiltzeagatik.</p>
	<p>Erabil ezazu pasahitz hau gure webgunean ziurtagiria lortzeko</p>
	<p><?=$kodea;?></p>
	<p>Gako ezkutuaren pasahitza hauxe da: pasahitza</p>
<?

}

else{

?>
	<h2>Egiaztatu eskaera</h2>
	<form action="index.php" method="get">
		<p>Sartu eskaeraren kodea: <input type="text" name="kodea"/></p>
		<p><input type="submit" value="Eskaera prozesatu"/></p>
	</form>
<?
}

include("../footer.php");
?>


