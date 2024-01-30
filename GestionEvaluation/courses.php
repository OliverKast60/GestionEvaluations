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

        $query = mysqli_query($con, "INSERT INTO `tblcourses`(`c_intitule`, `c_volume_horaire`, `c_classe`) values ('$cours','$volume_horaire','$classe')");

        if ($query) {
            echo "<script>alert('Le cours a été ajouté.');</script>";
            echo "<script>window.location.href = 'courses.php'</script>";
            $msg = "";
        } else {
            echo "<script>alert('Une erreur s\'est produite, veillez réessayer.');</script>";
        }
    }
    if (isset($_GET['id'])) {
        // code...
        $query = mysqli_query($con, "delete from `tblcourses` where id ='" . $_GET['id'] . "'");

        if ($query) {
            echo "<script>alert('Le cours a été supprimé.');</script>";
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
        <script type="text/javascript" src="js_libs/ajax.min.js"></script>
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
            <h4 class="text-primary"><i class="fas fa-book-reader"></i> Cours </h4>
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
                                            <div class="card shadow">
                                                <div class="card-header py-3">
                                                    <p class="text-primary m-0 fw-bold" id="dont_print">
                                                        <!-- Button trigger modal -->
                                                        <?php
                                                        $permission = $_SESSION['permission'];
                                                        if ($permission == "Directeur académique" || $permission == "Doyen de la faculté") {
                                                            // code...
                                                        ?>
                                                            <button type="button" class="btn btn-primary btn-sm mb-2" data-bs-toggle="modal" data-bs-target="#staticBackdrop"> <i class="fas fa-plus"></i> Ajouter un cours</button>
                                                        <?php
                                                        }
                                                        ?>

                                                        <button type="button" class="btn btn-dark btn-sm mb-2" onclick="window.print()"> <i class="fas fa-print"></i> Imprimer</button>

                                                    </p>
                                                </div>
                                                <div class="card-body">

                                                    <div class="table-responsive mt-2">

                                                        <input class="form-control" id="myInput" type="text" placeholder="Rechercher un cours.." onkeyup="myFunction()">
                                                        <br>
                                                        <table class="table table-striped nowrap" style="font-weight: normal;font: size 11px;" id="myTable">
                                                            <thead style="font-weight: normal;font: size 11px;">
                                                                <tr>
                                                                    <th class="th-sm" style="font-weight: bold;font: size 10px;">#</th>
                                                                    <th class="th-sm" style="font-weight: bold;font: size 10px;">Intitulé du cours</th>
                                                                    <th class="th-sm" style="font-weight: bold;font: size 10px;">Volume horaire</th>
                                                                    <th class="th-sm" style="font-weight: bold;font: size 10px;">Classe</th>
                                                                    <?php
                                                                    $permission = $_SESSION['permission'];
                                                                    if ($permission == "Directeur académique") {
                                                                        // code...
                                                                    ?>
                                                                        <th class="th-sm" style="font-weight: bold;font: size 10px;" id="dont_print">Action</th>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                $id_user = $_SESSION['sid'];
                                                                $dbj = new PDO('mysql:host=localhost; dbname=geva;charset=utf8', 'root', '');
                                                                $user_spec = $dbj->query("SELECT tblusers.* FROM tblusers WHERE id=$id_user");

                                                                $my_depart = $user_spec->fetch();
                                                                $mystudents = $my_depart['u_faculty'];
                                                                ?>
                                                                <?php
                                                                if ($mystudents == "") {
                                                                    $query = mysqli_query($con, "SELECT tblcourses.*, tblcourses.id as a, tblclasses.*, tblfaculties.* FROM `tblcourses`, tblclasses,tblfaculties WHERE tblcourses.c_classe=tblclasses.id and tblclasses.c_faculty=tblfaculties.id order by c_intitule asc");
                                                                } else {
                                                                    $query = mysqli_query($con, "SELECT tblcourses.*, tblcourses.id as a, tblclasses.*, tblfaculties.* FROM `tblcourses`, tblclasses,tblfaculties WHERE tblcourses.c_classe=tblclasses.id and tblclasses.c_faculty=tblfaculties.id and tblfaculties.f_name like '$mystudents' order by c_intitule asc");
                                                                }
                                                                $n = 1;
                                                                while ($row = mysqli_fetch_array($query)) {
                                                                ?>

                                                                    <tr>
                                                                        <td><?php echo $n; ?></td>
                                                                        <td><?php echo ($row['c_intitule']); ?></td>
                                                                        <td><?php echo ($row['c_volume_horaire']) . " hrs"; ?></td>
                                                                        <td><?php echo ($row['c_name'] . " " . $row['c_option']); ?></td>
                                                                        <?php
                                                                        $permission = $_SESSION['permission'];
                                                                        if ($permission == "Directeur académique") {
                                                                            // code...
                                                                        ?>
                                                                            <td id="dont_print">
                                                                                <a href="edit_course.php?edit=<?php echo $row['a']; ?>" title="Modifier"><button class="btn btn-success btn-sm" style="font-size:11px;"><i class="fas fa-edit"></i> Modifier</button></a>
                                                                                <a href="courses.php?id=<?php echo $row['a']; ?>" title="Supprimer" style="font-size:11px;"><button class="btn btn-danger btn-sm" style="font-size:11px;"><i class="fas fa-trash"></i> Supprimer</button></a>
                                                                            </td>
                                                                        <?php
                                                                        }
                                                                        ?>
                                                                    </tr>
                                                                <?php
                                                                    $n++;
                                                                }
                                                                ?>

                                                            </tbody>
                                                        </table>

                                                        <!-- Modal -->
                                                        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                            <div class="modal-dialog" style="background-color:whitesmoke;">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h1 class="modal-title fs-5" id="staticBackdropLabel"><i class="fas fa-plus"></i> Nouveau cours</h1>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <form method="post" enctype="multipart/form-data">
                                                                        <div class="modal-body">

                                                                            <label for="exampleFormControlInput1" class="form-label">Nom du cours</label>
                                                                            <input type="text" class="form-control mb-3" placeholder="Nom du cours" name="cours" required>

                                                                            <label for="exampleFormControlInput1" class="form-label">Nombre de credits</label>
                                                                            <input type="number" class="form-control mb-3" placeholder="Nombre de credits" name="volume_horaire" required>

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
