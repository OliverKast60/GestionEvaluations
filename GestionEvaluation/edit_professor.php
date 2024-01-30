<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['sid'] == 0)) {
    header('location:logout.php');
} else {

    if (isset($_POST['submit'])) {
        // code...

        $nom = $_POST['nom'];
        $address = $_POST['address'];
        $contact = $_POST['contact'];
        $cours = $_POST['cours'];

        function getRandomStr($n)
        {
            $str = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $randomStr = '';

            for ($i = 0; $i < $n; $i++) {
                $index = rand(0, strlen($str) - 1);
                $randomStr .= $str[$index];
            }

            return $randomStr;
        }

        $b = 4;
        $a = getRandomStr($b);

        $id_number = substr($nom, 0, 3) . $a . rand(100, 1000) . date('Y');

        $userimage = $_FILES["userimage"]["name"];
        move_uploaded_file($_FILES["userimage"]["tmp_name"], "profil_images/" . $_FILES["userimage"]["name"]);

        $query = mysqli_query($con, "UPDATE `tblprofesseurs` SET `p_name`='$nom',`p_image`='$userimage',`p_contact`='$contact',`p_address`='$address',`p_matricule`='$id_number',`p_course`='$cours' WHERE id = '" . $_GET['edit'] . "'");

        if ($query) {
            echo "<script>alert('Les informations sur le professeur ont été modifiées.');</script>";
            echo "<script>window.location.href = 'professors.php'</script>";
            $msg = "";
        } else {
            echo "<script>alert('Une erreur s\'est produite, veillez réessayer.');</script>";
        }
    }
?>

    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="utf-8">
        <title></title>
        <?php
        include('includes/head.php');
        ?>

        <script>
            function myFunction() {
                var input, filter, table, tr, td, i, txtValue;
                input = document.getElementById("myInput");
                filter = input.value.toUpperCase();
                table = document.getElementById("myTable");
                tr = table.getElementsByTagName("tr");
                for (i = 0; i < tr.length; i++) {
                    td = tr[i].getElementsByTagName("td")[0];
                    if (td) {
                        txtValue = td.textContent || td.innerText;
                        if (txtValue.toUpperCase().indexOf(filter) > -1) {
                            tr[i].style.display = "";
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                }
            }
        </script>
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
            <h4 class="text-primary"><i class="fas fa-cogs"></i> Modifier Professeur</h4>
            <hr>
            <div class="row">
                <div class="col-md-12">
                    <div class="row">


                        <div class="col-md-12">
                            <div id="wrapper">
                                <div class="d-flex flex-column" id="content-wrapper">
                                    <div id="content">
                                        <?php include('includes/nav_menu.php'); ?>
                                        <div class="container-fluid">
                                            <div class="card shadow mt-5 mb-5">
                                                <div class="card-header py-3">
                                                    <p class="text-primary m-0 fw-bold" id="dont_print">
                                                        <!-- Button trigger modal -->
                                                    </p>
                                                </div>
                                                <div class="card-body">

                                                    <div class="mt-4">
                                                        <?php

                                                        $dbj = new PDO('mysql:host=localhost; dbname=geva;charset=utf8', 'root', '');
                                                        $id = $_GET['edit'];
                                                        $user_spec = $dbj->query("SELECT tblprofesseurs.*,tblcourses.* FROM tblprofesseurs, tblcourses WHERE tblprofesseurs.id=$id");

                                                        $my_profile = $user_spec->fetch();
                                                        ?>
                                                        <form method="post" enctype="multipart/form-data">
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <div class="row">
                                                                        <div class="col-md-12 text-center mb-4">
                                                                            <img src="profil_images/<?php echo $my_profile['p_image']; ?>" style="width: 200px;height: 200px;border-radius: 50%;">
                                                                        </div>
                                                                    </div>
                                                                </div>


                                                                <div class="col-md-4">
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <label for="exampleFormControlInput1" class="form-label mt-2">Photo de profil</label>
                                                                            <input type="file" name="userimage" class="file-upload-default form-control" value="<?php echo $my_profile['userimage']; ?>" required>

                                                                            <label for="exampleFormControlInput1" class="form-label mt-2">Nom complet du professeur</label>
                                                                            <input type="text" name="nom" class="form-control" value="<?php echo $my_profile['p_name']; ?>">

                                                                            <label for="exampleFormControlInput1" class="form-label mt-2">Adresse de résidence</label>
                                                                            <input type="text" name="address" class="form-control" value="<?php echo $my_profile['p_address']; ?>">

                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-4">
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <label for="exampleFormControlInput1" class="form-label mt-2">Contact (email)</label>
                                                                            <input type="text" name="contact" class="form-control" value="<?php echo $my_profile['p_contact']; ?>">

                                                                            <label for="exampleFormControlInput1" class="form-label mt-2">Cours dispensé</label>
                                                                            <input type="text" name="cours" class="form-control" value="<?php echo $my_profile['c_intitule']; ?>">

                                                                        </div>

                                                                    </div>

                                                                </div>

                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-11"></div>
                                                                <div class="col-md-1 text-right">
                                                                    <button class="btn btn-primary mt-4 btn-block" type="submit" name="submit">Modifier</button>

                                                                </div>
                                                            </div>
                                                        </form>

                                                        <!-- Modal -->
                                                        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                            <div class="modal-dialog" style="background-color:whitesmoke;">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h1 class="modal-title fs-5" id="staticBackdropLabel"><i class="fas fa-plus"></i> Nouvelle faculté</h1>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <form method="post" enctype="multipart/form-data">
                                                                        <div class="modal-body">

                                                                            <label for="exampleFormControlInput1" class="form-label">Nom de la faculté</label>
                                                                            <input type="text" class="form-control mb-3" placeholder="Nom de la faculté" name="faculte" required>

                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                                                            <button type="submit" class="btn btn-primary" name="submit">Enregistrer</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php include('includes/foot.php'); ?>
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
