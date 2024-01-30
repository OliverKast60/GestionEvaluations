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
            echo '<script>alert("La présence été enregistrée")</script>';
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
            <h4 class="text-primary"><i class="fas fa-th-list"></i> Présences </h4>
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
                                                    <p class="text-primary m-0 fw-bold">
                                                        <!-- Button trigger modal -->

                                                        <a href="attendances_list.php"><button type="button" class="btn btn-primary btn-sm mb-2"> <i class="fas fa-th-list"></i> Listes des présences</button></a>



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
                                                                    <th class="th-sm" style="font-weight: bold;font: size 10px;">Profil</th>
                                                                    <th class="th-sm" style="font-weight: bold;font: size 10px;">Matricule</th>
                                                                    <th class="th-sm" style="font-weight: bold;font: size 10px;">Nom</th>
                                                                    <th class="th-sm" style="font-weight: bold;font: size 10px;">Genre</th>
                                                                    <th class="th-sm" style="font-weight: bold;font: size 10px;">Etat civil</th>
                                                                    <th class="th-sm" style="font-weight: bold;font: size 10px;">Date de naissance</th>
                                                                    <th class="th-sm" style="font-weight: bold;font: size 10px;">Adresse</th>
                                                                    <th class="th-sm" style="font-weight: bold;font: size 10px;">Email</th>
                                                                    <th class="th-sm" style="font-weight: bold;font: size 10px;">Nationalité</th>
                                                                    <th class="th-sm" style="font-weight: bold;font: size 10px;">Classe</th>



                                                                    <th class="th-sm" style="font-weight: bold;font: size 10px;">Action</th>

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
                                                                    $query = mysqli_query($con, "SELECT tblstudents.*,tblstudents.id as a, tblclasses.*,tblstudents.s_classe as cr, tblfaculties.* FROM `tblstudents`, tblclasses,tblfaculties where tblstudents.s_classe = tblclasses.id and tblclasses.c_faculty=tblfaculties.id order by tblstudents.s_name asc");
                                                                } else {
                                                                    $query = mysqli_query($con, "SELECT tblstudents.*,tblstudents.id as a, tblclasses.*,tblstudents.s_classe as cr, tblfaculties.* FROM `tblstudents`, tblclasses,tblfaculties where tblstudents.s_classe = tblclasses.id and tblclasses.c_faculty=tblfaculties.id and (tblfaculties.f_name like '$mystudents') order by tblstudents.s_name asc");
                                                                }
                                                                $n = 1;
                                                                while ($row = mysqli_fetch_array($query)) {
                                                                ?>

                                                                    <tr>
                                                                        <td><?php echo $n; ?></td>
                                                                        <td>
                                                                            <img src="students_profil/<?php echo ($row['s_userimage']); ?>" style="width: 60px;height: 60px;border-radius: 50%;">
                                                                        </td>
                                                                        <td><?php echo ($row['s_matricule']); ?></td>
                                                                        <td><?php echo ($row['s_name']); ?></td>
                                                                        <td><?php echo ($row['s_sex']); ?></td>
                                                                        <td><?php echo ($row['s_civil']); ?></td>
                                                                        <td><?php echo ($row['s_date_naissance']); ?></td>
                                                                        <td><?php echo ($row['s_address']); ?></td>
                                                                        <td><?php echo ($row['s_contact']); ?></td>
                                                                        <td><?php echo ($row['s_nationalite']); ?></td>
                                                                        <td><?php echo ($row['f_name'] . "/" . $row['c_name'] . "/" . $row['c_option']); ?></td>

                                                                        <td>


                                                                            <form method="post">
                                                                                <div class="row">

                                                                                    <div class="col-md-2">
                                                                                        <input type="text" class="form-control" name="student" value="<?php echo $row['a']; ?>" readonly title="<?php echo $row['a']; ?>">
                                                                                    </div>

                                                                                    <div class="col-md-10">
                                                                                        <select class="form-control" name="evaluation" required>
                                                                                            <?php
                                                                                            $ma_classe = $row['cr'];
                                                                                            $query1 = mysqli_query($con, "SELECT tblcourses.*, tblevaluations.*, tblevaluations.id as j FROM `tblcourses`, tblevaluations where tblcourses.c_classe=$ma_classe and tblevaluations.e_course=tblcourses.id");
                                                                                            $n1 = 1;
                                                                                            while ($row1 = mysqli_fetch_array($query1)) {
                                                                                            ?>
                                                                                                <?php
                                                                                                if ($row1['e_status'] == '1') {
                                                                                                    // code...
                                                                                                ?>
                                                                                                    <option value="<?php echo $row1['j']; ?>" title="<?php echo $row1['j']; ?>" style="color: red;background-color: pink;"><?php echo $row1['c_intitule'] . " " . $row['cr']; ?></option>
                                                                                                <?php
                                                                                                } else {
                                                                                                ?>
                                                                                                    <option value="<?php echo $row1['j']; ?>" title="<?php echo $row1['j']; ?>"><?php echo $row1['c_intitule'] . " " . $row['cr']; ?></option>
                                                                                                <?php
                                                                                                }
                                                                                                ?>

                                                                                            <?php
                                                                                                $n1++;
                                                                                            }
                                                                                            ?>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>


                                                                                <button class="btn btn-success btn-sm mb-2 mt-2 form-control" type="submit" name="confirmer" style="font-size:11px;"><i class="fas fa-check-circle"></i> Confirmer</button>
                                                                            </form>

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
