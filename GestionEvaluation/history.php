<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['sid'] == 0)) {
  header('location:logout.php');
} else {
  if (isset($_POST['submit'])) {
    $s_article = $_POST['s_article'];
    $s_quantity = $_POST['s_quantity'];

    $s_client = $_POST['s_client'];

    $s_details = $_POST['s_details'];
    $s_saved = $_SESSION['name'] . " " . $_SESSION['lastname'];

    $dbj = new PDO('mysql:host=localhost; dbname=e_shop;charset=utf8', 'root', '');

    $upd = $dbj->query("SELECT * FROM tblarticles WHERE id=$s_article");

    $svd = $upd->fetch();

    $s_total_cost = $s_quantity * $svd['a_cost'];

    $remain = $svd['a_quantity'] - $s_quantity;

    //echo $s_total_cost;
    if ($svd['a_remaining_qty'] < $s_quantity) {
      echo "<script>alert('Il se peut que vous n'ayez pas assez de produits dans le stock.');</script>";
    } else {
      $query = mysqli_query($con, "insert into `tblsells`(`s_article`, `s_quantity`, `s_total_cost`, `s_client`, `s_saved`, `s_details`) values ('$s_article','$s_quantity','$s_total_cost','$s_client','$s_saved','$s_details')");

      $query_1 = mysqli_query($con, "UPDATE `tblarticles` SET `a_remaining_qty`='$remain' WHERE id=$s_article");
      if ($query_1) {
        // code...
        if ($query) {
          echo "<script>alert('La vente a été effectuée.');</script>";
          echo "<script>window.location.href = 'sell.php'</script>";
          $msg = "";
        }
      } else {
        echo "<script>alert('Une erreur s\'est produite, veillez réessayer.');</script>";
      }
    }
  }
?>
  <?php

  $dbj = new PDO('mysql:host=localhost; dbname=sdmsdb;charset=utf8', 'root', '');
  $sid = $_SESSION['sid'];
  $uxd = $dbj->query("SELECT * FROM tblsettings WHERE id=1");

  $xvd = $uxd->fetch();
  ?>

  <!DOCTYPE html>
  <html>

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Historique de connexion - <?php echo $xvd['shop_name']; ?></title>
    <?php include('includes/head.php'); ?>

    <!-- searching in table -->
    <script src="assets/js/jquery.min.js"></script>

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

  <body id="page-top">
    <div id="wrapper">
      <?php include('includes/sidebar.php'); ?>
      <div class="d-flex flex-column" id="content-wrapper">
        <div id="content">
          <?php include('includes/nav_menu.php'); ?>
          <div class="container-fluid">
            <h3 class="text-dark mb-4"><i class="fas fa-history"></i> Historique de connexion</h3>
            <div class="card shadow">
              <div class="card-header py-3">
                <p class="text-primary m-0 fw-bold">



                  <a href="excel/history.php"><button type="button" class="btn btn-success btn-sm text-white" data-bs-toggle="modal_1" data-bs-target="#staticBackdrop">
                      <i class="fas fa-file-excel"></i>
                      Exporter les données
                    </button></a>
                </p>
              </div>
              <div class="card-body">

                <div class="table-responsive mt-2">

                  <input class="form-control" id="myInput" type="text" placeholder="Rechercher la connexion au système...">
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
                        <th class="text-center">Etat</th>
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
                            <td class="text-left"><?php $st = ($row->status);
                                                  if ($st == 1) {
                                                    echo "<span class='badge bg-success rounded-pill'> Réussie</span>";
                                                  } else {
                                                    echo "<span class='badge bg-danger rounded-pill'> Echec</span>";
                                                  }
                                                  ?></td>
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
                          <h1 class="modal-title fs-5" id="staticBackdropLabel"><i class="fas fa-edit"></i> Editer une vente</h1>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="post">
                          <div class="modal-body">


                            <label for="exampleFormControlInput1" class="form-label">Choisir le client</label>
                            <select class="form-control mb-3" name="s_client">
                              <?php
                              $query = mysqli_query($con, "SELECT * FROM tblclients order by c_name asc");
                              while ($row = mysqli_fetch_array($query)) {

                              ?>
                                <option value="<?php echo $row['id'] ?>"><?php echo $row['c_name'] ?></option>
                              <?php
                              }
                              ?>
                            </select>



                            <label for="exampleFormControlInput1" class="form-label">Choisir l'article</label>
                            <select class="form-control mb-3" name="s_article">
                              <?php
                              $query = mysqli_query($con, "SELECT * FROM tblarticles order by a_name asc");
                              while ($row = mysqli_fetch_array($query)) {

                              ?>
                                <option value="<?php echo $row['id'] ?>"><?php echo $row['a_name'] ?></option>
                              <?php
                              }
                              ?>
                            </select>



                            <label for="exampleFormControlInput1" class="form-label">Quantité</label>
                            <input type="number" class="form-control mb-3" placeholder="Quantité de l'article" name="s_quantity">


                            <label for="exampleFormControlInput1" class="form-label">Détails</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="s_details"></textarea>


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
      </div><a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a>
    </div>

    <?php include('scripts.php'); ?>
  </body>

  </html>
<?php
}
?>
