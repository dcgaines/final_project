<html>
    <head>
        <?php 
            session_start();
            if(!isset($_SESSION["login"])) {
                header("Location:index.php");
            }
        ?>
    </head>
    <header>
        <ul>
            <li><a href="https://classdb.it.mtu.edu/~asrospie/final/home.php">Home</a></li>
            <li><a href="https://classdb.it.mtu.edu/~asrospie/final/change_password.php">Change Password</a></li>
            <li><a href="https://classdb.it.mtu.edu/~asrospie/final/diff_user.php">Different User</a></li>
            <li>User: <?php echo $_SESSION['id']; ?></li>
        </ul>
    </header>
    <body>
        
    </body>
</html>