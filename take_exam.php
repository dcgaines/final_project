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
                    <li><a href="https://classdb.it.mtu.edu/~asrospie/final/home.php">Home</a></li>
                    <li><a href="https://classdb.it.mtu.edu/~asrospie/final/change_password.php">Change Password</a></li>
                    <li><a href="https://classdb.it.mtu.edu/~asrospie/final/diff_user.php">Different User</a></li>
                    <li><a>User: <?php echo $_SESSION['id']; ?></a></li>
                </ul>
            </div>

            <div id="content">
                <div id="exam_content">
                    <?php 
                        try {
                            $config = parse_ini_file("db.ini");
                            $dbh = new PDO($config['dsn'], $config['username'], $config['password']);
                            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                            
                            $username = $_SESSION['id'];
                            $exam_name = $_POST['exam_name'];

                            echo "<h1>".$exam_name."</h1>";

                            $q = "select q_number, q_text, points from Question where exam_name='".$exam_name."'";
                            $count = 1;
                            echo "<form>";
                            foreach ($dbh->query($q) as $row) {
                                echo "<table border='1'>";
                                echo "<TR> <TH> ".$row[0]." </TH><TH> ".$row[1]." </TH><TH> ".$row[2]." Points </TH></TR>";
                                $r = "select identifier, c_text from Choices where q_number=".$count." and exam_name = '".$exam_name."'";
                                foreach ($dbh->query($r) as $choice) {
                                    echo "<TR>";
                                    echo '<TD><input type="radio" name='.$count.' value="'.$choice[0].'"> '.$choice[0]. '</TD>';
                                    echo '<TD colspan="2"> '.$choice[1].' </TD>';
                                    echo "</TR>";
                                }
                                $count = $count + 1;
                                echo "</table";
                                echo "</br>";
                            }
                            echo "</form>";

                        } catch (PDOException $e) {
                            print "Error!".$e->getMessage()."<br/";
                            die();
                        }
                    ?>
                </div>
            </div>

            <div id ="footer">
            </div>

        </div>
    </body>
</html>