<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['sid'] == 0)) {
  header('location:logout.php');
} else {

  if (isset($_POST['submit_old'])) {
    $nom = $_POST['nom'];
    $address = $_POST['address'];
    $contact = $_POST['contact'];
    $classe = $_POST['classe'];
    $date_naissance = $_POST['date_naissance'];
    $nationalite = $_POST['nationalite'];
    $sex = $_POST['sex'];
    $etat_civil = $_POST['etat_civil'];

    $id_number = $_POST['matricule'];

    $userimage = $_FILES["userimage"]["name"];
    move_uploaded_file($_FILES["userimage"]["tmp_name"], "students_profil/" . $_FILES["userimage"]["name"]);

    $query_insert = mysqli_query($con, "INSERT INTO `tblstudents`(`s_matricule`, `s_name`, `s_userimage`, `s_sex`, `s_civil`, `s_date_naissance`, `s_nationalite`, `s_contact`, `s_classe`, `s_address`) VALUES ('$id_number','$nom','$userimage','$sex','$etat_civil','$date_naissance','$nationalite','$contact','$classe','$address')");
    if ($query_insert) {
      echo '<script>alert("L\'étudiant a été enregistré")</script>';
      echo "<script>window.location.href ='students.php'</script>";
      $msg = "";
    } else {
      echo "<script>alert('Une erreur s\'est produite, veillez réessayer.');</script>";
    }
  }

  // old students

  if (isset($_POST['submit'])) {
    $nom = $_POST['nom'];
    $address = $_POST['address'];
    $contact = $_POST['contact'];
    $classe = $_POST['classe'];
    $date_naissance = $_POST['date_naissance'];
    $nationalite = $_POST['nationalite'];
    $sex = $_POST['sex'];
    $etat_civil = $_POST['etat_civil'];

    function getMatricule($annee_actuelle)
    {
      $starting = "STD-AA-";
      $nombre = 9;
      if ($annee_actuelle > 2021) {
        // code...
        $nombre = ($annee_actuelle - 2021) + 8;

        return $matric = $starting . "0" . $nombre . "-" . rand(1, 1000) . "-" . $annee_actuelle;
      }
    }

    $mon_annee = date('Y');

    $id_number = getMatricule($mon_annee);

    $userimage = $_FILES["userimage"]["name"];
    move_uploaded_file($_FILES["userimage"]["tmp_name"], "students_profil/" . $_FILES["userimage"]["name"]);

    $query_insert = mysqli_query($con, "INSERT INTO `tblstudents`(`s_matricule`, `s_name`, `s_userimage`, `s_sex`, `s_civil`, `s_date_naissance`, `s_nationalite`, `s_contact`, `s_classe`, `s_address`) VALUES ('$id_number','$nom','$userimage','$sex','$etat_civil','$date_naissance','$nationalite','$contact','$classe','$address')");
    if ($query_insert) {
      echo '<script>alert("L\'étudiant a été enregistré")</script>';
      echo "<script>window.location.href ='students.php'</script>";
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

  if (isset($_GET['lock'])) {
    // code...
    $query = mysqli_query($con, "update `tblstudents` student_lock=1 where id ='" . $_GET['lock'] . "'");

    if ($query) {
      echo "<script>alert('L\'étudiant a été bloqué.');</script>";
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
      <h4 class="text-primary"><i class="fas fa-user-graduate"></i> Etudiants </h4>
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

                            <button type="button" class="btn btn-primary btn-sm mb-2" data-bs-toggle="modal" data-bs-target="#staticBackdrop"> <i class="fas fa-plus"></i> Nouvel étudiant</button>

                            <button type="button" class="btn btn-primary btn-sm mb-2" data-bs-toggle="modal" data-bs-target="#staticBackdrop1"> <i class="fas fa-plus"></i> Ancien étudiant</button>



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
                                ?>
                                <?php
                                $mystudents = $my_depart['u_faculty'];
                                //echo $my_depart['u_faculty']." ".$my_depart['u_departement'];
                                if ($mystudents == "") {
                                  // code...
                                  $query = mysqli_query($con, "SELECT tblstudents.*,tblstudents.id as a, tblclasses.*, tblfaculties.* FROM `tblstudents`, tblclasses,tblfaculties where tblstudents.s_classe = tblclasses.id and tblclasses.c_faculty=tblfaculties.id order by tblstudents.s_name asc");
                                } else {
                                  $query = mysqli_query($con, "SELECT tblstudents.*,tblstudents.id as a, tblclasses.*, tblfaculties.* FROM `tblstudents`, tblclasses,tblfaculties where tblstudents.s_classe = tblclasses.id and tblclasses.c_faculty=tblfaculties.id and (tblfaculties.f_name like '$mystudents') order by tblstudents.s_name asc");
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
                                      <a href="edit_student.php?edit=<?php echo $row['a']; ?>" title="Modifier"><button class="btn btn-success btn-sm mb-2" style="font-size:11px;"><i class="fas fa-edit"></i> Modifier</button></a>

                                      <a href="students.php?id=<?php echo $row['a']; ?>" title="Supprimer" style="font-size:11px;"><button class="btn btn-danger btn-sm mb-2" style="font-size:11px;"><i class="fas fa-trash"></i> Supprimer</button></a>
                                      <?php
                                      if ($row['student_status'] == 0) {
                                        // code...
                                      ?>
                                        <a href="students.php?lock=<?php echo $row['a']; ?>" title="Bloquer l'etudiant" style="font-size:11px;"><button class="btn btn-primary btn-sm mb-2" style="font-size:11px;"><i class="fas fa-lock"></i> Bloquer</button></a>

                                        <a href="student_card.php?id=<?php echo $row['a']; ?>" title="Imprimer une carte d'étudiant" style="font-size:11px;"><button class="btn btn-dark btn-sm mb-2" style="font-size:11px;"><i class="fas fa-id-card-alt"></i> carte d'étudiant</button></a>
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
                                    <h1 class="modal-title fs-5" id="staticBackdropLabel"><i class="fas fa-plus"></i> Nouvel étudiant</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <form method="post" enctype="multipart/form-data">
                                    <div class="modal-body">
                                      <label label for="exampleFormControlInput1" class="form-label mt-3">Choisir une photo de profil</label>
                                      <input type="file" name="userimage" id="userimage" class="file-upload-default mb-3 form-control" required>

                                      <label for="exampleFormControlInput1" class="form-label">Nom de l'etudiant</label>
                                      <input type="text" class="form-control mb-3" placeholder="Nom complet" name="nom" required>

                                      <label for="exampleFormControlInput1" class="form-label mt-2">Genre</label>
                                      <select class="form-control" name="sex" required>
                                        <option value="Masculin" selected>Masculin</option>
                                        <option value="Féminin">Féminin</option>
                                      </select>

                                      <label for="exampleFormControlInput1" class="form-label mt-2">Etat civil</label>
                                      <select class="form-control" name="etat_civil" required>
                                        <option value="Marié">Marié</option>
                                        <option value="Célibataire" selected="">Célibataire</option>
                                      </select>

                                      <label for="exampleFormControlInput1" class="form-label mt-2">Date de naissance</label>
                                      <input type="date" class="form-control mb-3" placeholder="Date de naissance" name="date_naissance" required>

                                      <label for="exampleFormControlInput1" class="form-label mt-2">Nationalité</label>
                                      <select class="form-control" name="nationalite">
                                        <option value="AFG">Afghane (Afghanistan)</option>
                                        <option value="ALB">Albanaise (Albania)</option>
                                        <option value="DZA">Algérienne (Algeria)</option>
                                        <option value="DEU">Allemande (Allemagne)</option>
                                        <option value="USA">Americaine (États-Unis)</option>
                                        <option value="AND">Andorrane (Andorre)</option>
                                        <option value="AGO">Angolaise (Angola)</option>
                                        <option value="ATG">Antiguaise-et-Barbudienne (Antigua-et-Barbuda)</option>
                                        <option value="ARG">Argentine (Argentine)</option>
                                        <option value="ARM">Armenienne (Arménie)</option>
                                        <option value="AUS">Australienne (Australie)</option>
                                        <option value="AUT">Autrichienne (Autriche)</option>
                                        <option value="AZE">Azerbaïdjanaise (Azerbaïdjan)</option>
                                        <option value="BHS">Bahamienne (Bahamas)</option>
                                        <option value="BHR">Bahreinienne (Bahreïn)</option>
                                        <option value="BGD">Bangladaise (Bangladesh)</option>
                                        <option value="BRB">Barbadienne (Barbade)</option>
                                        <option value="BEL">Belge (Belgique)</option>
                                        <option value="BLZ">Belizienne (Belize)</option>
                                        <option value="BEN">Béninoise (Bénin)</option>
                                        <option value="BTN">Bhoutanaise (Bhoutan)</option>
                                        <option value="BLR">Biélorusse (Biélorussie)</option>
                                        <option value="MMR">Birmane (Birmanie)</option>
                                        <option value="GNB">Bissau-Guinéenne (Guinée-Bissau)</option>
                                        <option value="BOL">Bolivienne (Bolivie)</option>
                                        <option value="BIH">Bosnienne (Bosnie-Herzégovine)</option>
                                        <option value="BWA">Botswanaise (Botswana)</option>
                                        <option value="BRA">Brésilienne (Brésil)</option>
                                        <option value="GBR">Britannique (Royaume-Uni)</option>
                                        <option value="BRN">Brunéienne (Brunéi)</option>
                                        <option value="BGR">Bulgare (Bulgarie)</option>
                                        <option value="BFA">Burkinabée (Burkina)</option>
                                        <option value="BDI">Burundaise (Burundi)</option>
                                        <option value="KHM">Cambodgienne (Cambodge)</option>
                                        <option value="CMR">Camerounaise (Cameroun)</option>
                                        <option value="CAN">Canadienne (Canada)</option>
                                        <option value="CPV">Cap-verdienne (Cap-Vert)</option>
                                        <option value="CAF">Centrafricaine (Centrafrique)</option>
                                        <option value="CHL">Chilienne (Chili)</option>
                                        <option value="CHN">Chinoise (Chine)</option>
                                        <option value="CYP">Chypriote (Chypre)</option>
                                        <option value="COL">Colombienne (Colombie)</option>
                                        <option value="COM">Comorienne (Comores)</option>
                                        <option value="COG">Congolaise (Congo-Brazzaville)</option>
                                        <option value="COD" selected>Congolaise (Congo-Kinshasa)</option>
                                        <option value="COK">Cookienne (Îles Cook)</option>
                                        <option value="CRI">Costaricaine (Costa Rica)</option>
                                        <option value="HRV">Croate (Croatie)</option>
                                        <option value="CUB">Cubaine (Cuba)</option>
                                        <option value="DNK">Danoise (Danemark)</option>
                                        <option value="DJI">Djiboutienne (Djibouti)</option>
                                        <option value="DOM">Dominicaine (République dominicaine)</option>
                                        <option value="DMA">Dominiquaise (Dominique)</option>
                                        <option value="EGY">Égyptienne (Égypte)</option>
                                        <option value="ARE">Émirienne (Émirats arabes unis)</option>
                                        <option value="GNQ">Équato-guineenne (Guinée équatoriale)</option>
                                        <option value="ECU">Équatorienne (Équateur)</option>
                                        <option value="ERI">Érythréenne (Érythrée)</option>
                                        <option value="ESP">Espagnole (Espagne)</option>
                                        <option value="TLS">Est-timoraise (Timor-Leste)</option>
                                        <option value="EST">Estonienne (Estonie)</option>
                                        <option value="ETH">Éthiopienne (Éthiopie)</option>
                                        <option value="FJI">Fidjienne (Fidji)</option>
                                        <option value="FIN">Finlandaise (Finlande)</option>
                                        <option value="FRA">Française (France)</option>
                                        <option value="GAB">Gabonaise (Gabon)</option>
                                        <option value="GMB">Gambienne (Gambie)</option>
                                        <option value="GEO">Georgienne (Géorgie)</option>
                                        <option value="GHA">Ghanéenne (Ghana)</option>
                                        <option value="GRD">Grenadienne (Grenade)</option>
                                        <option value="GTM">Guatémaltèque (Guatemala)</option>
                                        <option value="GIN">Guinéenne (Guinée)</option>
                                        <option value="GUY">Guyanienne (Guyana)</option>
                                        <option value="HTI">Haïtienne (Haïti)</option>
                                        <option value="GRC">Hellénique (Grèce)</option>
                                        <option value="HND">Hondurienne (Honduras)</option>
                                        <option value="HUN">Hongroise (Hongrie)</option>
                                        <option value="IND">Indienne (Inde)</option>
                                        <option value="IDN">Indonésienne (Indonésie)</option>
                                        <option value="IRQ">Irakienne (Iraq)</option>
                                        <option value="IRN">Iranienne (Iran)</option>
                                        <option value="IRL">Irlandaise (Irlande)</option>
                                        <option value="ISL">Islandaise (Islande)</option>
                                        <option value="ISR">Israélienne (Israël)</option>
                                        <option value="ITA">Italienne (Italie)</option>
                                        <option value="CIV">Ivoirienne (Côte d'Ivoire)</option>
                                        <option value="JAM">Jamaïcaine (Jamaïque)</option>
                                        <option value="JPN">Japonaise (Japon)</option>
                                        <option value="JOR">Jordanienne (Jordanie)</option>
                                        <option value="KAZ">Kazakhstanaise (Kazakhstan)</option>
                                        <option value="KEN">Kenyane (Kenya)</option>
                                        <option value="KGZ">Kirghize (Kirghizistan)</option>
                                        <option value="KIR">Kiribatienne (Kiribati)</option>
                                        <option value="KNA">Kittitienne et Névicienne (Saint-Christophe-et-Niévès)</option>
                                        <option value="KWT">Koweïtienne (Koweït)</option>
                                        <option value="LAO">Laotienne (Laos)</option>
                                        <option value="LSO">Lesothane (Lesotho)</option>
                                        <option value="LVA">Lettone (Lettonie)</option>
                                        <option value="LBN">Libanaise (Liban)</option>
                                        <option value="LBR">Libérienne (Libéria)</option>
                                        <option value="LBY">Libyenne (Libye)</option>
                                        <option value="LIE">Liechtensteinoise (Liechtenstein)</option>
                                        <option value="LTU">Lituanienne (Lituanie)</option>
                                        <option value="LUX">Luxembourgeoise (Luxembourg)</option>
                                        <option value="MKD">Macédonienne (Macédoine)</option>
                                        <option value="MYS">Malaisienne (Malaisie)</option>
                                        <option value="MWI">Malawienne (Malawi)</option>
                                        <option value="MDV">Maldivienne (Maldives)</option>
                                        <option value="MDG">Malgache (Madagascar)</option>
                                        <option value="MLI">Maliennes (Mali)</option>
                                        <option value="MLT">Maltaise (Malte)</option>
                                        <option value="MAR">Marocaine (Maroc)</option>
                                        <option value="MHL">Marshallaise (Îles Marshall)</option>
                                        <option value="MUS">Mauricienne (Maurice)</option>
                                        <option value="MRT">Mauritanienne (Mauritanie)</option>
                                        <option value="MEX">Mexicaine (Mexique)</option>
                                        <option value="FSM">Micronésienne (Micronésie)</option>
                                        <option value="MDA">Moldave (Moldovie)</option>
                                        <option value="MCO">Monegasque (Monaco)</option>
                                        <option value="MNG">Mongole (Mongolie)</option>
                                        <option value="MNE">Monténégrine (Monténégro)</option>
                                        <option value="MOZ">Mozambicaine (Mozambique)</option>
                                        <option value="NAM">Namibienne (Namibie)</option>
                                        <option value="NRU">Nauruane (Nauru)</option>
                                        <option value="NLD">Néerlandaise (Pays-Bas)</option>
                                        <option value="NZL">Néo-Zélandaise (Nouvelle-Zélande)</option>
                                        <option value="NPL">Népalaise (Népal)</option>
                                        <option value="NIC">Nicaraguayenne (Nicaragua)</option>
                                        <option value="NGA">Nigériane (Nigéria)</option>
                                        <option value="NER">Nigérienne (Niger)</option>
                                        <option value="NIU">Niuéenne (Niue)</option>
                                        <option value="PRK">Nord-coréenne (Corée du Nord)</option>
                                        <option value="NOR">Norvégienne (Norvège)</option>
                                        <option value="OMN">Omanaise (Oman)</option>
                                        <option value="UGA">Ougandaise (Ouganda)</option>
                                        <option value="UZB">Ouzbéke (Ouzbékistan)</option>
                                        <option value="PAK">Pakistanaise (Pakistan)</option>
                                        <option value="PLW">Palaosienne (Palaos)</option>
                                        <option value="PSE">Palestinienne (Palestine)</option>
                                        <option value="PAN">Panaméenne (Panama)</option>
                                        <option value="PNG">Papouane-Néo-Guinéenne (Papouasie-Nouvelle-Guinée)</option>
                                        <option value="PRY">Paraguayenne (Paraguay)</option>
                                        <option value="PER">Péruvienne (Pérou)</option>
                                        <option value="PHL">Philippine (Philippines)</option>
                                        <option value="POL">Polonaise (Pologne)</option>
                                        <option value="PRT">Portugaise (Portugal)</option>
                                        <option value="QAT">Qatarienne (Qatar)</option>
                                        <option value="ROU">Roumaine (Roumanie)</option>
                                        <option value="RUS">Russe (Russie)</option>
                                        <option value="RWA">Rwandaise (Rwanda)</option>
                                        <option value="LCA">Saint-Lucienne (Sainte-Lucie)</option>
                                        <option value="SMR">Saint-Marinaise (Saint-Marin)</option>
                                        <option value="VCT">Saint-Vincentaise et Grenadine (Saint-Vincent-et-les Grenadines)</option>
                                        <option value="SLB">Salomonaise (Îles Salomon)</option>
                                        <option value="SLV">Salvadorienne (Salvador)</option>
                                        <option value="WSM">Samoane (Samoa)</option>
                                        <option value="STP">Santoméenne (Sao Tomé-et-Principe)</option>
                                        <option value="SAU">Saoudienne (Arabie saoudite)</option>
                                        <option value="SEN">Sénégalaise (Sénégal)</option>
                                        <option value="SRB">Serbe (Serbie)</option>
                                        <option value="SYC">Seychelloise (Seychelles)</option>
                                        <option value="SLE">Sierra-Léonaise (Sierra Leone)</option>
                                        <option value="SGP">Singapourienne (Singapour)</option>
                                        <option value="SVK">Slovaque (Slovaquie)</option>
                                        <option value="SVN">Slovène (Slovénie)</option>
                                        <option value="SOM">Somalienne (Somalie)</option>
                                        <option value="SDN">Soudanaise (Soudan)</option>
                                        <option value="LKA">Sri-Lankaise (Sri Lanka)</option>
                                        <option value="ZAF">Sud-Africaine (Afrique du Sud)</option>
                                        <option value="KOR">Sud-Coréenne (Corée du Sud)</option>
                                        <option value="SSD">Sud-Soudanaise (Soudan du Sud)</option>
                                        <option value="SWE">Suédoise (Suède)</option>
                                        <option value="CHE">Suisse (Suisse)</option>
                                        <option value="SUR">Surinamaise (Suriname)</option>
                                        <option value="SWZ">Swazie (Swaziland)</option>
                                        <option value="SYR">Syrienne (Syrie)</option>
                                        <option value="TJK">Tadjike (Tadjikistan)</option>
                                        <option value="TZA">Tanzanienne (Tanzanie)</option>
                                        <option value="TCD">Tchadienne (Tchad)</option>
                                        <option value="CZE">Tchèque (Tchéquie)</option>
                                        <option value="THA">Thaïlandaise (Thaïlande)</option>
                                        <option value="TGO">Togolaise (Togo)</option>
                                        <option value="TON">Tonguienne (Tonga)</option>
                                        <option value="TTO">Trinidadienne (Trinité-et-Tobago)</option>
                                        <option value="TUN">Tunisienne (Tunisie)</option>
                                        <option value="TKM">Turkmène (Turkménistan)</option>
                                        <option value="TUR">Turque (Turquie)</option>
                                        <option value="TUV">Tuvaluane (Tuvalu)</option>
                                        <option value="UKR">Ukrainienne (Ukraine)</option>
                                        <option value="URY">Uruguayenne (Uruguay)</option>
                                        <option value="VUT">Vanuatuane (Vanuatu)</option>
                                        <option value="VAT">Vaticane (Vatican)</option>
                                        <option value="VEN">Vénézuélienne (Venezuela)</option>
                                        <option value="VNM">Vietnamienne (Viêt Nam)</option>
                                        <option value="YEM">Yéménite (Yémen)</option>
                                        <option value="ZMB">Zambienne (Zambie)</option>
                                        <option value="ZWE">Zimbabwéenne (Zimbabwe)</option>
                                      </select>

                                      <label for="exampleFormControlInput1" class="form-label mt-2">Adresse de résidence</label>
                                      <input type="text" class="form-control mb-3" placeholder="Adresse de résidence" name="address" required>

                                      <label for="exampleFormControlInput1" class="form-label mt-2">Contact (email)</label>
                                      <input type="mail" class="form-control mb-3" placeholder="Email" name="contact" required>

                                      <label for="exampleFormControlInput1" class="form-label mt-2">Classe</label>
                                      <select class="form-control" name="classe" required>
                                        <?php
                                        $mystudents = $my_depart['u_faculty'];
                                        $query = mysqli_query($con, "SELECT tblclasses.*, tblclasses.id as k, tblfaculties.* FROM `tblclasses`, tblfaculties where tblfaculties.id = tblclasses.c_faculty");
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



                            <!-- old students -->


                            <!-- Modal -->
                            <div class="modal fade" id="staticBackdrop1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                              <div class="modal-dialog" style="background-color:whitesmoke;">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="staticBackdropLabel"><i class="fas fa-plus"></i> Ancien étudiant</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <form method="post" enctype="multipart/form-data">
                                    <div class="modal-body">
                                      <label label for="exampleFormControlInput1" class="form-label mt-3">Choisir une photo de profil</label>
                                      <input type="file" name="userimage" id="userimage" class="file-upload-default mb-3 form-control" required>

                                      <label for="exampleFormControlInput1" class="form-label">Nom de l'etudiant</label>
                                      <input type="text" class="form-control mb-3" placeholder="Nom complet" name="nom" required>

                                      <label for="exampleFormControlInput1" class="form-label">Matricule de l'etudiant</label>
                                      <input type="text" class="form-control mb-3" placeholder="Nom complet" name="matricule" value="STD-AA-" required>

                                      <label for="exampleFormControlInput1" class="form-label mt-2">Genre</label>
                                      <select class="form-control" name="sex" required>
                                        <option value="Masculin" selected>Masculin</option>
                                        <option value="Féminin">Féminin</option>
                                      </select>

                                      <label for="exampleFormControlInput1" class="form-label mt-2">Etat civil</label>
                                      <select class="form-control" name="etat_civil" required>
                                        <option value="Marié">Marié</option>
                                        <option value="Célibataire" selected="">Célibataire</option>
                                      </select>

                                      <label for="exampleFormControlInput1" class="form-label mt-2">Date de naissance</label>
                                      <input type="date" class="form-control mb-3" placeholder="Date de naissance" name="date_naissance" required>

                                      <label for="exampleFormControlInput1" class="form-label mt-2">Nationalité</label>
                                      <select class="form-control" name="nationalite">
                                        <option value="AFG">Afghane (Afghanistan)</option>
                                        <option value="ALB">Albanaise (Albanie)</option>
                                        <option value="DZA">Algérienne (Algérie)</option>
                                        <option value="DEU">Allemande (Allemagne)</option>
                                        <option value="USA">Americaine (États-Unis)</option>
                                        <option value="AND">Andorrane (Andorre)</option>
                                        <option value="AGO">Angolaise (Angola)</option>
                                        <option value="ATG">Antiguaise-et-Barbudienne (Antigua-et-Barbuda)</option>
                                        <option value="ARG">Argentine (Argentine)</option>
                                        <option value="ARM">Armenienne (Arménie)</option>
                                        <option value="AUS">Australienne (Australie)</option>
                                        <option value="AUT">Autrichienne (Autriche)</option>
                                        <option value="AZE">Azerbaïdjanaise (Azerbaïdjan)</option>
                                        <option value="BHS">Bahamienne (Bahamas)</option>
                                        <option value="BHR">Bahreinienne (Bahreïn)</option>
                                        <option value="BGD">Bangladaise (Bangladesh)</option>
                                        <option value="BRB">Barbadienne (Barbade)</option>
                                        <option value="BEL">Belge (Belgique)</option>
                                        <option value="BLZ">Belizienne (Belize)</option>
                                        <option value="BEN">Béninoise (Bénin)</option>
                                        <option value="BTN">Bhoutanaise (Bhoutan)</option>
                                        <option value="BLR">Biélorusse (Biélorussie)</option>
                                        <option value="MMR">Birmane (Birmanie)</option>
                                        <option value="GNB">Bissau-Guinéenne (Guinée-Bissau)</option>
                                        <option value="BOL">Bolivienne (Bolivie)</option>
                                        <option value="BIH">Bosnienne (Bosnie-Herzégovine)</option>
                                        <option value="BWA">Botswanaise (Botswana)</option>
                                        <option value="BRA">Brésilienne (Brésil)</option>
                                        <option value="GBR">Britannique (Royaume-Uni)</option>
                                        <option value="BRN">Brunéienne (Brunéi)</option>
                                        <option value="BGR">Bulgare (Bulgarie)</option>
                                        <option value="BFA">Burkinabée (Burkina)</option>
                                        <option value="BDI">Burundaise (Burundi)</option>
                                        <option value="KHM">Cambodgienne (Cambodge)</option>
                                        <option value="CMR">Camerounaise (Cameroun)</option>
                                        <option value="CAN">Canadienne (Canada)</option>
                                        <option value="CPV">Cap-verdienne (Cap-Vert)</option>
                                        <option value="CAF">Centrafricaine (Centrafrique)</option>
                                        <option value="CHL">Chilienne (Chili)</option>
                                        <option value="CHN">Chinoise (Chine)</option>
                                        <option value="CYP">Chypriote (Chypre)</option>
                                        <option value="COL">Colombienne (Colombie)</option>
                                        <option value="COM">Comorienne (Comores)</option>
                                        <option value="COG">Congolaise (Congo-Brazzaville)</option>
                                        <option value="COD" selected>Congolaise (Congo-Kinshasa)</option>
                                        <option value="COK">Cookienne (Îles Cook)</option>
                                        <option value="CRI">Costaricaine (Costa Rica)</option>
                                        <option value="HRV">Croate (Croatie)</option>
                                        <option value="CUB">Cubaine (Cuba)</option>
                                        <option value="DNK">Danoise (Danemark)</option>
                                        <option value="DJI">Djiboutienne (Djibouti)</option>
                                        <option value="DOM">Dominicaine (République dominicaine)</option>
                                        <option value="DMA">Dominiquaise (Dominique)</option>
                                        <option value="EGY">Égyptienne (Égypte)</option>
                                        <option value="ARE">Émirienne (Émirats arabes unis)</option>
                                        <option value="GNQ">Équato-guineenne (Guinée équatoriale)</option>
                                        <option value="ECU">Équatorienne (Équateur)</option>
                                        <option value="ERI">Érythréenne (Érythrée)</option>
                                        <option value="ESP">Espagnole (Espagne)</option>
                                        <option value="TLS">Est-timoraise (Timor-Leste)</option>
                                        <option value="EST">Estonienne (Estonie)</option>
                                        <option value="ETH">Éthiopienne (Éthiopie)</option>
                                        <option value="FJI">Fidjienne (Fidji)</option>
                                        <option value="FIN">Finlandaise (Finlande)</option>
                                        <option value="FRA">Française (France)</option>
                                        <option value="GAB">Gabonaise (Gabon)</option>
                                        <option value="GMB">Gambienne (Gambie)</option>
                                        <option value="GEO">Georgienne (Géorgie)</option>
                                        <option value="GHA">Ghanéenne (Ghana)</option>
                                        <option value="GRD">Grenadienne (Grenade)</option>
                                        <option value="GTM">Guatémaltèque (Guatemala)</option>
                                        <option value="GIN">Guinéenne (Guinée)</option>
                                        <option value="GUY">Guyanienne (Guyana)</option>
                                        <option value="HTI">Haïtienne (Haïti)</option>
                                        <option value="GRC">Hellénique (Grèce)</option>
                                        <option value="HND">Hondurienne (Honduras)</option>
                                        <option value="HUN">Hongroise (Hongrie)</option>
                                        <option value="IND">Indienne (Inde)</option>
                                        <option value="IDN">Indonésienne (Indonésie)</option>
                                        <option value="IRQ">Irakienne (Iraq)</option>
                                        <option value="IRN">Iranienne (Iran)</option>
                                        <option value="IRL">Irlandaise (Irlande)</option>
                                        <option value="ISL">Islandaise (Islande)</option>
                                        <option value="ISR">Israélienne (Israël)</option>
                                        <option value="ITA">Italienne (Italie)</option>
                                        <option value="CIV">Ivoirienne (Côte d'Ivoire)</option>
                                        <option value="JAM">Jamaïcaine (Jamaïque)</option>
                                        <option value="JPN">Japonaise (Japon)</option>
                                        <option value="JOR">Jordanienne (Jordanie)</option>
                                        <option value="KAZ">Kazakhstanaise (Kazakhstan)</option>
                                        <option value="KEN">Kenyane (Kenya)</option>
                                        <option value="KGZ">Kirghize (Kirghizistan)</option>
                                        <option value="KIR">Kiribatienne (Kiribati)</option>
                                        <option value="KNA">Kittitienne et Névicienne (Saint-Christophe-et-Niévès)</option>
                                        <option value="KWT">Koweïtienne (Koweït)</option>
                                        <option value="LAO">Laotienne (Laos)</option>
                                        <option value="LSO">Lesothane (Lesotho)</option>
                                        <option value="LVA">Lettone (Lettonie)</option>
                                        <option value="LBN">Libanaise (Liban)</option>
                                        <option value="LBR">Libérienne (Libéria)</option>
                                        <option value="LBY">Libyenne (Libye)</option>
                                        <option value="LIE">Liechtensteinoise (Liechtenstein)</option>
                                        <option value="LTU">Lituanienne (Lituanie)</option>
                                        <option value="LUX">Luxembourgeoise (Luxembourg)</option>
                                        <option value="MKD">Macédonienne (Macédoine)</option>
                                        <option value="MYS">Malaisienne (Malaisie)</option>
                                        <option value="MWI">Malawienne (Malawi)</option>
                                        <option value="MDV">Maldivienne (Maldives)</option>
                                        <option value="MDG">Malgache (Madagascar)</option>
                                        <option value="MLI">Maliennes (Mali)</option>
                                        <option value="MLT">Maltaise (Malte)</option>
                                        <option value="MAR">Marocaine (Maroc)</option>
                                        <option value="MHL">Marshallaise (Îles Marshall)</option>
                                        <option value="MUS">Mauricienne (Maurice)</option>
                                        <option value="MRT">Mauritanienne (Mauritanie)</option>
                                        <option value="MEX">Mexicaine (Mexique)</option>
                                        <option value="FSM">Micronésienne (Micronésie)</option>
                                        <option value="MDA">Moldave (Moldovie)</option>
                                        <option value="MCO">Monegasque (Monaco)</option>
                                        <option value="MNG">Mongole (Mongolie)</option>
                                        <option value="MNE">Monténégrine (Monténégro)</option>
                                        <option value="MOZ">Mozambicaine (Mozambique)</option>
                                        <option value="NAM">Namibienne (Namibie)</option>
                                        <option value="NRU">Nauruane (Nauru)</option>
                                        <option value="NLD">Néerlandaise (Pays-Bas)</option>
                                        <option value="NZL">Néo-Zélandaise (Nouvelle-Zélande)</option>
                                        <option value="NPL">Népalaise (Népal)</option>
                                        <option value="NIC">Nicaraguayenne (Nicaragua)</option>
                                        <option value="NGA">Nigériane (Nigéria)</option>
                                        <option value="NER">Nigérienne (Niger)</option>
                                        <option value="NIU">Niuéenne (Niue)</option>
                                        <option value="PRK">Nord-coréenne (Corée du Nord)</option>
                                        <option value="NOR">Norvégienne (Norvège)</option>
                                        <option value="OMN">Omanaise (Oman)</option>
                                        <option value="UGA">Ougandaise (Ouganda)</option>
                                        <option value="UZB">Ouzbéke (Ouzbékistan)</option>
                                        <option value="PAK">Pakistanaise (Pakistan)</option>
                                        <option value="PLW">Palaosienne (Palaos)</option>
                                        <option value="PSE">Palestinienne (Palestine)</option>
                                        <option value="PAN">Panaméenne (Panama)</option>
                                        <option value="PNG">Papouane-Néo-Guinéenne (Papouasie-Nouvelle-Guinée)</option>
                                        <option value="PRY">Paraguayenne (Paraguay)</option>
                                        <option value="PER">Péruvienne (Pérou)</option>
                                        <option value="PHL">Philippine (Philippines)</option>
                                        <option value="POL">Polonaise (Pologne)</option>
                                        <option value="PRT">Portugaise (Portugal)</option>
                                        <option value="QAT">Qatarienne (Qatar)</option>
                                        <option value="ROU">Roumaine (Roumanie)</option>
                                        <option value="RUS">Russe (Russie)</option>
                                        <option value="RWA">Rwandaise (Rwanda)</option>
                                        <option value="LCA">Saint-Lucienne (Sainte-Lucie)</option>
                                        <option value="SMR">Saint-Marinaise (Saint-Marin)</option>
                                        <option value="VCT">Saint-Vincentaise et Grenadine (Saint-Vincent-et-les Grenadines)</option>
                                        <option value="SLB">Salomonaise (Îles Salomon)</option>
                                        <option value="SLV">Salvadorienne (Salvador)</option>
                                        <option value="WSM">Samoane (Samoa)</option>
                                        <option value="STP">Santoméenne (Sao Tomé-et-Principe)</option>
                                        <option value="SAU">Saoudienne (Arabie saoudite)</option>
                                        <option value="SEN">Sénégalaise (Sénégal)</option>
                                        <option value="SRB">Serbe (Serbie)</option>
                                        <option value="SYC">Seychelloise (Seychelles)</option>
                                        <option value="SLE">Sierra-Léonaise (Sierra Leone)</option>
                                        <option value="SGP">Singapourienne (Singapour)</option>
                                        <option value="SVK">Slovaque (Slovaquie)</option>
                                        <option value="SVN">Slovène (Slovénie)</option>
                                        <option value="SOM">Somalienne (Somalie)</option>
                                        <option value="SDN">Soudanaise (Soudan)</option>
                                        <option value="LKA">Sri-Lankaise (Sri Lanka)</option>
                                        <option value="ZAF">Sud-Africaine (Afrique du Sud)</option>
                                        <option value="KOR">Sud-Coréenne (Corée du Sud)</option>
                                        <option value="SSD">Sud-Soudanaise (Soudan du Sud)</option>
                                        <option value="SWE">Suédoise (Suède)</option>
                                        <option value="CHE">Suisse (Suisse)</option>
                                        <option value="SUR">Surinamaise (Suriname)</option>
                                        <option value="SWZ">Swazie (Swaziland)</option>
                                        <option value="SYR">Syrienne (Syrie)</option>
                                        <option value="TJK">Tadjike (Tadjikistan)</option>
                                        <option value="TZA">Tanzanienne (Tanzanie)</option>
                                        <option value="TCD">Tchadienne (Tchad)</option>
                                        <option value="CZE">Tchèque (Tchéquie)</option>
                                        <option value="THA">Thaïlandaise (Thaïlande)</option>
                                        <option value="TGO">Togolaise (Togo)</option>
                                        <option value="TON">Tonguienne (Tonga)</option>
                                        <option value="TTO">Trinidadienne (Trinité-et-Tobago)</option>
                                        <option value="TUN">Tunisienne (Tunisie)</option>
                                        <option value="TKM">Turkmène (Turkménistan)</option>
                                        <option value="TUR">Turque (Turquie)</option>
                                        <option value="TUV">Tuvaluane (Tuvalu)</option>
                                        <option value="UKR">Ukrainienne (Ukraine)</option>
                                        <option value="URY">Uruguayenne (Uruguay)</option>
                                        <option value="VUT">Vanuatuane (Vanuatu)</option>
                                        <option value="VAT">Vaticane (Vatican)</option>
                                        <option value="VEN">Vénézuélienne (Venezuela)</option>
                                        <option value="VNM">Vietnamienne (Viêt Nam)</option>
                                        <option value="YEM">Yéménite (Yémen)</option>
                                        <option value="ZMB">Zambienne (Zambie)</option>
                                        <option value="ZWE">Zimbabwéenne (Zimbabwe)</option>
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
                                      <button type="submit" class="btn btn-primary" name="submit_old">Enregistrer</button>
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
