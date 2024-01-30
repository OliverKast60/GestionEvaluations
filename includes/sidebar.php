 <style type="text/css">
   #grad{
    background-color: dodgerblue;
    background-image: linear-gradient(to right, red, orange,yellow,green,dodgerblue,indigo, violet);

   }
   #nav-links{
    border-radius:20px;
    color: white;
    font-weight: normal;
    font-size: 9px;
   }
 </style>


 <!-- Main Sidebar Container -->
 <aside class="main-sidebar sidebar-dark-primary elevation-4" style="font-family:sans-serif;box-shadow: 0 0 20px black;border: 0;background-color: black;position: fixed;border-radius: 20px;border-bottom-right-radius: 20px;font-size: 10px;">
  <!-- Sidebar -->
  <div class="sidebar" style="background-color:black;opacity: 0.9;">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <?php
      $eid=$_SESSION['sid'];
      $sql="SELECT * from tblusers   where id=:eid ";                                    
      $query = $dbh -> prepare($sql);
      $query-> bindParam(':eid', $eid, PDO::PARAM_STR);
      $query->execute();
      $results=$query->fetchAll(PDO::FETCH_OBJ);

      $cnt=1;
      if($query->rowCount() > 0)
      {
        foreach($results as $row)
        {    
          ?>
          <div class="image" style="margin-left: 30px;">
            <center>
              <div style="height: auto;padding: 3px;width: 60px;border-radius: 50%;" id="grad">
                <div style="background-color:black;height: auto;padding: 5px;width: 52px;border-radius: 52%;">
                  <img class="img-circle"
            src="staff_images/<?php echo htmlentities($row->userimage);?>" width="90px" height="90px" class="user-image"
            alt="User profile picture"style="border:solid transparent 1px;height: 40px;width: 40px;">
                </div>
                
              </div>
              
          </center>

            <div class="info">
            
            <center style="margin-left: 10px;"><a href="profile.php" class="d-block"><span style="font-size: 14px;font-weight: normal;font-family: sans-serif;color: white;"><?php echo ($row->name); ?> <?php echo ($row->lastname); ?> <i class="bi bi-app-indicator text-success"></i></span></a></center>
          </div>
          </div>
          
          <?php 
        }
      } ?>

    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false" style="padding-right:10px;padding-left: -10px;margin-left: -5px;">
        <li class="nav-item has-treeview menu-open">
          <a href="dashboard.php" class="nav-link active" id="nav-links">
            <i class="nav-icon fas fa-home"></i>
            <p style="font-size: 11px;">
              Accueil
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="info-salle.php" class="nav-link" id="nav-links">
            <i class="nav-icon fas fa-info"></i> 
            <p style="font-size: 11px;">
              Informations sur la salle
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="add-booking.php" class="nav-link" id="nav-links">
            <i class="nav-icon fas fa-plus"></i> 
            <p style="font-size: 11px;">
              Ajouter une réservation
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="add-booking-amende.php" class="nav-link" id="nav-links">
            <i class="nav-icon fas fa-plus"></i> 
            <p style="font-size: 11px;">
              Ajouter une amende
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="booking-list.php" class="nav-link" id="nav-links">
            <i class="nav-icon fas fa-stream"></i> 
            <p style="font-size: 11px;">
              Toutes les réservations
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="booking-on.php" class="nav-link" id="nav-links">
            <i class="nav-icon fas fa-spinner"></i> 
            <p style="font-size: 11px;">
              Réservations en cours
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="booking-past.php" class="nav-link" id="nav-links">
            <i class="nav-icon fas fa-backward"></i> 
            <p style="font-size: 11px;">
              Réservations passées
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="booking-canceled.php" class="nav-link" id="nav-links">
            <i class="nav-icon fas fa-window-close"></i> 
            <p style="font-size: 11px;">
              Réservations annulées
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="partenaires.php" class="nav-link" id="nav-links">
            <i class="nav-icon fas fa-handshake"></i> 
            <p style="font-size: 11px;">
              Partenaires
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="booking-out.php" class="nav-link" id="nav-links">
            <i class="nav-icon fas fa-sign-out-alt"></i> 
            <p style="font-size: 11px;">
              Sorties
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="repports.php" class="nav-link" id="nav-links">
            <i class="nav-icon fas fa-chart-pie"></i> 
            <p style="font-size: 11px;">
              Rapports réservations
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="repports-locations.php" class="nav-link" id="nav-links">
            <i class="nav-icon fas fa-chart-pie"></i>
            <p style="font-size: 11px;">
              Rapports locations
            </p>
          </a>
        </li>

        <!-- User Menu -->
        <hr>
        <li class="nav-item">
          <a href="userregister.php" class="nav-link" id="nav-links">
           <i class="nav-icon fas fa-user-plus"></i>
           <p style="font-size: 11px;">
            Ajouter utilisateur
          </p>
        </a>
      </li><!-- /.user menu -->
      <li class="nav-item">
        <a href="auditlog.php" class="nav-link" id="nav-links">
          <i class="nav-icon fas fa-history"></i>
          <p style="font-size: 11px;">
            Historique de connexion
          </p>
        </a>
      </li>
      <hr>
      <li class="nav-item">
        <a href="profile.php" class="nav-link" id="nav-links">
          <i class="nav-icon fas fa-user"></i>
          <p style="font-size: 11px;">
            Mon Compte
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="changepassword.php" class="nav-link" id="nav-links">
          <i class="nav-icon fas fa-cog"></i>
          <p style="font-size: 11px;">
            Paramètres
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="boots\bootstrap-5.2.2-dist\css\css\css\css\css.php" class="nav-link text-danger" style="font-weight: bolder;" id="nav-links">
          <i class="nav-icon fas fa-sign-out-alt"></i>
          <p style="font-size: 11px;">
            Déconnexion
          </p>
        </a>
      </li>
      <hr>
    </ul>
  </nav>
</div>
<!-- /.sidebar -->
</aside>
