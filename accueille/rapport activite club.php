<?
$cc=$_POST['T13'];
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
$kk=$_POST['T11'];
$kkk=$_POST['T12'];

mysql_connect("localhost","root","");
mysql_select_db("issat");
 
$s="select * from rapport_activite_club where (cin='$cc')";

$r=mysql_query($s);
$w=mysql_num_rows($r);


if ($w!=0)
{echo ('vous avez déja fait une demande');}
else
{
 $s="insert into rapport_activite_club values('$cc','$a','$b','$c','$d','$e','$f','$g','$h','$i','$j','$k','$kk','$kkk')";
$r=mysql_query($s);
    echo('votre demande a été envoyer');


}
?>