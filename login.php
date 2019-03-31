<?php
    require_once('startsession.php');
    require_once('connectvars.php');
    require_once('header.html');

?>

<div id="main" class="container-fluid">
    <div class="container-fluid"><h1><span id="h1border">log in</span></h1>
    </div>
    
	<div class="col-md-12">
	    

<?php

// clear error message
    $error_msg = "";
    
    // if user isn't logged in, try to let them in
    if (!isset($_SESSION['user_id'])) {
        if (isset($_POST['submit'])) {
            
            // connect to db
            $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
                    or die('Error connecting to db.');
    
            // grab the user-entered log-in data
            $user_username = mysqli_real_escape_string($dbc, trim($_POST['username']));
            $user_password = mysqli_real_escape_string($dbc, trim($_POST['password']));
            
            if (!empty($user_username) && !empty($user_password)) {
                // look up username and pass in db
                $query = "SELECT id, username FROM sailor WHERE " . 
                        "username = '$user_username' AND password = SHA('$user_password')";
                $data = mysqli_query($dbc, $query)
                        or die('Error querying db.');
                
                if (mysqli_num_rows($data) == 1) {
                    // log-in is OK so set the user ID and username session vars and redirect home
                    $row = mysqli_fetch_array($data);
                    $_SESSION['username'] = $row['username'];
                    $_SESSION['user_id'] = $row['id'];
                    
                    mysqli_close($dbc);
                    
                    // redirect to home page
                    $home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/crewfinder.php';
                    header('Location: ' . $home_url);
                    
                } else {
                    // username/pass are incorrect ==> set error message
                    $error_msg = 'Invalid username or password.';
                }
            } else {
                // username/pass weren't entered ==> set error message
                $error_msg = 'Enter username and password.';
            }
            
        }
    }
    

?>


<?php
    // if cookie empty ==> show error message and log-in form; otherwise confirm log-in
    if (empty($_SESSION['user_id'])) {
?>
    <form class="generalForm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" value="<?php if (!empty($user_username)) echo $user_username; ?>" /><br/>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" /><br/>
        <input type="submit" value="Log In" name="submit"/>
    </form>
    
<?php
    } else {
        // confirm successful login
        echo ('<p class="formDirections text-center">logged in as ' . $_SESSION['username'] . ' <br/><a href="logout.php">log out</a></p>');
    }
?>

    </div>

</div>

<?php require_once('footer.html') ?> 
</body>
</html>