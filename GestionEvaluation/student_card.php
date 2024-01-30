<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['sid'] == 0)) {
    header('location:logout.php');
} else {
?>

    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="utf-8">
        <title></title>
        <?php
        include('includes/head.php');
        ?>
    </head>

    <body id="body-pd">
        <header class="header" id="header">
            <?php
            include('sidebar_menu/header.php');
            ?>
        </header>
        <div class="l-navbar bg-dark mb-5" id="nav-bar">
            <?php
            include('sidebar_menu/sidebar.php');
            ?>
        </div>

        <div class="height-100" style="margin-left:20px;margin-top: 90px;">
            <h4 class="text-primary" id="dont_print"><i class="fas fa-id-card-alt"></i> Carte d'étudiant </h4>

            <hr id="dont_print">
            <button class="btn btn-dark mt-3" onclick="window.print()" id="dont_print">Imprimer</button>
            <div class="row">
                <div class="col-md-12">
                    <div class="row">

                        <?php

                        $dbj = new PDO('mysql:host=localhost; dbname=geva;charset=utf8', 'root', '');
                        $id_student = $_GET['id'];
                        $student_choosen = $dbj->query("SELECT tblstudents.*, tblclasses.* FROM tblstudents, tblclasses WHERE tblstudents.id=$id_student and tblclasses.id=tblstudents.s_classe");

                        $student = $student_choosen->fetch();
                        ?>

                        <div class="col-md-3" id="dont_print">

                        </div>

                        <div class="col-md-6">
                            <div class="row" style="padding:10px;">
                                <div class="col-md-12" style="height:auto;border-radius: 10px;box-shadow: 0 0 8px black;padding: 30px;background-image: url('background_card/background_card.png'); background-size: cover;background-repeat: no-repeat;">

                                    <div class="row" style="border:solid black 1px;border-radius: 10px;padding: 20px;">
                                        <h6 class="text-center"><img src="../logo/logo-biu.png" width="10%"> UNIVERSITE LIBRE DES PAYS DES GRANDS LACS</h6>
                                        <hr>
                                        <div class="col-3 mt-2">
                                            <img src="students_profil/<?php echo $student['s_userimage']; ?>" style="border-radius: 50%;width: 100px;height: 100px;">
                                        </div>
                                        <div class="col-7">
                                            <table>
                                                <thead style="font-size:12px;">
                                                    <tr>
                                                        <th>Nom : </th>
                                                        <th class="text-uppercase" id=""><?php echo $student['s_name']; ?></th>
                                                    </tr>

                                                    <tr>
                                                        <th>Matricule : </th>
                                                        <th class="text-uppercase"><?php echo $student['s_matricule']; ?></th>
                                                    </tr>

                                                    <tr>
                                                        <th>Date de naissance : </th>
                                                        <th class="text-uppercase"><?php echo $student['s_date_naissance']; ?></th>
                                                    </tr>

                                                    <tr>
                                                        <th>Domicile : </th>
                                                        <th class="text-uppercase"><?php echo $student['s_address']; ?></th>
                                                    </tr>

                                                    <tr>
                                                        <th>Faculté et option : </th>
                                                        <th class="text-uppercase"><?php echo $student['c_name'] . " / " . $student['c_option']; ?></th>
                                                    </tr>

                                                    <tr>
                                                        <th>Validité : </th>
                                                        <th class="text-uppercase"><?php echo $student['saved_year'] . " - " . $student['saved_year'] + 4; ?></th>
                                                    </tr>

                                                </thead>

                                            </table>
                                        </div>
                                        <div class="col-2 mt-4">
                                            <img src="background_card/png-transparent-qr-code-business-cards-barcode-coupon-test-box-angle-text-rectangle.png" style="width:100%;">
                                        </div>

                                        <hr>
                                    </div>

                                    <div class="row" id="dont_print">
                                        <div class="col-md-6"></div>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>

        <script type="text/javascript" src="dash.js"></script>

    </html>
<?php
}
?>
