<?php require_once('Connections/countries.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

mysql_select_db($database_countries, $countries);
$query_country = "SELECT Name FROM country";
$country = mysql_query($query_country, $countries) or die(mysql_error());
$row_country = mysql_fetch_assoc($country);
$totalRows_country = mysql_num_rows($country);
?>
<?php require_once("core/database/connect.php"); ?>

<form>
<dl>
<dt>Country: 
  <label for="select">Select:<?php echo $row_country['Name']; ?></label>
  
  <select name="select" id="select">
  </select>
</dt>
</dl>
</form>
<?php
mysql_free_result($country);
?>
