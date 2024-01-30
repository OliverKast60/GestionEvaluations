
<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['sid']==0)) {
  header('location:logout.php');
} else{

    if (isset($_POST['submit'])) {
        // code...

        $surveillant = $_POST['surveillant'];

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

$id_number=substr($surveillant, 0,3).$a.rand(10,1000).date('Y');


         $query=mysqli_query($con, "insert into `tblsurveillants`(`s_name`,`s_matricule`) values ('$surveillant','$id_number')");

          if ($query) {
                echo "<script>alert('Le surveillant a été ajouté.');</script>"; 
                echo "<script>window.location.href = 'surveillants.php'</script>";   
            $msg="";
                    }
          else
                    {
                echo "<script>alert('Une erreur s\'est produite, veillez réessayer.');</script>";    
                    }
    }
    if (isset($_GET['id'])) {
        // code...
         $query=mysqli_query($con, "delete from `tblsurveillants` where id ='".$_GET['id']."'");

          if ($query) {
                echo "<script>alert('Le surveillant a été supprimé.');</script>"; 
                echo "<script>window.location.href = 'surveillants.php'</script>";   
            $msg="";
                    }
          else
                    {
                echo "<script>alert('Une erreur s\'est produite, veillez réessayer.');</script>";    
                    }
    }

    if (isset($_POST['edit'])) {
        // code...
        $nom_faculte = $_POST['faculte'];
         $query=mysqli_query($con, "update `tblfaculties` set f_name = $nom_faculte where id ='".$_GET['id']."'");

          if ($query) {
                echo "<script>alert('La faculté a été modifiée.');</script>"; 
                echo "<script>window.location.href = 'faculties.php'</script>";   
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

<script src="js_libs/ajax.min.js"></script>

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
        <h4 class="text-primary"><i class="fas fa-users"></i> Surveillants </h4>
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
                                
                                <button type="button" class="btn btn-primary btn-sm mb-2" data-bs-toggle="modal" data-bs-target="#staticBackdrop"> <i class="fas fa-plus"></i> Ajouter un surveillant</button>
                                

</p>
                        </div>
                        <div class="card-body">
                            
                            <div class="table-responsive mt-2">
                                
                                <input class="form-control" id="myInput" type="text" placeholder="Rechercher un surveillant.." onkeyup="myFunction()">
  <br>
  <table class="table table-striped nowrap" style="font-weight: normal;font: size 11px;" id="myTable">
    <thead style="font-weight: normal;font: size 11px;">
        <tr>
                                            <th class="th-sm" style="font-weight: bold;font: size 10px;">#</th>
                                            <th class="th-sm" style="font-weight: bold;font: size 10px;">Nom du surveillant</th>
                                            <th class="th-sm" style="font-weight: bold;font: size 10px;">Matricule</th>
                                            <th class="th-sm" style="font-weight: bold;font: size 10px;">Action</th>
                                            
                                        </tr>
                                    </thead>
    <tbody >
         <?php $query=mysqli_query($con,"SELECT * FROM `tblsurveillants`");
                      $n=1;
                      while($row=mysqli_fetch_array($query))
                      {
                        ?>
      
                                        <tr>
                                            <td><?php echo $n; ?></td>
                                            <td><?php echo ($row['s_name']); ?></td>
                                            <td class="text-uppercase"><?php echo ($row['s_matricule']); ?></td>
                                            
                                            <td >
                                                <a href="edit_surveillant.php?edit=<?php echo $row['id']; ?>" title="Modifier"><button class="btn btn-success btn-sm" style="font-size:11px;"><i class="fas fa-edit"></i> Modifier</button></a>
                                                <a href="surveillants.php?id=<?php echo $row['id']; ?>" title="Supprimer" style="font-size:11px;"><button class="btn btn-danger btn-sm" style="font-size:11px;"><i class="fas fa-trash"></i> Supprimer</button></a>
                                            </td>
                                            
                                        </tr>
                        <?php 
                        $n++;
                    }
                    ?>
                        
    </tbody>
  </table>






  


<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" >
  <div class="modal-dialog" style="background-color:whitesmoke;">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel"><i class="fas fa-plus"></i> Ajouter un surveillant</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="post" enctype="multipart/form-data">
      <div class="modal-body">

            <label for="exampleFormControlInput1" class="form-label">Nom du surveillant</label>
            <input type="text" class="form-control mb-3" placeholder="Nom du surveillant" name="surveillant" required>
        
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