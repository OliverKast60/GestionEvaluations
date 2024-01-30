<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['sid'] == 0)) {
    header('location:logout.php');
} else {

    if (isset($_POST['submit'])) {
        // code...
        $classe = $_POST['classe'];
        $option = $_POST['option'];
        $query = mysqli_query($con, "UPDATE `tblclasses` SET `c_name`='$classe', `c_option`='$option' WHERE id = '" . $_GET['edit'] . "'");

        if ($query) {
            echo "<script>alert('La classe a été modifiée.');</script>";
            echo "<script>window.location.href = 'classes.php'</script>";
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
            <h4 class="text-primary"><i class="fas fa-edit"></i> Modifier classe </h4>
            <hr>
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-1"></div>

                        <div class="col-md-10">
                            <div id="wrapper">
                                <div class="d-flex flex-column" id="content-wrapper">
                                    <div id="content">
                                        <?php include('includes/nav_menu.php'); ?>
                                        <div class="container-fluid">
                                            <div class="card shadow">

                                                <div class="card-body">

                                                    <div class=" mt-2">

                                                        <br>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <?php

                                                                $dbj = new PDO('mysql:host=localhost; dbname=geva;charset=utf8', 'root', '');
                                                                $id = $_GET['edit'];
                                                                $fac = $dbj->query("SELECT tblfaculties.*, tblclasses.* FROM tblclasses, tblfaculties WHERE tblclasses.id = $id");

                                                                $fac_p = $fac->fetch();
                                                                ?>

                                                                <form method="post">
                                                                    <div class="modal-body">

                                                                        <label for="exampleFormControlInput1" class="form-label">Nom de la faculté</label>
                                                                        <input type="text" class="form-control mb-3" placeholder="Nom de la faculté" name="faculte" value="<?php echo $fac_p['f_name']; ?>" readonly>

                                                                        <label for="exampleFormControlInput1" class="form-label">Nom de l'option</label>
                                                                        <input type="text" class="form-control mb-3" placeholder="Nom de l'option" name="option" value="<?php echo $fac_p['c_option']; ?>">

                                                                        <label for="exampleFormControlInput1" class="form-label">Nom de la faculté</label>
                                                                        <input type="text" class="form-control mb-3" placeholder="Nom de la classe" name="classe" value="<?php echo $fac_p['c_name']; ?>">

                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="submit" class="btn btn-primary btn-sm" name="submit">Enregistrer</button>
                                                                    </div>
                                                                </form>
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
