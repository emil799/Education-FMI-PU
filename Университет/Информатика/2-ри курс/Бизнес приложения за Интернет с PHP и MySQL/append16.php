<html>  <head>  <title> Append </title>  </head>
<body bgcolor=Lightblue>  <h3> Append </h3>

<?php
include "config16.php";
if(isset($_POST['submit']))
{
  $sql= "INSERT INTO User (Code,Name,Kind,Product,Sum) VALUES (" .
  (int)$_POST["Code"] . ",'" .
  $_POST["Name"] . "'," .
  (int)$_POST["Kind"] . "," .
  (int)$_POST["Product"] ."," . 
  (float)$_POST["Sum"] . ")";
  $result=$conn->query($sql);
  if($result===TRUE) 
    echo "<font color='green'><b>Zapisat  e  dobaven    uspeshno!</b></font>";
    else  echo "<font color='red'><b>Zapisat  ne  e  dobaven  uspeshno!</b></font>";
}
?>
<form name = "f1" method="post">
  Vid na klienta:
    <input type="radio" name="user" value="1" checked="checked"> platil cqlata suma &nbsp;
    <input type="radio" name="user" value="2">samo 15 %&nbsp;<br>
    <input type="radio" name="user" value="3"> konsignaciq <br>
    <input type="submit" name="submit2" value="Izberete">
	<?php
		    if(isset($_POST['User']))
		       $help = $_POST['User'];
		       else $help="1";
    ?>
   </form>    <p>
  <form name="f2" method="post">
	 Kod: <input type="text" size="6" name="Code"
	            value="<?php
$sql='select Code from User ORDER BY Code DESC';
$result=$conn->query($sql);

$res=$result->fetch_assoc();
echo $res['Code']+1;
?>" />
 <p>Ime: <input type="text" size="32" name="Name">
 <p>Vid: <input type="text" size="5" name="Kind" value =" <?php echo $help;  ?> " >
 <p>Produkt: <input type="text" size="6" name="Product">
<p>Suma: <input type="text" size="33" name="Sum">
  <p>
<input type="submit" name="submit" value="Dobavqne">
</form>
<?php
$conn->close();
?>
Legenda za kod na produkta: 01=>leglo ; 02=> masa ; 03=> stol; <p>
<p> <a href="index16.htm#menu"> Menu =>> </a>
</body>  </html>
