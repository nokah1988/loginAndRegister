<?php

$connect_error = "sorry, we\'re experiening connection problems.";

mysql_connect('xxxxxxxxxx', 'xxxxxxxxxxxx', 'xxxxxxxxxxxx') or die($connect_error);
mysql_select_db('loginandregister') or die($connect_error);

?>
