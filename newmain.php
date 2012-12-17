<?php

define('URL_FORMAT',
'/^(https?):\/\/'.                                         // protocol
'(([a-z0-9$_\.\+!\*\'\(\),;\?&=-]|%[0-9a-f]{2})+'.         // username
'(:([a-z0-9$_\.\+!\*\'\(\),;\?&=-]|%[0-9a-f]{2})+)?'.      // password
'@)?(?#'.                                                  // auth requires @
')((([a-z0-9]\.|[a-z0-9][a-z0-9-]*[a-z0-9]\.)*'.                      // domain segments AND
'[a-z][a-z0-9-]*[a-z0-9]'.                                 // top level domain  OR
'|((\d|[1-9]\d|1\d{2}|2[0-4][0-9]|25[0-5])\.){3}'.
'(\d|[1-9]\d|1\d{2}|2[0-4][0-9]|25[0-5])'.                 // IP address
')(:\d+)?'.                                                // port
')(((\/+([a-z0-9$_\.\+!\*\'\(\),;:@&=-]|%[0-9a-f]{2})*)*'. // path
'(\?([a-z0-9$_\.\+!\*\'\(\),;:@&=-]|%[0-9a-f]{2})*)'.      // query string
'?)?)?'.                                                   // path and query string optional
'(#([a-z0-9$_\.\+!\*\'\(\),;:@&=-]|%[0-9a-f]{2})*)?'.      // fragment
'$/i');

/**
 * Verify the syntax of the given URL. 
 * 
 * @access public
 * @param $url The URL to verify.
 * @return boolean
 */
function is_valid_url($url) {
  if (str_starts_with(strtolower($url), 'http://localhost')) {
    return true;
  }
  return preg_match(URL_FORMAT, $url);
}


/**
 * String starts with something
 * 
 * This function will return true only if input string starts with
 * niddle
 * 
 * @param string $string Input string
 * @param string $niddle Needle string
 * @return boolean
 */
function str_starts_with($string, $niddle) {
      return substr($string, 0, strlen($niddle)) == $niddle;
}


//echo is_valid_url("localserver.com/projects/public/assets/javascript/widgets/UserBoxMenu/widget.css");
$DBNAME='urldb';
$TABLENAME='urls';
$HOSTNAME='localhost';
$USERNAME='root';
$PASSWORD='F@@db@ck';
$operation=0;                    // 0 read , 1 write , by default read
$urlstring=explode(" ","a b c d e f g h i j k l m n o p q r s t u v w x y z A B C D E F G H I J K L M N O P Q R S T U V W X Y Z");


Class Urlshort
{

	function Urlshort()
	{
		global $DBNAME,$TABLENAME,$HOSTNAME,$USERNAME,$PASSWORD,$operation,$urlstring;
		mysql_connect($HOSTNAME,$USERNAME,$PASSWORD) or die('Database connection could not be established');
		mysql_select_db($DBNAME) or die('Database could not be selected');
	}


	function getid($url)
	{
		global $DBNAME,$TABLENAME,$HOSTNAME,$USERNAME,$PASSWORD,$operation,$urlstring;
		$query='SELECT id FROM '.$TABLENAME.' WHERE (url="'.$url.'")';
		$returned=mysql_query($query);

		if(mysql_num_rows($returned))
		{
			$row=mysql_fetch_array($returned);
			return $row['id'];
		}
		else
			return -1;
	}

	function geturl($id)
	{
		global $DBNAME,$TABLENAME,$HOSTNAME,$USERNAME,$PASSWORD,$operation,$urlstring;
		$query='SELECT url FROM '.$TABLENAME.' WHERE (id="'.$id.'")';
		$returned=mysql_query($query);

		if(mysql_num_rows($returned))
		{
			$row=mysql_fetch_array($returned);
			return $row['url'];
		}
		else
			return -1;
	}

	function addurl($url)
	{
		global $DBNAME,$TABLENAME,$HOSTNAME,$USERNAME,$PASSWORD,$operation,$urlstring;
		if ($this->getid($url))
			return 1;
		else
		{
			$query= 'INSERT INTO '.$TABLENAME.'(url,date) VALUES ("'.$url.'",NOW())';
			return mysql_query($query);
		}
	}

	function encode($id)
	{
		$r= $id%52;
		$res=$urlstring[$r];
		$q=floor($id/52);
		while($q)
		{
			$r=$q%52;
			$q=floor($q/52);
			$res=$urlstring[$r].$res;
		}
		return $res;
	}
	function decode($id)
	{
		$res=strpos($urlstring,$id[0]);
		$limit=strlen($id);
		for($i=1;$i<$limit;$i++) {
			$res = $b * $res + strpos(52,$id[$i]);
		}
		return $res;
	}

}




//echo $urlstring[2]."\n";
?>
