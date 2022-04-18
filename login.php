<?php
// Inicializim sesioni
session_start();
 
// Kontrollo nese user eshte loguar, nese po drejto te home page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: index.php");
    exit;
}
 
// Perfshi file configurimi
require_once "config.php";
 
//Inicializim variablash
$username = $password = "";
$username_err = $password_err = $login_err = "";
 
// Procesim info nga forma pas submit
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Username empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Ju lutem jepni username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Password empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Ju lutem jepni passwordin.";
    } else{
        $password = trim($_POST["password"]);
    }
    
  
    if(empty($username_err) && empty($password_err)){
        // Select query
        $sql = "SELECT Username, Password FROM perdorues WHERE Username = ?";

        if($stmt = mysqli_prepare($link, $sql)){
            // Lidh variablat me statement si parametra
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            $param_username = $username;
            
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                
                // Kontroll nese username ekziston
                if(mysqli_stmt_num_rows($stmt) == 1){
                    mysqli_stmt_bind_result($stmt, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password i sakte, nis sesion te ri
                            session_start();
                            
                            $_SESSION["loggedin"] = true;
                            $_SESSION["username"] = $username;
                            
                            // Redirect user te faqja kryesore
                            header("location: index.php");
                        } else{
                            // Password jo i sakte
                            $login_err = "Username ose password jo i sakte.";
                        }
                    }
                } else{
                    // Username s'ekziston
                    $login_err = "Username ose passworkd jo i sakte.";
                }
            } else{
                echo "Oops! Dicka shkoi gabim. Provo me vone.";
            }

            // Mbyll statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Mbyll connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; }
        .wrapper{ width: 360px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Login</h2>
        <p>Ploteso kredencialet per tu loguar.</p>

        <?php 
        if(!empty($login_err)){
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }        
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Username</label>
                <label>
                    <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                </label>
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group">
                <label>Password</label>
                <label>
                    <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                </label>
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
            <p>Nuk ke llogari? <a href="register.php">Regjistrohu tani.</a>.</p>
        </form>
    </div>
</body>
</html>