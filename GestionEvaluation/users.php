<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['sid']==0)) {
  header('location:logout.php');
} else{
  if(isset($_POST['submit']))
  {
    $name=$_POST['name'];
    $lastname=$_POST['lastname'];
    $username=$_POST['username'];
    $email=$_POST['email'];
    $mobile=$_POST['mobile'];
    $sex=$_POST['sex'];
    $permission=$_POST['permission'];
    $password=md5("1234");


    $Address=$_POST['Address'];
    $speciality=$_POST['speciality'];


    function getRandomStr($n) { 
    $str = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; 
    $randomStr = ''; 
  
    for ($i = 0; $i < $n; $i++) { 
        $index = rand(0, strlen($str) - 1); 
        $randomStr .= $str[$index]; 
    } 
  
    return $randomStr; 
} 

$b=4; 
$a = getRandomStr($b); 



    $id_number=substr($name, 0,3).$a.rand(100,100000);

    $salary=$_POST['salary'];
    $userimage=$_FILES["userimage"]["name"];
    move_uploaded_file($_FILES["userimage"]["tmp_name"],"employee_images/".$_FILES["userimage"]["name"]);

    $query_insert=mysqli_query($con, "insert into tblusers(`name`, `lastname`, `username`, `email`, `sex`, `permission`, `password`, `mobile`, `userimage`, `status`, `id_number`, `Address`, `speciality`, `pay`) VALUES ('$name','$lastname','$username','$email','$sex','$permission','$password','$mobile','$userimage','$id_number','$Address','$speciality','$salary')");
        if ($query_insert) 
        {
          echo '<script>alert("L\'employé a été enregistré")</script>';
          echo "<script>window.location.href ='users.php'</script>";  
        $msg="";
        }
      
      else
        {
            echo "<script>alert('Une erreur s\'est produite, veillez réessayer.');</script>";    
        }
    
  }
  if(isset($_GET['id']))
{
  mysqli_query($con,"delete from `tblusers` where id = '".$_GET['id']."'");
  echo "<script>alert('Suppression réussie.');</script>"; 
  echo "<script>window.location.href = 'users.php'</script>"; 
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
    <title>Employés - <?php echo $xvd['shop_name']; ?></title>
    <?php include('includes/head.php'); ?>
    
    <!-- searching in table -->
  <script src="assets/js/jquery.min.js"></script>

  <script>
    $(document).ready(function(){
    $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#myTable tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
  </script>
  <style>
    #profil_pic{
        width:40px;
        height: 40px;
        border-radius:50%;
    }
    table td{
        font-size:11px;
    }
  </style>
</head>
<?php 

$dbj = new PDO('mysql:host=localhost; dbname=geva;charset=utf8', 'root', '');

$sid = $_SESSION['sid'];
$upd = $dbj->query("SELECT * FROM tblusers WHERE id=$sid");
$svd = $upd->fetch();
 ?>
<body id="page-top">
    <div id="wrapper">
        <?php include('includes/sidebar.php'); ?>
        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">
                <?php include('includes/nav_menu.php'); ?>
                <div class="container-fluid">
                    <h3 class="text-dark mb-4"><i class="fas fa-users"></i> Employés</h3>
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <p class="text-primary m-0 fw-bold">
                                <!-- Button trigger modal -->
<?php
  if ($_SESSION['permission']=='Super Admin') {
    # code...
  ?>
  <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
    <i class="fas fa-plus"></i>
  Ajouter un Employé
</button>


<a href="excel/users.php"><button type="button" class="btn btn-success btn-sm text-white" data-bs-toggle="modal_1" data-bs-target="#staticBackdrop">
    <i class="fas fa-file-excel"></i>
  Exporter en excel
</button></a>
<?php
  }
?>

</p>
                        </div>
                        <div class="card-body">
                            
                            <div class="table-responsive mt-2">
                                
                                <input class="form-control" id="myInput" type="text" placeholder="Rechercher un employé...">
  <br>
  <table class="table table-bordered table-striped" style="font-weight: normal;">
    <thead>
        <tr>
                                            <th class="th-sm">#</th>
                                            <th class="th-sm">Profil</th>
                                            <th class="th-sm">Nom</th>
                                            <th class="th-sm">Sexe</th>
                                            
                                            <th class="th-sm">Email</th>
                                            <th class="th-sm">Contact</th>
                                            
                                            <th class="th-sm">Matricule</th>
                                            <?php
  if ($_SESSION['permission']=='Super Admin') {
    # code...
  ?>
                                            <th>Action</th>
  <?php
  }
  ?>
                                            
                                        </tr>
                                    </thead>
    <tbody id="myTable">
      <?php $query=mysqli_query($con,"select * from tblusers where permission like 'Gérant chambre froide' or permission like 'Super Admin'");
                      $cnt=1;
                      while($row=mysqli_fetch_array($query))
                      {
                        ?>
                                        <tr>
                                            <td><?php echo htmlentities($cnt);?></td>
                                             <td>
                                                <img src="employee_images/<?php echo htmlentities($row['userimage']);?>" alt="" srcset="" id="profil_pic">
                                                
                                                </td>
                                             <td><?php echo htmlentities($row['name']." ".$row['lastname']);?></td>
                                             <td><?php echo htmlentities($row['sex']);?></td>
                                             <td><?php echo htmlentities($row['email']);?></td>
                                             <td><?php echo htmlentities("0".$row['mobile']);?></td>
                                        
                                             <td><?php echo htmlentities($row['id_number']);?></td>
                                             <?php
  if ($_SESSION['permission']=='Super Admin') {
    # code...
  ?>
                                             <td>
                                                 <a href="users.php?id=<?php echo $row['id']; ?>"><button class="btn btn-danger btn-sm mb" title="Supprimer"><i class="fas fa-trash"></i> </button></a>
                                             </td>
                                            <?php
  }
  ?>
                                             
                                            
                                        </tr>
                        <?php
                        $cnt++;
                    }
                        ?>
    </tbody>
  </table>




                                <!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" >
  <div class="modal-dialog" style="background-color:whitesmoke;">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel"><i class="fas fa-plus"></i> Ajouter un employé</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="post" enctype="multipart/form-data">
      <div class="modal-body">

            <label for="exampleFormControlInput1" class="form-label">Nom</label>
            <input type="text" class="form-control mb-3" placeholder="Nom" name="name" required>

            <label for="exampleFormControlInput1" class="form-label">Prénom</label>
            <input type="text" class="form-control mb-3" placeholder="Prénom" name="lastname" required>

            <label for="exampleFormControlInput1" class="form-label">Nom Utilisateur</label>
            <input type="text" class="form-control mb-3" placeholder="Nom Utilisateur" name="username" required>

            <label for="exampleFormControlInput1" class="form-label">Sexe</label>
            <select class="form-control" name="sex" required>
                <option value="Homme" selected>Homme</option>
                <option value="Femme">Femme</option>
            </select>

            <label label for="exampleFormControlInput1" class="form-label mt-3">Choisir une photo de profil</label>
            <input type="file" name="userimage" id="userimage" class="file-upload-default mb-3 form-control" required>

            <label for="exampleFormControlInput1" class="form-label">Email</label>
            <input type="email" class="form-control mb-3" placeholder="Email" name="email" required>

            <label for="exampleFormControlInput1" class="form-label">Contact</label>
            <input type="number" class="form-control mb-3" placeholder="Contact" name="mobile" required>

            <label for="exampleFormControlInput1" class="form-label">Adresse</label>
            <input type="text" class="form-control mb-3" placeholder="Adresse" name="Address" required>

            <label for="exampleFormControlInput1" class="form-label">Salaire</label>
            <input type="number" class="form-control mb-3" placeholder="Salaire" name="salary" required>

            <label for="exampleFormControlInput1" class="form-label">Specialité</label>
            <input type="text" class="form-control mb-3" placeholder="Spécialité" name="speciality" required>

            <label for="exampleFormControlInput1" class="form-label">Permission</label>
            <select class="form-control" name="permission" required>
                <option value="Gérant chambre froide" selected>Gérant chambre froide</option>
                <option value="Super Admin">Super Admin</option>
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
        </div><a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a>
    </div>
    
    <?php include('scripts.php'); ?>
</body>

</html>
<?php 
}
?>