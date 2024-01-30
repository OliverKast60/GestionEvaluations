<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['sid'] == 0)) {
    header('location:logout.php');
} else {

    if (isset($_POST['submit'])) {
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

        $query_insert = mysqli_query($con, "INSERT INTO `tblprofesseurs`(`p_name`, `p_image`, `p_contact`, `p_address`, `p_matricule`, `p_course`) VALUES ('$nom','$userimage','$contact','$address','$id_number','$cours')");
        if ($query_insert) {
            echo '<script>alert("Le professeur a été enregistré")</script>';
            echo "<script>window.location.href ='professors.php'</script>";
            $msg = "";
        } else {
            echo "<script>alert('Une erreur s\'est produite, veillez réessayer.');</script>";
        }
    }



    if (isset($_GET['id'])) {
        // code...
        $query = mysqli_query($con, "delete from `tblprofesseurs` where id ='" . $_GET['id'] . "'");

        if ($query) {
            echo "<script>alert('Le professeur a été supprimé.');</script>";
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
        <script src="assets/js/jquery.min.js"></script>
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
            <h4 class="text-primary"><i class="fas fa-users"></i> Professeurs </h4>
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

                                                        <button type="button" class="btn btn-primary btn-sm mb-2" data-bs-toggle="modal" data-bs-target="#staticBackdrop"> <i class="fas fa-plus"></i> Ajouter un professeur</button>

                                                        <button type="button" class="btn btn-dark btn-sm mb-2" onclick="window.print()"> <i class="fas fa-print"></i> Imprimer</button>



                                                    </p>
                                                </div>
                                                <div class="card-body">

                                                    <div class="table-responsive mt-2">

                                                        <input class="form-control" id="myInput" type="text" placeholder="Rechercher un professeur.." onkeyup="myFunction()">
                                                        <br>
                                                        <table class="table table-striped nowrap" style="font-weight: normal;font: size 11px;" id="myTable">
                                                            <thead style="font-weight: normal;font: size 11px;">
                                                                <tr>
                                                                    <th class="th-sm" style="font-weight: bold;font: size 10px;">#</th>
                                                                    <th class="th-sm" style="font-weight: bold;font: size 10px;">Profil</th>
                                                                    <th class="th-sm" style="font-weight: bold;font: size 10px;">Matricule</th>
                                                                    <th class="th-sm" style="font-weight: bold;font: size 10px;">Nom</th>
                                                                    <th class="th-sm" style="font-weight: bold;font: size 10px;">Cours</th>
                                                                    <th class="th-sm" style="font-weight: bold;font: size 10px;">Adresse</th>
                                                                    <th class="th-sm" style="font-weight: bold;font: size 10px;">Contact</th>



                                                                    <th class="th-sm" style="font-weight: bold;font: size 10px;" id="dont_print">Action</th>

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
                                                                    // code...
                                                                    $query = mysqli_query($con, "SELECT tblprofesseurs.*,tblprofesseurs.id as a, tblcourses.* FROM `tblprofesseurs`, tblcourses where tblprofesseurs.p_course = tblcourses.id order by tblprofesseurs.p_name asc");
                                                                } else {
                                                                    $query = mysqli_query($con, "SELECT tblprofesseurs.*,tblprofesseurs.id as a,tblfaculties.*, tblcourses.* , tblclasses.* FROM `tblprofesseurs`, tblcourses, tblfaculties, tblclasses where tblfaculties.id=tblclasses.c_faculty and tblcourses.c_classe=tblclasses.id and tblfaculties.f_name like '$mystudents' and tblprofesseurs.p_course = tblcourses.id order by tblprofesseurs.p_name asc");
                                                                }

                                                                $n = 1;
                                                                while ($row = mysqli_fetch_array($query)) {
                                                                ?>

                                                                    <tr>
                                                                        <td><?php echo $n; ?></td>
                                                                        <td>
                                                                            <img src="profil_images/<?php echo ($row['p_image']); ?>" style="width: 60px;height: 60px;border-radius: 50%;">
                                                                        </td>
                                                                        <td><?php echo ($row['p_matricule']); ?></td>
                                                                        <td><?php echo ($row['p_name']); ?></td>
                                                                        <td><?php echo ($row['c_intitule']); ?></td>
                                                                        <td><?php echo ($row['p_address']); ?></td>
                                                                        <td><?php echo ($row['p_contact']); ?></td>

                                                                        <td id="dont_print">
                                                                            <a href="edit_professor.php?edit=<?php echo $row['a']; ?>" title="Modifier"><button class="btn btn-success btn-sm" style="font-size:11px;"><i class="fas fa-edit"></i> Modifier</button></a>
                                                                            <a href="professors.php?id=<?php echo $row['a']; ?>" title="Supprimer" style="font-size:11px;"><button class="btn btn-danger btn-sm" style="font-size:11px;"><i class="fas fa-trash"></i> Supprimer</button></a>
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
                                                                        <h1 class="modal-title fs-5" id="staticBackdropLabel"><i class="fas fa-plus"></i> Nouveau professeur</h1>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <form method="post" enctype="multipart/form-data">
                                                                        <div class="modal-body">
                                                                            <label label for="exampleFormControlInput1" class="form-label mt-3">Choisir une photo de profil</label>
                                                                            <input type="file" name="userimage" id="userimage" class="file-upload-default mb-3 form-control" required>

                                                                            <label for="exampleFormControlInput1" class="form-label">Nom du professeur</label>
                                                                            <input type="text" class="form-control mb-3" placeholder="Nom complet" name="nom" required>

                                                                            <label for="exampleFormControlInput1" class="form-label">Adresse de résidence</label>
                                                                            <input type="text" class="form-control mb-3" placeholder="Adresse de résidence" name="address" required>

                                                                            <label for="exampleFormControlInput1" class="form-label">Contact (email)</label>
                                                                            <input type="mail" class="form-control mb-3" placeholder="Email" name="contact" required>

                                                                            <label for="exampleFormControlInput1" class="form-label">Cours dispensé</label>
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
        <script type="text/javascript">

        </script>

        <script type="text/javascript" src="dash.js"></script>

    </html>
<?php
}
?>
