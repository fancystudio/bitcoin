<?php
mail("info@fancystudio.sk","chyba",$_REQUEST["RES"],"From:info@fancystudio.sk \r\nMIME-Version: 1.0\r\nContent-Type: text/html; charset=UTF-8\r\n");
  header('Location: http://www.kupitbitcoin.sk/index.php?page=error');
?>