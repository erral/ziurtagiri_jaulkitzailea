<?php

include("header.php");

?>
<h2>Ziurtagiri eskaera prozesatuta</h2>
<?

$dn = array(
   "countryName" => $_POST["countryName"],
   "stateOrProvinceName" => $_POST["stateOrProvinceName"],
   "localityName" => $_POST["localityName"],
   "organizationName" => $_POST["organizationName"],
   "organizationalUnitName" => $_POST["organizationalUnitName"],
   "commonName" => $_POST["commonName"],
   "emailAddress" => $_POST["emailAddress"]
);


echo "<p>Datuak ondo jasota</p>";

// We need our CA cert and it's private key
$cacert = "file:///users/sar0009/apache/conf/ZJ/Zj";
$gureprivkey = array("file:///users/sar0009/apache/conf/ZJ/EZj", "ZJsar04");



$zenbakiFitxategia = "/users/sar0009/apache/conf/ZJ/zenbakia.txt";

$fp = fopen($zenbakiFitxategia, "r");
$edukia = fread($fp,filesize ($zenbakiFitxategia));
$edukia = chop($edukia);
fclose($fp);
$izena = "/users/sar0009/apache/conf/ziurtagiriak/".$edukia."ziurtagiria.crt";



// Generate a new private (and public) key pair and CSR
$privkey = openssl_pkey_new();
$csr = openssl_csr_new($dn, $privkey);
// Export CSR
openssl_csr_export($csr, $csrdata);
// Sign CSR using our privkey
$userscert = openssl_csr_sign($csrdata, $cacert, $gureprivkey, 365,array(), $edukia);

openssl_x509_export($userscert, $certout, FALSE);


$fpZiurtagiria = fopen($izena, "w");
openssl_x509_export_to_file($userscert, $izena);
fclose($fpZiurtagiria);

// Gako ezkutua fitxategi batera pasatu
$gakofitx = "/users/sar0009/apache/conf/gakoak/".$edukia."gakoa";
openssl_pkey_export_to_file($privkey, $gakofitx, 'pasahitza',$dn);

$descriptorspec = array(
   0 => array("pipe", "r"),  // stdin is a pipe that the child will read from
   1 => array("pipe", "w"),  // stdout is a pipe that the child will write to
   2 => array("file", "/users/sar0009/apache/htdocs/var/errors.txt", "a") // stderr is a file to write to
);

$process = proc_open("openssl pkcs12 -export -out /users/sar0009/apache/conf/gakoak/".$edukia."bikotea.p12 -in ".$izena." -inkey ".$gakofitx."\n", $descriptorspec, $pipes);
if (is_resource($process)) {
	// $pipes now looks like this:
	// 0 => writeable handle connected to child stdin
        // 1 => readable handle connected to child stdout
        // Any error output will be appended to /tmp/error-output.txt
	//echo fgets($pipes[2], 1024);
	fwrite($pipes[0], "pasahitza\n");
	fwrite($pipes[0], "pasahitza\n");
	fwrite($pipes[0], "pasahitza\n");
	fclose($pipes[0]);
	fclose($pipes[1]);

	$return_value = proc_close($process);
	
}
else{
	die("Errorea!");
}

echo "<p>Pasatu zaitez gure bulegotik zure nortasuna egiaztatzeko. Erabili ezazu ".$edukia." kodea identifikatzeko</p>";

$fpErabiltzaileak = fopen("/users/sar0009/apache/conf/ZJ/jaulkitakoak.txt","a");
$balioa = print_r($dn,TRUE);
fwrite($fpErabiltzaileak,"Kodea:".$edukia." ".$balioa."\n");
fclose($fpErabiltzaileak);

$edukia = (int)$edukia;
$edukia++;

$errorea = unlink($zenbakiFitxategia);
if ($errorea == 0){
        die("Errorea, saiatu zaitez berriro");
}
$fitx = fopen($zenbakiFitxategia, "w");
fwrite($fitx, "".$edukia."");
fclose($fitx);


/*
// Show any errors that occurred here
while (($e = openssl_error_string()) != false) {
   echo $e . "\n";
}
*/

include("footer.php");

?> 


