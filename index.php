<html>
    <head>
        <title>Testing</title>
    </head>
    <body>
        <?php 
            try {
                $config = parse_ini_file("db.ini");
                $dbh = new PDO($config['dsn'], $config['username'], $config['password']);
                $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                session_start();
                if(isset($_SESSION["login"])) {
                    header("Location:home.php");
                }
                
                if(isset($_POST["id"])) {
                    $stmt = $dbh->prepare("select count(*) from Student where id = :id and password = encrypt(:password, 'database')");
                    $stmt->execute(array(':id' => $_POST['id'], ':password' => $_POST['password']));
		            $row = $stmt->fetchAll();
		    
		            if($row[0][0] == "1") {
                        $_SESSION['login'] = true;
                        $_SESSION['id'] = $_POST['id'];
                        header("Location:home.php");
                    }
                    else {
                        echo "Incorrect username or password.";
                    }
                }
            } catch (PDOException $e) {
                print "Error!";
                die();
            }
        ?>
        <form method=post action=index.php>
            Student ID: <input type="text" name="id">
            <br>
            Password: <input type="password" name="password">
            <br>
            <input type="submit" value="Submit">
        </form>
    </body>
</html>
