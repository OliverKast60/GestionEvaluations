
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
      $faculte=$_POST['faculte'];
      $departement=$_POST['departement'];
      $permission=$_POST['permission'];
      $password=md5("1234");
      $status='0';
  
  
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
  
      $userimage=$_FILES["userimage"]["name"];
      move_uploaded_file($_FILES["userimage"]["tmp_name"],"profil_images/".$_FILES["userimage"]["name"]);
  
      $query_insert=mysqli_query($con, "INSERT INTO `tblusers`(`username`, `password`, `name`, `lastname`, `matricule`, `userimage`, `permission`, `status`, `u_faculty`, `u_departement`) VALUES ('$username','$password','$name','$lastname','$id_number','$userimage','$permission','$status','$faculte','$departement')");
          if ($query_insert) 
          {
            echo '<script>alert("L\'utilisateur a été enregistré, veillez le debloquer pour que son compte soit actif.")</script>';
            echo "<script>window.location.href ='users_list.php'</script>";  
          $msg="";
          }
        
        else
          {
              echo "<script>alert('Une erreur s\'est produite, veillez réessayer.');</script>";    
          }
      
    }









    if (isset($_GET['id'])) {
        // code...
         $query=mysqli_query($con, "delete from `tblusers` where id ='".$_GET['id']."'");

          if ($query) {
                echo "<script>alert('L\'utilisateur a été supprimé.');</script>"; 
                echo "<script>window.location.href = 'users_list.php'</script>";   
            $msg="";
                    }
          else
                    {
                echo "<script>alert('Une erreur s\'est produite, veillez réessayer.');</script>";    
                    }
    }

    if (isset($_GET['lock'])) {
        // code...
         $query=mysqli_query($con, "update `tblusers` set status=0 where id ='".$_GET['lock']."'");

          if ($query) {
                echo "<script>alert('L\'utilisateur a été bloqué.');</script>"; 
                echo "<script>window.location.href = 'users_list.php'</script>";   
            $msg="";
                    }
          else
                    {
                echo "<script>alert('Une erreur s\'est produite, veillez réessayer.');</script>";    
                    }
    }

    if (isset($_GET['unlock'])) {
        // code...
         $query=mysqli_query($con, "update `tblusers` set status=1 where id ='".$_GET['unlock']."'");

          if ($query) {
                echo "<script>alert('L\'utilisateur a été debloqué.');</script>"; 
                echo "<script>window.location.href = 'users_list.php'</script>";   
            $msg="";
                    }
          else
                    {
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
        font-size:12px;
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
        <h4 class="text-primary"><i class="fas fa-user"></i> Utilisateurs </h4>
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
                                    if ($_SESSION['permission']=='Directeur académique') {
                                        // code...
                                    ?>
                                    <button type="button" class="btn btn-primary btn-sm mb-2" data-bs-toggle="modal" data-bs-target="#staticBackdrop"> <i class="fas fa-plus"></i> Ajouter un Utilisateur</button>
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
                                            <th class="th-sm">#</th>
                                            <th class="th-sm">Profil</th>
                                            <th class="th-sm">Nom</th>
                                            <th class="th-sm">Matricule</th>
                                            
                                            <th class="th-sm">Fonction</th>
                                            <th class="th-sm">Faculté</th>
                                            <th class="th-sm">Département</th>
                                            <th class="th-sm">Statut</th>
                                            
                                            <?php
  if ($_SESSION['permission']=='Directeur académique') {
    # code...
  ?>
                                            <th id="dont_print">Action</th>
  <?php
  }
  ?>
                                            
                                        </tr>
                                    </thead>
    <tbody id="myTable">
      <?php $query=mysqli_query($con,"select tblusers.*, tblusers.id from tblusers where 1");
                      $cnt=1;
                      while($row=mysqli_fetch_array($query))
                      {
                        ?>
                                        <tr>
                                            <td><?php echo htmlentities($cnt);?></td>
                                             <td>
                                                <img src="profil_images/<?php echo htmlentities($row['userimage']);?>" alt="" srcset="" id="profil_pic">
                                                
                                                </td>
                                             <td><?php echo htmlentities($row['name']." ".$row['lastname']);?></td>
                                             <td><?php echo htmlentities($row['matricule']);?></td>
                                             <td><?php echo htmlentities($row['permission']);?></td>
                                             <td><?php echo htmlentities($row['u_faculty']);?></td>
                                             <td><?php echo htmlentities($row['u_departement']);?></td>
                                             <td>
                                                <?php if($row['status']==0){
                                                    echo "Bloqué";
                                             }
                                             else{
                                                echo "Actif";
                                             }?>
                                             </td>
                                        
                                             <?php
  if ($_SESSION['permission']=='Directeur académique') {
    # code...
  ?>
                                             <td id="dont_print">
                                                
                                                 <a href="users_list.php?id=<?php echo $row['id']; ?>"><button class="btn btn-danger btn-sm mb" title="Supprimer"><i class="fas fa-trash"></i> </button></a>
                                                 <?php
                                                if($row['status']==1){
                                                    ?>
                                                    <a href="users_list.php?lock=<?php echo $row['id']; ?>"><button class="btn btn-dark btn-sm mb" title="bloquer"><i class="fas fa-lock"></i> </button></a>
                                                    <?php
                                                }
                                                else{
                                                    ?>
                                                    <a href="users_list.php?unlock=<?php echo $row['id']; ?>"><button class="btn btn-success btn-sm mb" title="debloquer"><i class="fas fa-unlock"></i> </button></a>
                                                    <?php
                                                }
                                                ?>
                                                 
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
        <h1 class="modal-title fs-5" id="staticBackdropLabel"><i class="fas fa-plus"></i> Ajouter un utilisateur</h1>
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

            <label label for="exampleFormControlInput1" class="form-label mt-3">Choisir une photo de profil</label>
            <input type="file" name="userimage" id="userimage" class="file-upload-default mb-3 form-control" required>

            <label for="exampleFormControlInput1" class="form-label">Fonction</label>
            <select class="form-control" name="permission" required>
                <option value="Chef de département">Chef de département</option>
                <option value="Directeur académique" selected>Directeur académique</option>
                <option value="Doyen de la faculté">Doyen de la faculté</option>
            </select>

            <label for="exampleFormControlInput1" class="form-label mt-2">Faculté</label>
            <select class="form-control" name="faculte">
            <option value=" " selected>Toutes les facultés <span class="" style="color:red;">(Directeur)</span></option>
            <?php $query=mysqli_query($con,"select tblfaculties.*, tblfaculties.id from tblfaculties where 1");
                      $cnt1=1;
                      while($row=mysqli_fetch_array($query))
                      {
                        ?>
                <option value="<?php echo $row['f_name']; ?>"><?php echo $row['f_name']; ?></option>
                <?php
                $cnt1++;
                      }
                ?>
            </select>
            
            <label for="exampleFormControlInput1" class="form-label mt-2">Département</label>
            <select class="form-control" name="departement">
                <option value=" " selected>Tous les départements <span class="" style="color:red;">(Doyen et Directeur)</span> </option>
                <?php $query=mysqli_query($con,"select distinct tblclasses.c_option from tblclasses where 1");
                      $cnt1=1;
                      while($row=mysqli_fetch_array($query))
                      {
                        ?>
                <option value="<?php echo $row['c_option']; ?>"><?php echo $row['c_option']; ?></option>
                <?php
                $cnt1++;
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
