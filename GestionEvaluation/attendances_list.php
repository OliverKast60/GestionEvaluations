<?php
session_start();
error_reporting(0);

include('includes/dbconnection.php');

if (strlen($_SESSION['sid'] == 0)) {
    header('location:logout.php');
} else {
    if (isset($_POST['confirmer'])) {
        $student = $_POST['student'];
        $evaluation = $_POST['evaluation'];
        $status = 1;

        $query_insert = mysqli_query($con, "INSERT INTO `tblattendances`(`a_student`, `a_eval`, `a_status`) VALUES ('$student','$evaluation','$status')");
        if ($query_insert) {
            echo '<script>alert("La présence a été enregistrée")</script>';
            echo "<script>window.location.href ='attendances_list.php'</script>";
            $msg = "";
        } else {
            echo "<script>alert('Une erreur s\'est produite, veillez réessayer.');</script>";
        }
    }

    if (isset($_GET['id'])) {
        // code...
        $query = mysqli_query($con, "delete from `tblstudents` where id ='" . $_GET['id'] . "'");

        if ($query) {
            echo "<script>alert('L\'étudiant a été supprimé.');</script>";
            echo "<script>window.location.href = 'students.php'</script>";
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
        <title>Evaluation</title>
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
            <h4 class="text-primary"><i class="fas fa-th-list"></i> Liste des présences </h4>
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

                                                        <a href="attendances_list.php"><button type="button" class="btn btn-primary btn-sm mb-2"> <i class="fas fa-th-list"></i> Listes des présences</button></a>

                                                        <a href="excel/attendances_list.php"><button type="button" class="btn btn-success btn-sm mb-2"> <i class="fas fa-file-excel"></i> Exporter en excel</button></a>

                                                        <button type="button" class="btn btn-dark btn-sm mb-2" onclick="window.print()"> <i class="fas fa-print"></i> Imprimer</button>



                                                    </p>
                                                </div>
                                                <div class="card-body">

                                                    <div class="table-responsive mt-2">

                                                        <input class="form-control" id="myInput" type="text" placeholder="Rechercher un étudiant.." onkeyup="myFunction()">
                                                        <br>
                                                        <table class="table table-striped nowrap" style="font-weight: normal;font: size 11px;" id="myTable">
                                                            <thead style="font-weight: normal;font: size 11px;">
                                                                <tr>
                                                                    <th class="th-sm" style="font-weight: bold;font: size 10px;">#</th>
                                                                    <th class="th-sm" style="font-weight: bold;font: size 10px;">Nom de l'étudiant</th>
                                                                    <th class="th-sm" style="font-weight: bold;font: size 10px;">Matricule</th>
                                                                    <th class="th-sm" style="font-weight: bold;font: size 10px;">Classe</th>
                                                                    <th class="th-sm" style="font-weight: bold;font: size 10px;">Evaluation</th>
                                                                    <th class="th-sm" style="font-weight: bold;font: size 10px;">Date de l'evaluation</th>


                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                $id_user = $_SESSION['sid'];
                                                                $dbj = new PDO('mysql:host=localhost; dbname=geva;charset=utf8', 'root', '');
                                                                $user_spec = $dbj->query("SELECT tblusers.* FROM tblusers WHERE id=$id_user");

                                                                $my_depart = $user_spec->fetch();
                                                                $mystudents = $my_depart['u_faculty'];
                                                                //echo $mystudents;
                                                                ?>
                                                                <?php
                                                                if ($mystudents == "") {
                                                                    $query = mysqli_query($con, "SELECT tblattendances.*, tblstudents.*, tblcourses.*,tblfaculties.*, tblstudents.s_name as a, tblevaluations.*, tblclasses.* FROM tblattendances, tblclasses, tblstudents,tblevaluations, tblcourses,tblfaculties WHERE tblattendances.a_student=tblstudents.id and tblclasses.id = tblstudents.s_classe and tblevaluations.id=tblattendances.a_eval  and tblevaluations.e_course=tblcourses.id and tblclasses.c_faculty=tblfaculties.id");
                                                                } else {
                                                                    $query = mysqli_query($con, "SELECT tblattendances.*, tblstudents.*, tblcourses.*,tblfaculties.*, tblstudents.s_name as a, tblevaluations.*, tblclasses.* FROM tblattendances, tblclasses, tblstudents,tblevaluations, tblcourses,tblfaculties WHERE tblattendances.a_student=tblstudents.id and tblclasses.id = tblstudents.s_classe and tblevaluations.id=tblattendances.a_eval  and tblevaluations.e_course=tblcourses.id and tblclasses.c_faculty=tblfaculties.id and tblfaculties.f_name like '$mystudents'");
                                                                }
                                                                $n = 1;
                                                                while ($row = mysqli_fetch_array($query)) {
                                                                ?>

                                                                    <tr>
                                                                        <td><?php echo $n; ?></td>

                                                                        <td><?php echo ($row['a']); ?></td>
                                                                        <td><?php echo ($row['s_matricule']); ?></td>
                                                                        <td><?php echo ($row['c_name'] . " " . $row['c_option']); ?></td>
                                                                        <td><?php echo ($row['c_intitule']); ?></td>
                                                                        <td><?php echo ($row['date_eval']); ?></td>
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
                                                                        <h1 class="modal-title fs-5" id="staticBackdropLabel"><i class="fas fa-edit"></i> Editer une présence</h1>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <form method="post" enctype="multipart/form-data">
                                                                        <div class="modal-body">

                                                                            <label for="exampleFormControlInput1" class="form-label mt-2">Selectionner un étudiant</label>
                                                                            <select class="form-control" name="sex" required>
                                                                                <option value="Masculin" selected>Masculin</option>
                                                                                <option value="Féminin">Féminin</option>
                                                                            </select>

                                                                            <label for="exampleFormControlInput1" class="form-label mt-2">Evaluation</label>
                                                                            <select class="form-control" name="etat_civil" required>
                                                                                <option value="Marié">Marié</option>
                                                                                <option value="Célibataire" selected="">Célibataire</option>
                                                                            </select>

                                                                            <label for="exampleFormControlInput1" class="form-label mt-2">Adresse de résidence</label>
                                                                            <input type="text" class="form-control mb-3" placeholder="Adresse de résidence" name="address" required>

                                                                            <label for="exampleFormControlInput1" class="form-label mt-2">Contact (email)</label>
                                                                            <input type="mail" class="form-control mb-3" placeholder="Email" name="contact" required>

                                                                            <label for="exampleFormControlInput1" class="form-label mt-2">Classe</label>
                                                                            <select class="form-control" name="classe" required>
                                                                                <?php $query = mysqli_query($con, "SELECT tblclasses.*, tblclasses.id as k, tblfaculties.* FROM `tblclasses`, tblfaculties where tblfaculties.id = tblclasses.c_faculty");
                                                                                $n = 1;
                                                                                while ($row = mysqli_fetch_array($query)) {
                                                                                ?>
                                                                                    <option value="<?php echo $row['k']; ?>"><?php echo $row['c_name'] . " " . $row['c_option'] . " " . $row['f_name']; ?></option>
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
