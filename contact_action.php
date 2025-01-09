<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>

<head>
    <meta charset="UTF-8">
    <title></title>
</head>

<body>
    <?php
    $qname = $_POST['name'];
    $qsex = $_POST['gender'];
    $qtel = $_POST['tel'];
    $qemail = $_POST['email'];
    $qquestion = $_POST['question'];
    ?>
    <h2>姓名: <?php echo $qname; ?></h2>
    <h2>性別:
        <?php
        if ($qsex == 0) {
            $qsext = "男";
            echo $qsext;
        } else {
            $qsext = "女";
            echo $qsext;
        }
        ?>
    </h2>
    <h2>電話: <?php echo $qtel; ?></h2>
    <h2>電子郵件: <?php echo $qemail; ?></h2>
    <h2>問題: <?php echo $qquestion; ?></h2>
    <?php
    $mysqli = new mysqli("db", "serlina", "serlina", "theorydb1");
    $mysqli->query("SET NAMES 'UTF8' ");
    $sql = "insert into contact value(default,'" . $qname . "' , '" . $qsext . "' , '" . $qtel . "' , '" . $qemail . "' , '" . $qquestion . "' )";
    modifydata($sql);

    function modifydata($sql)
    {
        $mysqli = new mysqli("db", "serlina", "serlina", "theorydb1");
        $mysqli->query("SET NAMES 'UTF8'");
        $mysqli->query($sql);
        $mysqli->close();
        // header("Location:basicdb.php");                  // 轉向指令
        echo "<script>location.href = './contact.php';</script>";
    }
    ?>
</body>

</html>