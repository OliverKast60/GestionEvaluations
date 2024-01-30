<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['sid'] == 0)) {
    header('location:logout.php');
} else {

    if (isset($_POST['submit'])) {
        $cours = $_POST['cours'];
        $evaluation = $_POST['evaluation'];
        $date_evaluation = $_POST['date_evaluation'];
        $salle = $_POST['salle'];
        $session = $_POST['session'];
        $evaluation = $_POST['evaluation'];

        $date_actuelle = date('Y-m-d');
        if ($date_evaluation <= $date_actuelle) {
            # code...
            echo '<script>alert("Veillez choisir une date pour votre evaluation plus recente à la date actuelle!")</script>';
            echo "<script>window.location.href ='exams.php'</script>";
        } else {
            $query_insert = mysqli_query($con, "INSERT INTO `tblevaluations`(`e_type`, `e_session`, `e_salle`, `e_course`,`date_eval`) VALUES ('$evaluation','$session','$salle','$cours','$date_evaluation')");
            if ($query_insert) {
                echo '<script>alert("L\'évaluation a été enregistrée ")</script>';
                echo "<script>window.location.href ='exams.php'</script>";
                $msg = "";
            } else {
                echo "<script>alert('Une erreur s\'est produite, veillez réessayer.');</script>";
            }
        }
    }

    if (isset($_POST['submit_classement'])) {
        $salle = $_POST['salle'];
        $surveillant = $_POST['surveillant'];

        $query_insert = mysqli_query($con, "INSERT INTO `tblclassements`(`cl_surveillant`, `cl_salle`) VALUES ('$surveillant','$salle')");
        if ($query_insert) {
            echo '<script>alert("L\'affectation du surveillant a été effectué")</script>';
            echo "<script>window.location.href ='exams.php'</script>";
            $msg = "";
        } else {
            echo "<script>alert('Une erreur s\'est produite, veillez réessayer.');</script>";
        }
    }

    if (isset($_GET['id'])) {
        // code...
        $query = mysqli_query($con, "delete from `tblevaluations` where id ='" . $_GET['id'] . "'");

        if ($query) {
            echo "<script>alert('L\'évaluation a été annulée.');</script>";
            echo "<script>window.location.href = 'exams.php'</script>";
            $msg = "";
        } else {
            echo "<script>alert('Une erreur s\'est produite, veillez réessayer.');</script>";
        }
    }

    if (isset($_GET['concl'])) {
        // code...
        $query = mysqli_query($con, "update `tblevaluations` set e_status=1 where id ='" . $_GET['concl'] . "'");

        if ($query) {
            echo "<script>alert('L\'évaluation a été conclue.');</script>";
            echo "<script>window.location.href = 'exams.php'</script>";
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
            <h4 class="text-primary"><i class="fas fa-stream"></i> Evaluations </h4>
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

                                                        <button type="button" class="btn btn-primary btn-sm mb-2" data-bs-toggle="modal" data-bs-target="#staticBackdrop"> <i class="fas fa-plus"></i> Programmer une évaluation</button>

                                                        <button type="button" class="btn btn-primary btn-sm mb-2" data-bs-toggle="modal" data-bs-target="#staticBackdrop1"> <i class="fas fa-plus"></i> Classement</button>

                                                        <button type="button" class="btn btn-dark btn-sm mb-2" onclick="window.print()"> <i class="fas fa-print"></i> Imprimer</button>

                                                    </p>
                                                </div>
                                                <div class="card-body">

                                                    <div class="table-responsive mt-2">

                                                        <input class="form-control" id="myInput" type="text" placeholder="Rechercher une évaluation.." onkeyup="myFunction()">
                                                        <br>
                                                        <table class="table table-striped nowrap" style="font-weight: normal;font: size 11px;background-color: white;" id="myTable">
                                                            <thead style="font-weight: normal;font: size 11px;">
                                                                <tr>
                                                                    <th class="th-sm" style="font-weight: bold;font: size 10px;">#</th>
                                                                    <th class="th-sm" style="font-weight: bold;font: size 10px;">Evaluation</th>
                                                                    <th class="th-sm" style="font-weight: bold;font: size 10px;">Type</th>
                                                                    <th class="th-sm" style="font-weight: bold;font: size 10px;">Session</th>
                                                                    <th class="th-sm" style="font-weight: bold;font: size 10px;">Date programmée</th>
                                                                    <th class="th-sm" style="font-weight: bold;font: size 10px;">Salle</th>
                                                                    <th class="th-sm" style="font-weight: bold;font: size 10px;" id="dont_print">Action</th>
                                                                </tr>
                                                            </thead>
                                                            <?php
                                                            $id_user = $_SESSION['sid'];
                                                            $dbj = new PDO('mysql:host=localhost; dbname=geva;charset=utf8', 'root', '');
                                                            $user_spec = $dbj->query("SELECT tblusers.* FROM tblusers WHERE id=$id_user");

                                                            $my_depart = $user_spec->fetch();
                                                            $mystudents = $my_depart['u_faculty'];
                                                            //echo $mystudents;
                                                            ?>
                                                            <tbody>
                                                                <?php
                                                                if ($mystudents == "") {
                                                                    $query = mysqli_query($con, "SELECT tblevaluations.*,tblevaluations.id as a, tblsalles.*, tblcourses.* FROM `tblevaluations`, tblsalles,tblcourses where tblevaluations.e_salle = tblsalles.id and tblevaluations.e_course=tblcourses.id order by tblevaluations.date_eval desc");
                                                                } else {
                                                                    $query = mysqli_query($con, "SELECT tblevaluations.*,tblevaluations.id as a, tblsalles.*, tblcourses.*, tblfaculties.*,tblclasses.* FROM `tblevaluations`, tblsalles,tblcourses,tblfaculties, tblclasses where tblcourses.c_classe=tblclasses.id and tblclasses.c_faculty=tblfaculties.id and tblfaculties.f_name like '$mystudents' and tblevaluations.e_salle = tblsalles.id and tblevaluations.e_course=tblcourses.id order by tblevaluations.date_eval desc");
                                                                }
                                                                $n = 1;
                                                                while ($row = mysqli_fetch_array($query)) {
                                                                ?>

                                                                    <tr>
                                                                        <td><?php echo $n; ?></td>
                                                                        <?php
                                                                        if ($row['e_status'] == 0) {
                                                                            // code...
                                                                        ?>
                                                                            <td><a href="" style="text-decoration:underline;"><i class="fas fa-folder" style="margin-right: 20px;"></i> <?php echo htmlentities($row['c_intitule']); ?></a></td>
                                                                        <?php
                                                                        }
                                                                        ?>
                                                                        <?php
                                                                        if ($row['e_status'] == 1) {
                                                                            // code...
                                                                        ?>
                                                                            <td><a href="" style="text-decoration:line-through;color: red;"><i class="fas fa-folder" style="margin-right: 20px;"></i> <?php echo htmlentities($row['c_intitule']); ?></a></td>
                                                                        <?php
                                                                        }
                                                                        ?>


                                                                        <?php
                                                                        if ($row['e_status'] == 0) {
                                                                            // code...
                                                                        ?>
                                                                            <td><a href="exams_date.php?type_ev=<?php echo htmlentities($row['e_type']); ?>" style="text-decoration:underline;"> <?php echo htmlentities($row['e_type']); ?></a></td>
                                                                        <?php
                                                                        }
                                                                        ?>


                                                                        <?php
                                                                        if ($row['e_status'] == 1) {
                                                                            // code...
                                                                        ?>
                                                                            <td><a href="exams_date.php?type_ev=<?php echo htmlentities($row['e_type']); ?>" style="text-decoration:line-through;color: red;"> <?php echo htmlentities($row['e_type']); ?></a></td>
                                                                        <?php
                                                                        }
                                                                        ?>
                                                                        <?php
                                                                        if ($row['e_status'] == 0) {
                                                                            // code...
                                                                        ?>
                                                                            <td>
                                                                                <a href="exams_date.php?session=<?php echo htmlentities($row['e_session']); ?>" style="text-decoration:underline;">
                                                                                    <?php
                                                                                    if ($row['e_session'] == 1) {
                                                                                        echo "Première session";
                                                                                    }
                                                                                    if ($row['e_session'] == 2) {
                                                                                        // code...
                                                                                        echo "Seconde session";
                                                                                    }
                                                                                    ?></a>
                                                                            </td>
                                                                        <?php
                                                                        }
                                                                        ?>
                                                                        <?php
                                                                        if ($row['e_status'] == 1) {
                                                                            // code...
                                                                        ?>
                                                                            <td>
                                                                                <a href="exams_date.php?session=<?php echo htmlentities($row['e_session']); ?>" style="text-decoration:line-through;color: red;">
                                                                                    <?php
                                                                                    if ($row['e_session'] == 1) {
                                                                                        echo "Première session";
                                                                                    }
                                                                                    if ($row['e_session'] == 2) {
                                                                                        // code...
                                                                                        echo "Seconde session";
                                                                                    }
                                                                                    ?></a>
                                                                            </td>
                                                                        <?php
                                                                        }
                                                                        ?>


                                                                        <?php
                                                                        if ($row['e_status'] == 0) {
                                                                            // code...
                                                                        ?>
                                                                            <td>
                                                                                <a href="exams_date.php?date=<?php echo htmlentities($row['date_eval']); ?>" style="text-decoration:underline;"></i> <?php echo htmlentities($row['date_eval']); ?></a>
                                                                            </td>
                                                                        <?php
                                                                        }
                                                                        ?>
                                                                        <?php
                                                                        if ($row['e_status'] == 1) {
                                                                            // code...
                                                                        ?>
                                                                            <td>
                                                                                <a href="exams_date.php?date=<?php echo htmlentities($row['date_eval']); ?>" style="text-decoration:line-through;color: red;"></i> <?php echo htmlentities($row['date_eval']); ?></a>
                                                                            </td>
                                                                        <?php
                                                                        }
                                                                        ?>

                                                                        <?php
                                                                        if ($row['e_status'] == 0) {
                                                                            // code...
                                                                        ?>

                                                                            <td>
                                                                                <a href="exams_date.php?salle=<?php echo htmlentities($row['e_salle']); ?>" style="text-decoration:underline;"></i> <?php echo htmlentities($row['s_name']); ?></a>
                                                                            </td>
                                                                        <?php
                                                                        }
                                                                        ?>

                                                                        <?php
                                                                        if ($row['e_status'] == 1) {
                                                                            // code...
                                                                        ?>

                                                                            <td>
                                                                                <a href="exams_date.php?salle=<?php echo htmlentities($row['e_salle']); ?>" style="text-decoration:line-through;color: red;"></i> <?php echo htmlentities($row['s_name']); ?></a>
                                                                            </td>
                                                                        <?php
                                                                        }
                                                                        ?>

                                                                        <td id="dont_print">
                                                                            <a href="exams.php?id=<?php echo htmlentities($row['a']); ?>" style="text-decoration:underline;" title="Annuler l'évaluation"></i><button class="btn btn-dark btn-sm mt-2"><i class="fas fa-times-circle"></i> Annuler</button> </a>
                                                                            <?php
                                                                            if ($row['e_status'] == 0) {
                                                                                // code...
                                                                            ?>
                                                                                <a href="exams.php?concl=<?php echo htmlentities($row['a']); ?>" style="text-decoration:underline;" title="Conclure l'évaluation"></i><button class="btn btn-primary btn-sm mt-2"><i class="fas fa-clipboard-check"></i> Conclure</button> </a>
                                                                            <?php
                                                                            }
                                                                            ?>

                                                                        </td>
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
                                                                        <h1 class="modal-title fs-5" id="staticBackdropLabel"><i class="fas fa-plus"></i> Programmer une évaluation</h1>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <form method="post" enctype="multipart/form-data">
                                                                        <div class="modal-body">

                                                                            <label for="exampleFormControlInput1" class="form-label mt-2">Type d'évaluation</label>
                                                                            <select class="form-control" name="evaluation" required>
                                                                                <option value="Test">Test</option>
                                                                                <option value="Examen" selected="">Examen</option>
                                                                            </select>

                                                                            <label for="exampleFormControlInput1" class="form-label mt-2">Session</label>
                                                                            <select class="form-control" name="session" required>
                                                                                <option value="1">Première session</option>
                                                                                <option value="2" selected="">Seconde session</option>
                                                                            </select>

                                                                            <label for="exampleFormControlInput1" class="form-label mt-2">Salle</label>
                                                                            <select class="form-control" name="salle" required>
                                                                                <?php $query = mysqli_query($con, "SELECT * FROM `tblsalles`");
                                                                                $n = 1;
                                                                                while ($row = mysqli_fetch_array($query)) {
                                                                                ?>
                                                                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['s_name']; ?></option>
                                                                                <?php
                                                                                    $n++;
                                                                                }
                                                                                ?>
                                                                            </select>

                                                                            <label for="exampleFormControlInput1" class="form-label mt-2">Cours</label>
                                                                            <select class="form-control" name="cours" required>
                                                                                <?php
                                                                                if ($mystudents == "") {
                                                                                    // code...
                                                                                    $query = mysqli_query($con, "SELECT tblcourses.*, tblfaculties.*, tblclasses.*,tblcourses.id as a FROM `tblcourses`, tblfaculties, tblclasses where tblclasses.c_faculty=tblfaculties.id and tblcourses.c_classe=tblclasses.id");
                                                                                } else {
                                                                                    $query = mysqli_query($con, "SELECT tblcourses.*, tblfaculties.*, tblclasses.*,tblcourses.id as a FROM `tblcourses`, tblfaculties, tblclasses where tblfaculties.f_name like '$mystudents' and tblclasses.c_faculty=tblfaculties.id and tblcourses.c_classe=tblclasses.id");
                                                                                }

                                                                                $n = 1;
                                                                                while ($row = mysqli_fetch_array($query)) {
                                                                                ?>
                                                                                    <option value="<?php echo $row['a']; ?>"><?php echo $row['c_intitule']; ?></option>
                                                                                <?php
                                                                                    $n++;
                                                                                }
                                                                                ?>
                                                                            </select>

                                                                            <label for="exampleFormControlInput1" class="form-label mt-2">Date évaluation</label>
                                                                            <input type="date" class="form-control mb-3" placeholder="Date évaluation" name="date_evaluation" required>

                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                                                            <button type="submit" class="btn btn-primary" name="submit">Enregistrer</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- classements -->

                                                        <!-- Modal -->
                                                        <div class="modal fade" id="staticBackdrop1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                            <div class="modal-dialog" style="background-color:whitesmoke;">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h1 class="modal-title fs-5" id="staticBackdropLabel"><i class="fas fa-table"></i> Classement</h1>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <form method="post" enctype="multipart/form-data">
                                                                        <div class="modal-body">


                                                                            <label for="exampleFormControlInput1" class="form-label mt-2">Salle</label>
                                                                            <select class="form-control" name="salle" required>
                                                                                <?php $query = mysqli_query($con, "SELECT tblsalles.*, tblsalles.id as ev FROM tblsalles order by s_name asc");
                                                                                $n = 1;
                                                                                while ($row = mysqli_fetch_array($query)) {
                                                                                ?>
                                                                                    <option value="<?php echo $row['ev']; ?>"><?php echo $row['s_name']; ?></option>
                                                                                <?php
                                                                                    $n++;
                                                                                }
                                                                                ?>
                                                                            </select>

                                                                            <label for="exampleFormControlInput1" class="form-label mt-2">Surveillant</label>
                                                                            <select class="form-control" name="surveillant" required>
                                                                                <?php $query = mysqli_query($con, "SELECT * FROM `tblsurveillants`");
                                                                                $n = 1;
                                                                                while ($row = mysqli_fetch_array($query)) {
                                                                                ?>
                                                                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['s_name']; ?></option>
                                                                                <?php
                                                                                    $n++;
                                                                                }
                                                                                ?>
                                                                            </select>

                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                                                            <button type="submit" class="btn btn-primary" name="submit_classement">Enregistrer</button>
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
