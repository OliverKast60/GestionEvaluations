<div class="header_toggle" id="dont_print">
    <i class='bx bx-menu' id="header-toggle"></i>
</div>

<span style="position: relative;left: 30%;font-size: 12px;" id="dont_print"><?php echo $_SESSION['name'] . " " . $_SESSION['lastname']; ?></span>

<?php

$dbj = new PDO('mysql:host=localhost; dbname=geva;charset=utf8', 'root', '');
$nm = $_SESSION['name'];
$lstnm = $_SESSION['lastname'];
$user_profil = $dbj->query("SELECT * FROM tblusers WHERE name like '$nm' and lastname like '$lstnm'");

$user_p = $user_profil->fetch();
?>
<a href="settings.php" style="margin-left: 25%;" id="dont_print"><i class="fas fa-cogs"></i> Paramètres</a>
<a href="logout.php" style="margin-left: 25%;" id="dont_print" title="Déconnexion"> <i class="fas fa-sign-out-alt"></i>Déconnexion</a>
<div class="header_img" id="dont_print">
    <img src="profil_images/<?php echo $user_p['userimage']; ?>" alt="">
</div>


<link rel="stylesheet" type="text/css" href="bootst/dash.css">
<link rel="stylesheet" type="text/css" href="bootst/bootstrap.min.css">
<script type="text/javascript" src="bootst/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="js/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="bootst/boxicons.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
<script src="js/Chart.min.js"></script>
<style media="print" type="text/css">
    #dont_print,
    #myInput,
    .scroll-to-top {
        display: none;
    }

    #imprime_moi {
        box-shadow: 0 0 0px black;
        border: 0;
    }
</style>
