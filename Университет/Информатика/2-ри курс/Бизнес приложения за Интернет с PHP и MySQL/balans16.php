<html> <head>
<meta http-equiv="content-type" content="text/html; charset=windows-1251">
<title> Balans </title> </head>
<body bgcolor=lightgreen>
<h3> Balans na firmata </h3>
<table border=4 bordercolor=black cellspacing=0 cellpadding=15 width=50%>
<caption><big><b> Balans na firmata </b></big></caption>
<tr bgcolor=cyan> <th> Kod <th> Ime
<th> Vid na sumata <th> Produkt <th> Suma  </tr>

<?php
include "config16.php";
$s=0;
$sql="SELECT * FROM User WHERE Kind=1 OR Kind=2";
$result=$conn->query($sql);
if ($result->num_rows > 0)
{
  while($row = $result->fetch_assoc())
  {
    echo "<tr bgcolor=yellow>\n";
    echo "<td>". $row["Code"].
    "<td>" . $row["Name"].
    "<td>" . $row["Kind"].
    "<td>" . $row["Product"].
    "<td>" . $row["Sum"];
    
	  $s+=$row["Sum"];
	
	echo "</tr>\n";
  }
} else echo "0 results";
$conn->close();

$s=round($s,2);
echo "<tr bgcolor=yellow>";
echo "<th colspan=2> Balans:";
echo "<th colspan=2>" . $s . "</tr>\n";
?>
</table>  <p>
Legenda za vida: 1 => cqlata suma; 2=> 15 % .
<p> <a href="index16.htm#menu>"> Menu =>  </a>
</body> </html>



