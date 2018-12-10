<html>
    <header>
        <ul>
            <li><a href="https://classdb.it.mtu.edu/~asrospie/final/home.php">Home</a></li>
            <li><a href="https://classdb.it.mtu.edu/~asrospie/final/change_password.php">Change Password</a></li>
        </ul>
    </header>
    <body>
        <?php 
            try {
                $config = parse_ini_file("db.ini");
                $dbh = new PDO($config['dsn'], $config['username'], $config['password']);
                $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                session_start();
                
                if(isset($_POST["id"])) {
                    $stmt = $dbh->prepare("select count(*) from Student where id = :id and password = :password");
                    $stmt->execute(array(':id' => $_POST['id'], ':password' => $_POST['old_password']));
		            $row = $stmt->fetchAll();
		    
		            if($row[0][0] == "1") {
                        if(!($_POST['password'] == "")) {
                            if($_POST['password'] == $_POST['con_password']) {
                                $stmt = $dbh->prepare("update Student set password = :password where id=:id");
                                $stmt->execute(array(':id' => $_POST['id'], ':password' => $_POST['password']));
                                echo '<script>alert("Password Changed");</script>';
                                header("Location:home.php");
                            }
                            else {
                                echo '<script>alert("Passwords do not match!");</script>';
                            }
                        }
                        else {
                            echo '<script>alert("Please enter a new password.");</script>';
                        }
                    }
                    else {
                        echo '<script>alert("Incorrect username and/or password.")</script>';
                    }
                }
            } catch (PDOException $e) {
                print "Error!";
                die();
            }
        ?>
        <form method=post action=change_password.php>
            Student ID: <input type="text" name="id">
            <br>
            Old Password: <input type="password" name="old_password">
            <br>
            New Password: <input type="password" name="password">
            <br>
            Confirm New Password: <input type="password" name="con_password">
            <br>
            <input type="submit" value="Submit">
        </form>
    </body>
</html>