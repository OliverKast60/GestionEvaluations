<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['sid'] == 0)) {
    header('location:logout.php');
} else {

    $id_user = $_SESSION['sid'];
    if (isset($_POST['submit'])) {
        // code...

        $username = $_POST['username'];
        $password = md5($_POST['password']);
        $name = $_POST['name'];
        $lastname = $_POST['lastname'];
        $userimage = $_FILES["userimage"]["name"];
        move_uploaded_file($_FILES["userimage"]["tmp_name"], "profil_images/" . $_FILES["userimage"]["name"]);

        $query = mysqli_query($con, "UPDATE `tblusers` SET `username`='$username',`password`='$password',`name`='$name',`lastname`='$lastname',`userimage`='$userimage' WHERE id = $id_user");

        if ($query) {
            echo "<script>alert('Les informations de votre compte ont été modifiées.');</script>";
            echo "<script>window.location.href = 'settings.php'</script>";
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

        <script src="js_libs/ajax.min.js"></script>

        <script>
            $(document).ready(function() {
                $("#myInput").on("keyup", function() {
                    var value = $(this).val().toLowerCase();
                    $("#myTable tr").filter(function() {
                        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                    });
                });
            });
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
            <h4 class="text-primary"><i class="fas fa-cogs"></i> Paramètres </h4>
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
                                                        $user_spec = $dbj->query("SELECT tblusers.* FROM tblusers WHERE id=$id_user");

                                                        $my_profile = $user_spec->fetch();
                                                        ?>
                                                        <form method="post" enctype="multipart/form-data">
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <div class="row">
                                                                        <div class="col-md-12 text-center mb-4">
                                                                            <img src="profil_images/<?php echo $my_profile['userimage']; ?>" style="width: 200px;height: 200px;border-radius: 50%;">
                                                                        </div>
                                                                    </div>
                                                                </div>


                                                                <div class="col-md-4">
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <label for="exampleFormControlInput1" class="form-label mt-2">Photo de profil</label>
                                                                            <input type="file" name="userimage" class="file-upload-default form-control" value="<?php echo $my_profile['userimage']; ?>" required>

                                                                            <label for="exampleFormControlInput1" class="form-label mt-2">Nom Utilisateur</label>
                                                                            <input type="text" name="username" class="form-control" value="<?php echo $my_profile['username']; ?>">

                                                                            <label for="exampleFormControlInput1" class="form-label mt-2">Mot de passe</label>
                                                                            <input type="password" name="password" class="form-control" value="<?php echo $my_profile['password']; ?>">

                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-4">
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <label for="exampleFormControlInput1" class="form-label mt-2">Prénom</label>
                                                                            <input type="text" name="name" class="form-control" value="<?php echo $my_profile['name']; ?>">

                                                                            <label for="exampleFormControlInput1" class="form-label mt-2">Nom</label>
                                                                            <input type="text" name="lastname" class="form-control" value="<?php echo $my_profile['lastname']; ?>">

                                                                            <label for="exampleFormControlInput1" class="form-label mt-2">Fonction</label>
                                                                            <input type="text" name="" class="form-control" value="<?php echo $my_profile['permission']; ?>" readonly>





                                                                        </div>

                                                                    </div>

                                                                </div>

                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-11"></div>
                                                                <div class="col-md-1 text-right">
                                                                    <button class="btn btn-primary mt-4 btn-block" type="submit" name="submit">Enregistrer</button>

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
