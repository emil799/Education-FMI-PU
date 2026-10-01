<html> <head> <title> Vsi4ki danni </title> </head>
<body bgcolor=lightgreen>
<h2> Vsichki danni </h2>
<table border=4 bordercolor=black cellspacing=0
  cellpadding=9 width=66%>
<caption><big><b>Mebelna borsa "Zori"</b></big></caption>
<tr  bgcolor=cyan> <th> Kod <th> Ime <th> Vid <th>Produkt<th> Suma </tr>
<?php
include "config16.php";
$sql="SELECT * FROM User ORDER BY CODE";
$result=$conn->query($sql);
if ($result->num_rows > 0) 
{   // output data of each row
  while($row = $result->fetch_assoc())    {
    echo "<tr bgcolor=yellow>\n";
    echo "<td>". $row["Code"] .
    "<td>" . $row["Name"] .
    "<td>" . $row["Kind"] .
    "<td>" . $row["Product"] .
    "<td>" . $row["Sum"];                         }
} else echo "0 results";
$conn->close();  ?>
</table> <p>
Legenda za vid klient: 1 => platil cqlata suma; 2 => 15 %;  3 => konsignaciq.<p>
Legenda za kod na produkta: 01=>leglo ; 02=> masa ; 03=> stol; <p> 
<p> <a href="index16.htm#menu>"> Menu =>  </a>
</body> </html>