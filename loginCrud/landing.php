<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>  
    <style>
        .h-custom{
            height: calc(100% - 73px);
    }
    </style>
</head>
<body>
    <section class="vh-100">
    <div class="container-fluid justify-content-center align-items-center d-flex h-custom" style=''>
    <div class="col-md-8 col-lg-6 d-flex justify-content-center align-items-center mx-auto col-xl-4 offset-xl-1">
        <div style='padding: 20px 25px 20px 25px;' class='row d-flex card justify-content-center align-items-center h-100'>
        <form action='landing.php' method='post'>
        <h1>Welcome <?php echo $_SESSION['username'] ?> !</h1>
        <button name='logout' value = 'true' type="submit" class="btn btn-primary btn-lg" style="padding-left: 2.5rem;  margin-top:50px; padding-right: 2.5rem;">Logout</button>

        </form>
        </div>
        </div>
    </div>
    </section>
</body>
    <?php 
        

        if(!isset($_SESSION['username'])){
            header("Location: login.php"); // Redirect to login page if not logged in
            exit();
        }else{
            echo "<script>console.log('it have data!')</script>";
        }

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $isLogout = $_POST['logout'];
            $isLogout = $booleanValue = filter_var($isLogout, FILTER_VALIDATE_BOOLEAN);
            
            if($isLogout){
                session_start(); // Start the session
                session_unset(); // Unset all session variables
                session_destroy(); // Destroy the session
                header("Location: login.php"); // Redirect to the login page
                exit();               
        }else{
            echo "<script>console.log('can't logout')</script>";
        }
        }
    
    ?>
</html>