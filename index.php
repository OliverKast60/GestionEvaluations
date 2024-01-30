<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (isset($_POST['login'])) {
  $username = $_POST['username'];
  $password = md5($_POST['password']);

  $sql = "SELECT * FROM tblusers WHERE username=:username and Password=:password ";
  $query = $dbh->prepare($sql);
  $query->bindParam(':username', $username, PDO::PARAM_STR);
  $query->bindParam(':password', $password, PDO::PARAM_STR);
  $query->execute();

  $results = $query->fetchAll(PDO::FETCH_OBJ);
  if ($query->rowCount() > 0) {
    foreach ($results as $result) {
      $_SESSION['sid'] = $result->id;
      $_SESSION['name'] = $result->name;
      $_SESSION['lastname'] = $result->lastname;
      $_SESSION['permission'] = $result->permission;
    }

    if (!empty($_POST["remember"])) {
      //COOKIES for username
      setcookie("user_login", $_POST["username"], time() + (10 * 365 * 24 * 60 * 60));
      //COOKIES for password
      setcookie("userpassword", $_POST["password"], time() + (10 * 365 * 24 * 60 * 60));
    } else {
      if (isset($_COOKIE["user_login"])) {
        setcookie("user_login", "");
        if (isset($_COOKIE["userpassword"])) {
          setcookie("userpassword", "");
        }
      }
    }
    $aa = $_SESSION['sid'];
    $sql = "SELECT * from tblusers  where id=:aa";
    $query = $dbh->prepare($sql);
    $query->bindParam(':aa', $aa, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);

    $cnt = 1;
    if ($query->rowCount() > 0) {
      foreach ($results as $row) {

        if ($row->status == "1" && $row->permission == "Chef de département") {
          $extra = "GestionEvaluation/dashboard.php";
          //header('location:GestionEvaluation/dashboard.php');

          $username = $_POST['username'];
          $name = $_SESSION['name'];
          $lastname = $_SESSION['lastname'];

          $_SESSION['login'] = $_POST['username'];
          $_SESSION['id'] = $num['id'];
          $_SESSION['username'] = $num['name'];
          $uip = $_SERVER['REMOTE_ADDR'];
          $status = 1;

          $sql = "insert into userlog(`username`, `name`, `userip`)values(:username,:name,:uip)";
          $query = $dbh->prepare($sql);
          $query->bindParam(':username', $username, PDO::PARAM_STR);
          $query->bindParam(':name', $name, PDO::PARAM_STR);
          $query->bindParam(':uip', $uip, PDO::PARAM_STR);
          $query->execute();
          $host = $_SERVER['HTTP_HOST'];
          $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
          header("location:http://$host$uri/$extra");
          exit();
        }
        if ($row->status == "1" && $row->permission == "Doyen de la faculté") {
          $extra = "GestionEvaluation/dashboard.php";

          $username = $_POST['username'];
          $name = $_SESSION['name'];
          $lastname = $_SESSION['lastname'];

          $_SESSION['login'] = $_POST['username'];
          $_SESSION['id'] = $num['id'];
          $_SESSION['username'] = $num['name'];
          $uip = $_SERVER['REMOTE_ADDR'];
          $status = 1;

          $sql = "insert into userlog(`username`, `name`, `userip`)values(:username,:name,:uip)";
          $query = $dbh->prepare($sql);
          $query->bindParam(':username', $username, PDO::PARAM_STR);
          $query->bindParam(':name', $name, PDO::PARAM_STR);
          $query->bindParam(':uip', $uip, PDO::PARAM_STR);
          $query->execute();
          $host = $_SERVER['HTTP_HOST'];
          $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
          header("location:http://$host$uri/$extra");
          exit();
        } else if ($row->status == "1" && $row->permission == "Directeur académique") {
          $extra = "GestionEvaluation/dashboard.php";

          $username = $_POST['username'];
          $name = $_SESSION['name'];
          $lastname = $_SESSION['lastname'];

          $_SESSION['login'] = $_POST['username'];
          $_SESSION['id'] = $num['id'];
          $_SESSION['username'] = $num['name'];
          $uip = $_SERVER['REMOTE_ADDR'];
          $status = 1;

          $sql = "insert into userlog(`username`, `name`, `userip`)values(:username,:name,:uip)";
          $query = $dbh->prepare($sql);
          $query->bindParam(':username', $username, PDO::PARAM_STR);
          $query->bindParam(':name', $name, PDO::PARAM_STR);
          $query->bindParam(':uip', $uip, PDO::PARAM_STR);
          $query->execute();
          $host = $_SERVER['HTTP_HOST'];
          $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
          header("location:http://$host$uri/$extra");
          exit();
        } else {
          echo "<script>alert('Votre compte a été bloqué par l'Admin);document.location ='index.php';</script>";
        }
      }
    }
  } else {
    $extra = "index.php";
    $username = $_POST['username'];
    $uip = $_SERVER['REMOTE_ADDR'];
    $status = 0;
    $email = 'Not registered in system';
    $name = 'Intruision';
    $sql = "insert into userlog(`username`, `name`, `userip`)values(:username,:name,:uip)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':username', $username, PDO::PARAM_STR);
    $query->bindParam(':name', $name, PDO::PARAM_STR);
    $query->bindParam(':uip', $uip, PDO::PARAM_STR);
    $query->execute();
    $host = $_SERVER['HTTP_HOST'];
    $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    echo "<script>alert('Vos identifiants sont incorrects');document.location ='http://$host$uri/$extra';</script>";
  }
}
?>


