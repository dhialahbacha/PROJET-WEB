<?

$a=$_POST['T1'];
$b=$_POST['T2'];
$c=$_POST['T3'];
$d=$_POST['T4'];
$e=$_POST['T5'];

mysql_connect("localhost","root","");
mysql_select_db("issat");
 
$s="select * from sign where (cin='$b')";

$r=mysql_query($s);
$w=mysql_num_rows($r);


if ($w!=0)
{echo ('Vous etes déja inscrit');}
else
{?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="acceuil.css">
    <style>
        .btn{
  background-color: #5995fd;
  border: none;
  outline: none;
  height: 49px;
  border-radius: 49px;
  color: #fff;
  text-transform: uppercase;
  font-weight: 600;
  margin: 10px 0;
padding: 5px;}
  .btn:hover {
  background-color: #4d84e2;
 
}


    </style>
</head>
<body>
    <!--barre1 en bleu-->
    <div class="barre">
        <div class="leftdiv"></div> 
        <div class="centerdiv"><a href="acceuil.html"> acceuil</a></div>
        <div class="rightdiv"><a href="index.html"><img class="image2" src="yess.png" alt="profil"></a></div>
        
    </div>
    <!--barre 2 en blanc-->
    <div id="barre2">
        <div class="logo"><a href="acceuil.html"><img id="img0" src="issatsoo.png"></a></div>
        <div class="wrap">
            <div class="search">
                <input type="text" class="searchTerm" placeholder="Que cherchez-vous?">
                <button type="submit" class="searchButton" >
                    <i class="fa fa-search"></i>
                </button>
            </div>
        </div>
    </div>
<!--cleaaaaaaaaaaaaaaaaaar-->
<div class="clear"></div>
    <!--left menu div-->
   
<div id="btn">
<div id='top'></div>
<div id='middle'></div>
<div id='bottom'></div>
</div>
<div id="box">
<div id="items">
<div class="item"><a href="formclubassociation.html">Formulaires - Clubs et Associations</a></div>
<div class="item"><a href="formguichetscol.html">Formulaires - Guichet Scolarité</a></div>
<div class="item"><a href="#">Fiche de Renseignements Etudiant</a></div>
</div>
</div>
<div  class="left">
    <h3>ISITCOM VOUS SOUHAITE LA BIENVENUE</h3>
    <br>
    <h4>Prenons l'initiative ensemble, améliorons notre ISITCOM</h4>
</div>
  <div  class="right">
  <a class='btn'href="../../Affiche Note/AfficheNote1.html">Afficher la note</a>

  </div>
 <div class="colums">
     <div class="colum"><img src="drag.png" alt="formulaire"><a href="test.html">fiche de renseignement</a></div>
     <div class="colum"><img src="drag.png" alt="formulaire"><a href="#">attestation de presence</a></div>
     <div class="colum"><img src="drag.png" alt="formulaire"><a href="#">Demande de Création ou Renouvellement Club</a></div>
     <div class="colum"><img src="drag.png" alt="formulaire"><a href="Demande de Reservation Activite Association.html">Demande de Réservation Activité Association</a></div>
     <div class="colum"><img src="drag.png" alt="formulaire"><a href="#">Demande de Réservation Activité Club</a></div>
     <div class="colum"><img src="drag.png" alt="formulaire"><a href="#">Demande de Réservation du Bus</a></div>
     <div class="colum"><img src="drag.png" alt="formulaire"><a href="#">Rapport Activité Association</a></div>
     <div class="colum"><img src="drag.png" alt="formulaire"><a href="Rapport Activie Club.html">Rapport Activité Club</a></div>
     <div class="colum"><img src="drag.png" alt="formulaire"><a href="#">مطلب استخراج شھادة نجاح</a></div>
     <div class="colum"><img src="drag.png" alt="formulaire"><a href="#">مطلب تسجيل استثنائي</a></div>
     <div class="colum"><img src="drag.png" alt="formulaire"><a href="#">مطلب للحصول علي نظير من وثيقة ادارية</a></div>
     <div class="colum"><img src="drag.png" alt="formulaire"><a href="#">مطلب للحصول علي شهادة مغادرة + الملف الطبي</a></div>
     <div class="colum"><img src="drag.png" alt="formulaire"><a href="#">مطلب للحصول علي شهادة حضور</a></div>
     <div class="colum"><img src="drag.png" alt="formulaire"><a href="#">ألتزام</a></div>

 </div>






    <script src="acceuil.js"></script>
</body>
</html>
<?


$s="insert into sign values('$a','$b','$c','$d','$e')";
$r=mysql_query($s);

$s="insert into log values('$b','$d')";
$r=mysql_query($s);
}
?>



