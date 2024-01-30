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
    $query = mysqli_query($con, "delete from `userlog` where 1");

    if ($query) {
      echo "<script>alert('L\'historique de connexion a été supprimée.');</script>";
      echo "<script>window.location.href = 'connect_history.php'</script>";
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
      <h4 class="text-primary"><i class="fas fa-history"></i> Historique de connexion </h4>
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
                            if ($_SESSION['permission'] == 'Directeur académique') {
                              // code...
                            ?>
                              <a href="connect_history.php?id="><button type="button" class="btn btn-danger btn-sm mb-2"> <i class="fas fa-trash"></i> Effacer l'historique</button></a>
                            <?php
                            }
                            ?>


                            <button type="button" class="btn btn-dark btn-sm mb-2" onclick="window.print()"> <i class="fas fa-print"></i> Imprimer</button>



                          </p>
                        </div>
                        <div class="card-body">

                          <div class="table-responsive mt-2">

                            <input class="form-control" id="myInput" type="text" placeholder="Rechercher un utilisateur.." onkeyup="myFunction()">
                            <br>
                            <table class="table table-bordered table-striped" style="font-weight: normal;">
                              <thead>
                                <tr>
                                  <th class="text-center">Nom Utilisateur</th>
                                  <th class="text-center">Nom</th>
                                  <th class="text-center">Email</th>
                                  <th class="text-center">Adresse IP</th>
                                  <th class="text-center">Connexion</th>
                                  <th class="text-center">Deconnexion</th>
                                </tr>
                              </thead>
                              <tbody id="myTable">
                                <?php
                                $sql = "SELECT * from userlog order by id desc";
                                $query = $dbh->prepare($sql);
                                $query->execute();
                                $results = $query->fetchAll(PDO::FETCH_OBJ);
                                $cnt = 1;
                                if ($query->rowCount() > 0) {
                                  foreach ($results as $row) {               ?>
                                    <tr>
                                      <td><?php echo htmlentities($row->username); ?></td>
                                      <td class="text-left"><?php echo htmlentities($row->name); ?> <?php echo htmlentities($row->lastname); ?></td>
                                      <td class="text-left"><?php echo htmlentities($row->userEmail); ?></td>
                                      <td class="text-left"><?php echo htmlentities($row->userip); ?></td>
                                      <td class="text-left"><?php echo htmlentities($row->loginTime); ?></td>
                                      <td class="text-left"><?php echo htmlentities($row->logout); ?></td>

                                    </tr>

                                <?php
                                  }
                                } ?>
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
