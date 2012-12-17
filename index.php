<?php

require_once 'newmain.php';
if (isset($_POST['url']))
{
// write to database
	$Urlshort= new Urlshort();
	$url=trim(mysql_escape_string($_POST['url']));
	if ($Urlshort->addurl($url))
	{
		$id=$Urlshort->getid($url);
		$encoded=$Urlshort->encode($id);
		$url = 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'].'?id='.$encoded;
		echo "your url is ".$url."\n";
	}
}
else 
{
	$Urlshort= new Urlshort();
	$id= mysql_escape_string($_GET['id']);
	$id=$Urlshort->decode($id);
	if($id)
	{
		$location=$Urlshort->geturl($id);
		header('Location: '.$location);

	}
	else
		echo "Not in our database.'\n'";
}

?>
<html>
<body onload="document.getElementById('url').focus()">

<form action="index.php" method="post">
Url: <input type="text" name="Url">
<input type="submit">
</form>

</body>
</html>

