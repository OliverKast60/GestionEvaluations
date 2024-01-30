<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['sid'] == 0)) {
    header('location:logout.php');
} else {

    if (isset($_POST['submit'])) {
        // code...
        $cours = $_POST['cours'];
        $volume_horaire = $_POST['volume_horaire'] * 15;

        $classe = $_POST['classe'];
        $query = mysqli_query($con, "UPDATE `tblcourses` SET `c_intitule`='$cours', `c_volume_horaire`='$volume_horaire', `c_classe`='$classe' WHERE id = '" . $_GET['edit'] . "'");

        if ($query) {
            echo "<script>alert('Le cours a été modifié.');</script>";
            echo "<script>window.location.href = 'courses.php'</script>";
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
            <h4 class="text-primary"><i class="fas fa-edit"></i> Modifier Cours </h4>
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
                                                                $fac = $dbj->query("SELECT tblfaculties.*, tblclasses.*,tblcourses.* FROM tblcourses,tblclasses, tblfaculties WHERE tblcourses.id = $id");

                                                                $fac_p = $fac->fetch();
                                                                ?>

                                                                <form method="post">
                                                                    <div class="modal-body">
                                                                        <label for="exampleFormControlInput1" class="form-label">Nom de la fac</label>
                                                                        <input type="text" class="form-control mb-3" placeholder="Nom de la fac" name="" value="<?php echo $fac_p['f_name']; ?>" readonly>

                                                                        <label for="exampleFormControlInput1" class="form-label">Nom de la classe</label>
                                                                        <input type="text" class="form-control mb-3" placeholder="Nom de la class" name="" value="<?php echo $fac_p['c_name']; ?>" readonly>

                                                                        <label for="exampleFormControlInput1" class="form-label">Nom du Cours</label>
                                                                        <input type="text" class="form-control mb-3" placeholder="Nom du cours" name="cours" value="<?php echo $fac_p['c_intitule']; ?>">

                                                                        <label for="exampleFormControlInput1" class="form-label">Nombre de crédits</label>
                                                                        <input type="text" class="form-control mb-3" placeholder="Nombre de crédits" name="volume_horaire" value="<?php echo $fac_p['c_volume_horaire'] / 15; ?>">

                                                                        <label for="exampleFormControlInput1" class="form-label">Faculté</label>
                                                                        <select class="form-control" name="classe" required>
                                                                            <?php $query = mysqli_query($con, "SELECT * FROM `tblclasses` order by c_name asc");
                                                                            $n = 1;
                                                                            while ($row = mysqli_fetch_array($query)) {
                                                                            ?>
                                                                                <option value="<?php echo $row['id']; ?>"><?php echo $row['c_name'] . " " . $row['c_option']; ?></option>
                                                                            <?php
                                                                                $n++;
                                                                            }
                                                                            ?>
                                                                        </select>

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
