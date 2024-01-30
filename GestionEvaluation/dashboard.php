<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['sid'] == 0)) {
  header('location:logout.php');
} else {
?>

  <!DOCTYPE html>
  <html>

  <head>
    <meta charset="utf-8">
    <title></title>
    <?php
    include('includes/head.php');
    ?>
    <link rel="stylesheet" href="google_font.css">
    <script src="script.js" defer></script>
    <style type="text/css">
      .material-symbols-outlined {
        font-variation-settings:
          'FILL' 0,
          'wght' 400,
          'GRAD' 0,
          'opsz' 48
      }

      .material-symbols-outlined {
        font-variation-settings:
          'FILL' 0,
          'wght' 400,
          'GRAD' 0,
          'opsz' 48
      }

      .calendar {
        padding: 20px;
      }

      .calendar ul {
        display: flex;
        flex-wrap: wrap;
        list-style: none;
        text-align: center;
      }

      .calendar .days {
        margin-bottom: 20px;
      }

      .calendar li {
        color: #333;
        width: calc(100% / 7);
        font-size: 1.07rem;
      }

      .calendar .weeks li {
        font-weight: 500;
        cursor: default;
      }

      .calendar .days li {
        z-index: 1;
        cursor: pointer;
        position: relative;
        margin-top: 30px;
      }

      .days li.inactive {
        color: #aaa;
      }

      .days li.active {
        color: white;
      }

      .days li::before {
        position: absolute;
        content: "";
        left: 50%;
        top: 50%;
        height: 40px;
        width: 40px;
        z-index: -1;
        border-radius: 50%;
        transform: translate(-50%, -50%);
      }

      .days li.active::before {
        background: royalblue;
        color: white;
        font-weight: bold;
      }

      .days li:not(.active):hover::before {
        background: lightgray;
        color: white;
      }

      .icons span:last-child {
        margin-right: -10px;
      }

      header .icons span:hover {
        background: #f2f2f2;
      }

      header .current-date {
        font-size: 1.45rem;
        font-weight: 500;
      }

      header .icons {
        display: flex;
      }

      header .icons span {
        height: 38px;
        width: 38px;
        margin: 0 1px;
        cursor: pointer;
        color: #878787;
        text-align: center;
        line-height: 38px;
        font-size: 1.9rem;
        user-select: none;
        border-radius: 50%;
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
      <h4 class="text-primary"><i class="fas fa-chart-pie"></i> Tableau de bord </h4>
      <hr>
      <div class="row">
        <div class="col-md-12">
          <div class="row">
            <div class="col-md-3">
              <div class="row" style="padding:10px;">
                <div class="col-md-12 bg-dark" style="height:auto;border-radius: 10px;box-shadow: 0 0 8px black;">

                  <div class="row">
                    <div class="col-md-6">
                      <h6 class="mt-4 text-white">Classes</h6>
                    </div>
                    <div class="col-md-6">
                      <?php

                        $dbj = new PDO('mysql:host=localhost; dbname=geva;charset=utf8', 'root', '');

                        $act_year = date('Y');

                        $stats_fac = $dbj->query("SELECT count(tblfaculties.id) as fac FROM tblfaculties WHERE 1");

                        $stats = $dbj->query("SELECT count(tblclasses.id) as c FROM tblclasses WHERE 1");

                        $stats_crs = $dbj->query("SELECT count(tblcourses.id) as crs FROM tblcourses WHERE 1");

                        $stats_etds = $dbj->query("SELECT count(tblstudents.id) as etds FROM tblstudents WHERE student_status=0");

                        $stats_evals = $dbj->query("SELECT count(tblevaluations.id) as evals FROM tblevaluations WHERE e_status= 1 and year(date_eval)=$act_year");

                        $stats_evals_nc = $dbj->query("SELECT count(tblevaluations.id) as evals_nc FROM tblevaluations WHERE e_status= 0 and year(date_eval)=$act_year");

                        $stats_profs = $dbj->query("SELECT count(tblprofesseurs.id) as profs FROM tblprofesseurs WHERE 1");

                        $stats_survs = $dbj->query("SELECT count(tblsurveillants.id) as survs FROM tblsurveillants WHERE 1");

                        $nmbr_survs = $stats_survs->fetch();

                        $nmbr_profs = $stats_profs->fetch();

                        $nmbr_fac = $stats_fac->fetch();

                        $nmbr = $stats->fetch();

                        $nmbr_crs = $stats_crs->fetch();

                        $nmbr_ets = $stats_etds->fetch();

                        $nmbr_evals = $stats_evals->fetch();

                        $nmbr_evals_nc = $stats_evals_nc->fetch();
                      ?>
                      <h1 class="text-white text-uppercase" style="font-size: 60px;font-weight: bolder;opacity: 0.6;">
                        <?php echo $nmbr['c']; ?>
                      </h1>
                    </div>
                  </div>

                </div>
              </div>
            </div>

            <div class="col-md-3">
              <div class="row" style="padding:10px;">
                <div class="col-md-12 bg-dark" style="height:auto;border-radius: 10px;box-shadow: 0 0 8px black;">

                  <div class="row">
                    <div class="col-md-5">
                      <h6 class="mt-4 text-white">Facultés</h6>
                    </div>
                    <div class="col-md-7">
                      <h1 class="text-white text-uppercase" style="font-size: 60px;font-weight: bolder;opacity: 0.6;">
                        <?php
                        echo $nmbr_fac['fac'];
                        ?>
                      </h1>
                    </div>
                  </div>

                </div>
              </div>
            </div>


            <div class="col-md-3">
              <div class="row" style="padding:10px;">
                <div class="col-md-12 bg-dark" style="height:auto;border-radius: 10px;box-shadow: 0 0 8px black;">

                  <div class="row">
                    <div class="col-md-5">
                      <h6 class="mt-4 text-white">Evals. conclues / A.AC.</h6>
                    </div>
                    <div class="col-md-7">
                      <h1 class="text-white text-uppercase" style="font-size: 60px;font-weight: bolder;opacity: 0.6;">
                        <?php
                        echo $nmbr_evals['evals'];
                        ?>
                      </h1>
                    </div>
                  </div>

                </div>
              </div>
            </div>


            <div class="col-md-3">
              <div class="row" style="padding:10px;">
                <div class="col-md-12 bg-dark" style="height:auto;border-radius: 10px;box-shadow: 0 0 8px black;">

                  <div class="row">
                    <div class="col-md-5">
                      <h6 class="mt-4 text-white">Etudiants actifs</h6>
                    </div>
                    <div class="col-md-7">
                      <h1 class="text-white text-uppercase" style="font-size: 60px;font-weight: bolder;opacity: 0.6;">
                        <?php echo $nmbr_ets['etds']; ?>
                      </h1>
                    </div>
                  </div>

                </div>
              </div>
            </div>


            <div class="col-md-3">
              <div class="row" style="padding:10px;">
                <div class="col-md-12 bg-dark" style="height:auto;border-radius: 10px;box-shadow: 0 0 8px black;">

                  <div class="row">
                    <div class="col-md-6">
                      <h6 class="mt-4 text-white">Cours</h6>
                    </div>
                    <div class="col-md-6">
                      <h1 class="text-white text-uppercase" style="font-size: 60px;font-weight: bolder;opacity: 0.6;">
                        <?php echo $nmbr_crs['crs']; ?>
                      </h1>
                    </div>
                  </div>

                </div>
              </div>
            </div>

            <div class="col-md-3">
              <div class="row" style="padding:10px;">
                <div class="col-md-12 bg-dark" style="height:auto;border-radius: 10px;box-shadow: 0 0 8px black;">
                  <div class="row">
                    <div class="col-md-6">
                      <h6 class="mt-4 text-white">Professeurs</h6>
                    </div>
                    <div class="col-md-6">
                      <h1 class="text-white text-uppercase" style="font-size: 60px;font-weight: bolder;opacity: 0.6;">
                        <?php echo $nmbr_profs['profs']; ?>
                      </h1>
                    </div>
                  </div>

                </div>
              </div>
            </div>

            <div class="col-md-3">
              <div class="row" style="padding:10px;">
                <div class="col-md-12 bg-dark" style="height:auto;border-radius: 10px;box-shadow: 0 0 8px black;">
                  <div class="row">
                    <div class="col-md-6">
                      <h6 class="mt-4 text-white">Surveillants</h6>
                    </div>
                    <div class="col-md-6">
                      <h1 class="text-white text-uppercase" style="font-size: 60px;font-weight: bolder;opacity: 0.6;">
                        <?php echo $nmbr_survs['survs']; ?>
                      </h1>
                    </div>
                  </div>

                </div>
              </div>
            </div>

            <div class="col-md-3">
              <div class="row" style="padding:10px;">
                <div class="col-md-12 bg-dark" style="height:auto;border-radius: 10px;box-shadow: 0 0 8px black;">

                  <div class="row">
                    <div class="col-md-5">
                      <h6 class="mt-4 text-white">Evals. En_cours / A.AC.</h6>
                    </div>
                    <div class="col-md-7">
                      <h1 class="text-white text-uppercase" style="font-size: 60px;font-weight: bolder;opacity: 0.6;">
                        <?php
                        echo $nmbr_evals_nc['evals_nc'];
                        ?>
                      </h1>
                    </div>
                  </div>

                </div>
              </div>
            </div>

          </div>
        </div>
      </div>

      <hr>

      <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-5 mb-2 mt-5">
          <canvas id="myChart" style="width:100%;max-width:600px;text-align:center;"></canvas>
        </div>

        <div class="col-md-5 bg-white mb-5" style="border-radius: 20px;">
          <div class="row">
            <div class="col-md-12" style="height:100%;padding:40px;">
              <header style="text-align:center;">

                <div class="icons text-center" style="text-align:center;">
                  <span id="prev" class="material-symbols-outlined"><i class="fas fa-chevron-left"></i></span>
                  <p class="current-date text-center"></p>
                  <span id="next" class="material-symbols-outlined"><i class="fas fa-chevron-right"></i></span>
                </div>
              </header>
              <hr>
              <div class="calendar">
                <ul class="weeks">
                  <li>Sun</li>
                  <li>Mon</li>
                  <li>Tue</li>
                  <li>Wed</li>
                  <li>Thu</li>
                  <li>Fri</li>
                  <li>Sat</li>
                </ul>
                <ul class="days"></ul>
              </div>
              <hr>
            </div>


          </div>
        </div>
      </div>

    </div>

    <?php
    define('DB_SERVER', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASS', '');
    define('DB_NAME', 'geva');

    try {
      $dbh = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
      exit("Error: " . $e->getMessage());
    }

    ?>

    <script type="text/javascript" src="dash.js"></script>

    <script>
      var xValues = [
        <?php
        $annee = date('Y');
        $sql = "SELECT count(tblevaluations.id) as s, month(tblevaluations.date_eval) as d, year(tblevaluations.date_eval) as y from tblevaluations where e_status=1 and year(tblevaluations.date_eval)=$annee group by month(tblevaluations.date_eval) asc";
        $query = $dbh->prepare($sql);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);

        $cnt = 1;
        if ($query->rowCount() > 0) {
          $ctn = 1;
          foreach ($results as $row) {

            if ($row->d == 1) {
              echo '"' . 'Janvier' . '",';
            } else if ($row->d == 2) {
              echo '"' . 'Février' . '",';
            } else if ($row->d == 3) {
              echo '"' . 'Mars' . '",';
            } else if ($row->d == 4) {
              echo '"' . 'Avril' . '",';
            } else if ($row->d == 5) {
              echo '"' . 'Mai' . '",';
            } else if ($row->d == 6) {
              echo '"' . 'Juin' . '",';
            } else if ($row->d == 7) {
              echo '"' . 'Juillet' . '",';
            } else if ($row->d == 8) {
              echo '"' . 'Aout' . '",';
            } else if ($row->d == 9) {
              echo '"' . 'Septembre' . '",';
            } else if ($row->d == 10) {
              echo '"' . 'Octobre' . '",';
            } else if ($row->d == 11) {
              echo '"' . 'Novembre' . '",';
            } else if ($row->d == 12) {
              echo '"' . 'Décembre' . '",';
            }

            $ctn++;
          }
        }
        ?>
      ];
      var yValues = [
        <?php

        $annee = date('Y');
        $sql = "SELECT count(tblevaluations.id) as s, month(tblevaluations.date_eval) as d, year(tblevaluations.date_eval) as y from tblevaluations where e_status=1 and year(tblevaluations.date_eval)=$annee group by month(tblevaluations.date_eval) asc";
        $query = $dbh->prepare($sql);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);

        $cnt = 1;
        if ($query->rowCount() > 0) {
          $ctn = 1;
          foreach ($results as $row) {
        ?>
        <?php echo htmlentities($row->s . ",");

            $ctn++;
          }
        }
        ?>
      ];
      var barColors = [
        "#b91d47",
        "#00aba9",
        "#2b5797",
        "#e8c3b9",
        "#1e7145",
        "red",
        "yellow",
        "orange",
        "green",
        "gold",
        "gray",
        "pink"
      ];

      new Chart("myChart", {
        type: "doughnut",
        data: {
          labels: xValues,
          datasets: [{
            backgroundColor: barColors,
            data: yValues
          }]
        },
        hoverOffset: 4,
        options: {
          cutoutPercentage: 80,
          title: {
            display: true,
            fontSize: 14,
            text: "Statistiques annuelles des évaluations"
          }
        }
      });
    </script>

  </html>
<?php
}
?>
