<html>
    <head>
        <?php 
            session_start();
            if(!isset($_SESSION["login"])) {
                header("Location:index.php");
            }
        ?>
        <title>DB Final Project</title> 
        <link rel="stylesheet" type="text/css" href="styles/style.css" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    </head>
    <body>
        <div id="container">
            <div id="header">
                <ul>
                    <li><a>Exam Day</a></li>
                    <li><a href="home.php">Home</a></li>
                    <li><a href="change_password.php">Change Password</a></li>
                    <li><a href="diff_user.php">Different User</a></li>
                    <li><a>User: <?php echo $_SESSION['id']; ?></a></li>
                </ul>
            </div>

            <div id="content">
                <div id="current_exams">
                    <?php 
                        try {
                            $config = parse_ini_file("db.ini");
                            $dbh = new PDO($config['dsn'], $config['username'], $config['password']);
                            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                            
                            echo "<table border='1'";
                            echo "<TR> <TH> Name </TH> <TH> Total Points </TH> <TH> Time Created </TH> </TR>";
                            foreach ($dbh->query("select exam_name, total_points, time_created from Exam") as $row) {
                                echo '<form method="post" action="take_exam.php">';
                                echo "<TR>";
                                echo "<TD>".$row[0]."</TD><TD>".$row[1]."</TD><TD>".$row[2]."</TD>";
                                echo '<TD> <input type="submit" name="take" value="Take"> </TD>';
                                echo "</TR>";
                                echo '<input type="hidden" name="exam_name" value="'.$row[0].'">';
                                echo '</form>';
                            }
                            echo "</table>";
                        } catch (PDOException $e) {
                            print "Error!".$e->getMessage()."<br/";
                            die();
                        }
                    ?>
                </div>

                <div id="past_exams">

                </div>
            </div>

            <div id ="footer">
            </div>

        </div>
    </body>
</html>
