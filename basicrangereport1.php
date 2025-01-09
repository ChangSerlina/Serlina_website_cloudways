<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <script>
            function cfun1() {
                window.print();
            }
        </script>
    </head>
    <body onload="cfun1()">
        <table border="0" width="900">
            <?php
            $start = $_GET['tstart'];
            $end = $_GET['tend'];
            require_once('./lib/db_lib.php');     //mysql連線
            $db = new Database();
            $sql = "select * from plan where 行程 >= '" . $start . "' and 行程 <= '" . $end."' ";
            $result = $db->query($sql);
            $rows = mysqli_num_rows($result);
            $fields = mysqli_num_fields($result);

            $fn = mysqli_fetch_fields($result);
            for ($u = 0;
                    $u < $fields;
                    $u++) {
                echo "<td bgcolor='#FA527A'>" . $fn[$u]->name . "</td>";
            }

            while ($row = mysqli_fetch_row($result)) {
                echo "<tr>";
                echo "<td>" . $row[0] . "</td>";
                echo "<td>" . $row[1] . "</td>";
                echo "<td>" . $row[2] . "</td>";
                echo "<td>" . $row[3] . "</td>";
                echo "<td>" . $row[4] . "</td>";
                echo "</tr>";
            }

            $result->close();
            $db->close();
            ?>
        </table>
    </body>
</html>
