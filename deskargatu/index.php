<?
include("../header.php");

	if ($_GET["kodea"]){

		$kodea = $_GET["kodea"];
		if (file_exists($kodea."ziurtagiria.crt")){
?>

			<h2>Deskargatu ziurtagiria eta gako bikotea</h2>

			<a href="<? echo "./".$kodea."ziurtagiria.crt";?>">Ziurtagiria</a>
			<br/>
			<a href="<? echo "./".$kodea."bikotea.p12";?>">Gako bikotea</a>
<?
		}
		else{
?>
			<h2>Kode okerra</h2>
			<p><a href="index.php">Atzera</a></p>

<?		}			
	}
	else{
?>
		<h2>Deskarga eremua</h2>
		<form action="index.php" action="GET">
			<p>Sartu bulegoan emandako kodea: <input type="text" name="kodea"/></p>
			<p><input type="submit" value="Deskargatu"/></p>
		</form>
<?
	}

include("../footer.php");
?>
	
