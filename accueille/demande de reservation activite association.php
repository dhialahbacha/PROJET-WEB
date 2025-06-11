<?
$cin=$_POST['T11'];
$a=$_POST['T1'];
$b=$_POST['T2'];
$c=$_POST['D1'];
$d=$_POST['T3'];
$e=$_POST['T4'];
$f=$_POST['T5'];
$g=$_POST['T6'];
$h=$_POST['T7'];
$i=$_POST['T8'];
$j=$_POST['T9'];
$k=$_POST['T10'];
mysql_connect("localhost","root","");
mysql_select_db("issat") or die('1');
 
$s="select * from demande_de_reservation_activite_association where (cin='$cin')" or die('2');

$r=mysql_query($s)or die('3');
$w=mysql_num_rows($r);


if ($w!=0)
{echo ('vous avez déja fait une demande');}
else
{
 $s="insert into demande_de_reservation_activite_association values('$cin','$a','$b','$c','$d','$e','$f','$g','$h','$i','$j','$k',' ',' ')"or die('7');
$r=mysql_query($s)or die('8');
    echo('votre demande a été envoyer');


}
?>