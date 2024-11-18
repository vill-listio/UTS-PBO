<?php 
    session_start();
    require "../koneksi.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <link rel="stylesheet" href="../bootstrap-5.3.3-dist/css/bootstrap.min.css">
</head>
<style>
    html, body {
            height: 100%;
            margin: 0; /* Reset margin */
        }

    .main{
        height: 100vh;
    }
    .login-box{
        width: 500px;
        height: 300px;
        box-sizing: border-box;
        border-radius: 10px;
    }
    .login-box input {
            width: 100%;
            margin-bottom: 15px;
    }
</style>
<body>
    <div class="main d-flex flex-column justify-content-center align-items-center">
        <div class="login-box p-5 shadow">
            <form action="" method="post">
                <div>
                    <label for="username">username</label>
                    <input type="text" class="form-control" name="username" id="username">
                </div>
                <div>
                    <label for="password">password</label>
                    <input type="password" class="form-control" name="password" id="password">
                </div>
                <div>
                    <button class="btn btn-success form-control mt-3" type="submit" name="loginbtn">login</button>
                </div>
            </form>
        </div>

        <div>
            <?php 
                if(isset($_POST['loginbtn'])){
                    $username = htmlspecialchars($_POST['username']);
                    $password = htmlspecialchars($_POST['password']);
                
                   $query = mysqli_query($con, "SELECT * FROM users WHERE user_name = '$username'");
                    
                    $countdata = mysqli_num_rows($query);
                    $data = mysqli_fetch_array($query);
                    

                    if ($countdata > 0) {
                       if (password_verify($password, $data['password'])) {
                        $_SESSION['user_name'] = $data['user_name'];
                        $_SESSION['login'] = true;
                        header('location: index.php');
                       }
                       else {
                        ?>
                        <div class="alert alert-warning" role="alert">
                        Password salah
                        </div>
                    <?php
                       }
                    }
                    else {
                        ?>
                        <div class="alert alert-warning" role="alert">
                        Akun tidak tersedia
                        </div>
                    <?php
                    }
                 }
                ?>
        </div>
    </div>
</body>
</html>