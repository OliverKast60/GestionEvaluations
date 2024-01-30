<?php
// Database Connection
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['sid'] == 0)) {
    header('location:logout.php');
} else {
    header("Content-type: application/octet-stream");
    $filename = "Liste des presences";
    header("Content-Disposition: attachment; filename=" . $filename . "-Rapport.xls");
    header("Pragma: no-cache");
    header("Expires: 0");
    include('config.php');
?>

    <?php

    ?>

    <table class="table table-striped nowrap" style="font-weight: normal;font: size 11px;" id="myTable" border="1">
        <thead style="font-weight: normal;font: size 11px;">
            <tr>
                <th class="th-sm" style="font-weight: bold;font: size 10px;">#</th>
                <th class="th-sm" style="font-weight: bold;font: size 10px;">Nom de l'&eacute;tudiant</th>
                <th class="th-sm" style="font-weight: bold;font: size 10px;">Matricule</th>
                <th class="th-sm" style="font-weight: bold;font: size 10px;">Classe</th>
                <th class="th-sm" style="font-weight: bold;font: size 10px;">Evaluation</th>
                <th class="th-sm" style="font-weight: bold;font: size 10px;">Date de l'&eacute;valuation</th>


            </tr>
        </thead>
        <tbody>
            <?php $query = mysqli_query($con, "SELECT tblattendances.*, tblstudents.*, tblcourses.*, tblstudents.s_name as a, tblevaluations.*, tblclasses.* FROM tblattendances, tblclasses, tblstudents,tblevaluations, tblcourses WHERE tblattendances.a_student=tblstudents.id and tblclasses.id = tblstudents.s_classe and tblevaluations.id=tblattendances.a_eval  and tblevaluations.e_course=tblcourses.id");
            $n = 1;
            while ($row = mysqli_fetch_array($query)) {
            ?>
                <?php
                if ($n / 2 == 1) {
                    // code...
                ?>
                    <tr style="background-color:pink;">
                        <td><?php echo $n; ?></td>

                        <td><?php echo ($row['a']); ?></td>
                        <td><?php echo ($row['s_matricule']); ?></td>
                        <td><?php echo ($row['c_name'] . " " . $row['c_option']); ?></td>
                        <td><?php echo ($row['c_intitule']); ?></td>
                        <td><?php echo ($row['date_eval']); ?></td>
                    </tr>
                <?
                } else {
                ?>
                    <tr style="background-color:whitesmoke;">
                        <td><?php echo $n; ?></td>

                        <td><?php echo ($row['a']); ?></td>
                        <td><?php echo ($row['s_matricule']); ?></td>
                        <td><?php echo ($row['c_name'] . " " . $row['c_option']); ?></td>
                        <td><?php echo ($row['c_intitule']); ?></td>
                        <td><?php echo ($row['date_eval']); ?></td>
                    </tr>
                <?php
                }

                ?>


            <?php
                $n++;
            }
            ?>

        </tbody>
    </table>
<?php
}
?>
