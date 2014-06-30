<?
	include("../header.php");
?>
	<h2>Jaulkitako ziurtagirien zerrenda</h2>
<?
	if ($handle = opendir('../deskargatu')) {
	   while (false !== ($file = readdir($handle))) {
		   if (substr($file, -3) == 'crt') {
?>
			<a href="../deskargatu/<?=$file;?>"><?=$file;?></a><br/>
<?
$descriptorspec = array(
   0 => array("pipe", "r"),  // stdin is a pipe that the child will read from
   1 => array("pipe", "w"),  // stdout is a pipe that the child will write to
   2 => array("file", "/users/sar0009/apache/logs/var/error.txt", "a") // stderr is a file to write to
);
$process = proc_open("openssl x509 -subject -noout -in ../deskargatu/".$file."\n", $descriptorspec, $pipes);
if (is_resource($process)) {
   // $pipes now looks like this:
   // 0 => writeable handle connected to child stdin
   // 1 => readable handle connected to child stdout
   // Any error output will be appended to /tmp/error-output.txt

   /*fwrite($pipes[0], "<?php echo \"Hello World!\"; ?>");
   */
   fclose($pipes[0]);

   while (!feof($pipes[1])) {
       echo fgets($pipes[1], 1024);
   }
   fclose($pipes[1]);
   // It is important that you close any pipes before calling
   // proc_close in order to avoid a deadlock
   $return_value = proc_close($process);

   echo "command returned $return_value\n";
}


			}
	   }
	   closedir($handle);
	}
	else{
		die("Errorea zerrenda lortzerakoan. Abisatu administratzaileari");
	}

	include("../footer.php");
?>

