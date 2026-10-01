<?php
include "config16.php";
$sql= "INSERT INTO User(Code,Name,Kind,Product,Sum) VALUES ".
"(1,'Hotel Maritza',1,01,125),".
"(2,'Restaurant Hawaii',2,02,100),".
"(3,'Banka BAKB',3,03,155)";
if ($conn->query($sql) === TRUE)
   {     echo "<p>Tabliza User e popalnena s 3 zapisa uspe6no";  }
else {  echo "<p>Error insert table: " . $conn->error; }
$conn->close();
?>