<?php include("includes/head.php"); ?>

<body class="hold-transition login-page" style="background-image: url('wallpapers/flowing-purple-mountain-spiral-bright-imagination-generated-by-ai.jpg');background-size: cover;background-repeat: no-repeat;">

  <div class="row">
    <div class="col-md-12">
      <div class="row">
        <div class="col-md-12 bg-danger"></div>
      </div>
    </div>
  </div>

  <div class="login-box">
    <div class="card" style="background-color: transparent;opacity: 0.8;">
      <div class="card-body login-card-body" style="opacity: 0.9;">


        <div class="row mt-5">
          <div class="col-md-4"></div>
          <div class="col-md-4" style="border: solid black 0px;padding:60px;box-shadow: 0 0 10px black;border-radius:60px;background-color: whitesmoke;">
            <div class="login-logo">
              <center>
                <img src="logo/logo.png" style="width: 50%;">
              </center>
            </div>

            <h3 class="title text-center text-primary" style="font-weight:bolder;">Gestion Evaluations</h3>
            <hr>
            <form action="" method="post">
              <div class="input-group mb-3">
                <input type="text" name="username" class="form-control" placeholder="Nom Utilisateur" required value="<?php if (isset($_COOKIE["user_login"])) {
                  echo $_COOKIE["user_login"];
                } ?>" title="Entrer le nom d'utilisateur" style="font-size: 12px;border-radius:20px;" autocomplete="off">
                <div class="input-group-append"></div>
              </div>
              <div class="input-group mb-3">
                <input type="password" name="password" class="form-control" placeholder="Mot de passe" required value="<?php if (isset($_COOKIE["userpassword"])) {
                  echo $_COOKIE["userpassword"];
                } ?>" autocomplete="off" title="Entrer le mot de passe" style="font-size: 12px;border-radius:20px;" autocomplete="off">
                <div class="input-group-append"></div>
              </div>
              <div class="row">
                <div class="col-12">
                  <div class="icheck-primary">
                    <input type="checkbox" id="remember" <?php if (isset($_COOKIE["user_login"])) { ?> checked <?php } ?> style="border-radius: 50%;">
                    <label for="remember" style="font-size:11px;font-weight: bolder;">
                      Se souvenir de moi?
                    </label>
                  </div>
                </div>
                <!-- /.col -->
                <div class="col-12 mb-3 mt-2">
                  <button type="submit" name="login" class="btn btn-primary btn-block form-control" data-toggle="modal" data-taget="#modal-default" style="font-size: 12px;border-radius:20px;">Se connecter</button>
                </div>
                <div class="col-12">
                  <button type="reset" name="reset" class="btn btn-dark btn-block form-control" data-toggle="modal" data-taget="#modal-default" onclick="alert('Vous avez initialisé les champs!')" style="font-size: 12px;border-radius:20px;">Annuler</button>
                </div>
              </div>
            </form>


          </div>
        </div>


      </div>
    </div>
  </div>

  <?php //include("includes/foot.php"); 
  ?>
  <script src="assets/js/core/js.cookie.min.js"></script>
  <?php //include("includes/footer.php"); 
  ?>
</body></html>
