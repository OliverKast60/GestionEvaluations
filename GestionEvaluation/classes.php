<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['sid'] == 0)) {
    header('location:logout.php');
} else {

    if (isset($_POST['submit'])) {
        // code...

        $nom_faculte = $_POST['faculte'];
        $option = $_POST['option'];
        $classe = $_POST['classe'];

        $query = mysqli_query($con, "INSERT INTO `tblclasses`(`c_name`, `c_faculty`, `c_option`) values ('$classe','$nom_faculte','$option')");

        if ($query) {
            echo "<script>alert('La classe a été ajoutée.');</script>";
            echo "<script>window.location.href = 'classes.php'</script>";
            $msg = "";
        } else {
            echo "<script>alert('Une erreur s\'est produite, veillez réessayer.');</script>";
        }
    }
    if (isset($_GET['id'])) {
        // code...
        $query = mysqli_query($con, "delete from `tblclasses` where id ='" . $_GET['id'] . "'");

        if ($query) {
            echo "<script>alert('La classe a été supprimée.');</script>";
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
            <h4 class="text-primary"><i class="far fa-window-restore"></i> Classes </h4>
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
                                                            <button type="button" class="btn btn-primary btn-sm mb-2" data-bs-toggle="modal" data-bs-target="#staticBackdrop"> <i class="fas fa-plus"></i> Ajouter une classe</button>
                                                        <?php
                                                        }
                                                        ?>
                                                        <button type="button" class="btn btn-dark btn-sm mb-2" onclick="window.print()"> <i class="fas fa-print"></i> Imprimer</button>


                                                    </p>
                                                </div>
                                                <div class="card-body">

                                                    <div class="table-responsive mt-2">

                                                        <input class="form-control" id="myInput" type="text" placeholder="Rechercher une classe.." onkeyup="myFunction()">
                                                        <br>
                                                        <table class="table table-striped nowrap" style="font-weight: normal;font: size 11px;" id="myTable">
                                                            <thead style="font-weight: normal;font: size 11px;">
                                                                <tr>
                                                                    <th class="th-sm" style="font-weight: bold;font: size 10px;">#</th>
                                                                    <th class="th-sm" style="font-weight: bold;font: size 10px;">Classe</th>
                                                                    <th class="th-sm" style="font-weight: bold;font: size 10px;">Option</th>
                                                                    <th class="th-sm" style="font-weight: bold;font: size 10px;">Faculté</th>
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
                                                                <?php $query = mysqli_query($con, "SELECT tblfaculties.*,tblclasses.id as a, tblclasses.* FROM `tblfaculties`, tblclasses where tblclasses.c_faculty = tblfaculties.id order by tblclasses.c_name asc");
                                                                $n = 1;
                                                                while ($row = mysqli_fetch_array($query)) {
                                                                ?>

                                                                    <tr>
                                                                        <td><?php echo $n; ?></td>
                                                                        <td><?php echo ($row['c_name']); ?></td>
                                                                        <td><?php echo ($row['c_option']); ?></td>
                                                                        <td><?php echo ($row['f_name']); ?></td>
                                                                        <?php
                                                                        $permission = $_SESSION['permission'];
                                                                        if ($permission == "Directeur académique") {
                                                                            // code...
                                                                        ?>
                                                                            <td id="dont_print">
                                                                                <a href="edit_class.php?edit=<?php echo $row['a']; ?>" title="Modifier"><button class="btn btn-success btn-sm" style="font-size:11px;"><i class="fas fa-edit"></i> Modifier</button></a>
                                                                                <a href="classes.php?id=<?php echo $row['a']; ?>" title="Supprimer" style="font-size:11px;"><button class="btn btn-danger btn-sm" style="font-size:11px;"><i class="fas fa-trash"></i> Supprimer</button></a>
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
                                                                        <h1 class="modal-title fs-5" id="staticBackdropLabel"><i class="fas fa-plus"></i> Nouvelle classe</h1>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <form method="post" enctype="multipart/form-data">
                                                                        <div class="modal-body">

                                                                            <label for="exampleFormControlInput1" class="form-label">Nom de la classe</label>
                                                                            <input type="text" class="form-control mb-3" placeholder="Nom de la classe" name="classe" required>

                                                                            <label for="exampleFormControlInput1" class="form-label">Nom de l'option</label>
                                                                            <input type="text" class="form-control mb-3" placeholder="Nom de l'option" name="option" required>

                                                                            <label for="exampleFormControlInput1" class="form-label">Faculté</label>
                                                                            <select class="form-control" name="faculte" required>
                                                                                <?php $query = mysqli_query($con, "SELECT * FROM `tblfaculties`");
                                                                                $n = 1;
                                                                                while ($row = mysqli_fetch_array($query)) {
                                                                                ?>
                                                                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['f_name']; ?></option>
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
