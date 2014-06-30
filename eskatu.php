<?
include("header.php");
?>
<h2>Ziurtagiriaren eskaera</h2>

<form action="ziurtagiriaEskatu.php" method="post">
<p>Sartu zure datuak:</p>
<p>Herrialdea <input type="text" name="countryName"/></p>
<p>Lurraldea <input type="text" name="stateOrProvinceName"/></p>
<p>Herria <input type="text" name="localityName"/></p>
<p>Erakundearen izena <input type="text" name="organizationName"/></p>
<p>Sailaren izena <input type="text" name="organizationalUnitName"/></p>
<p>Zure izena <input type="text" name="commonName"/></p>
<p>e-posta helbidea <input type="text" name="emailAddress"/></p>
<p><input type="submit" value="Bidali"/></p>
</form>

<?
include("footer.php");
?>
