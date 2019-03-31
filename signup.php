<?php
    require_once('startsession.php');

    require_once('connectvars.php');
    
    require_once('header.html');

?>
<div id="main" class="container-fluid">
    <div class="container-fluid"><h1><span id="h1border">sign up</span></h1>
    </div>
	
	<div class="col-md-12">

<?php
    
    // connect to the database
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
            or die('Error connecting to db.');

    if (isset($_POST['submit'])) {
        // grab the profile data from the POST
        $username = mysqli_real_escape_string($dbc, trim($_POST['username']));
        $password1 = mysqli_real_escape_string($dbc, trim($_POST['password1']));
        $password2 = mysqli_real_escape_string($dbc, trim($_POST['password2']));
        $firstName = mysqli_real_escape_string($dbc, trim($_POST['firstName']));
        $lastName = mysqli_real_escape_string($dbc, trim($_POST['lastName']));
        $email = mysqli_real_escape_string($dbc, trim($_POST['email']));
    
        if (!empty($username) && !empty($password1) && !empty($password2) && $password1 == ($password2)) {
            // check if unique username
            $query = "select * from sailor where username = '$username'";
            $data = mysqli_query($dbc, $query)
                    or die('Error querying db 1.');
        
            if (mysqli_num_rows($data) == 0) {
                // ==> unique username ==> insert data into db
                $query = "insert into sailor (username, password, joinDate, firstName, lastName, email) values ('$username', SHA('$password1'), NOW(), '$firstName', '$lastName', '$email')";
                mysqli_query($dbc, $query)
                        or die ('Error querying db 2.');
                
                // confirm success with the user
                echo '<p class="formDirections">Sign up successful. <a href="login.php">Log in</a> to join or create events.</p>';
                
                mysqli_close($dbc);
                exit();
            } else {
                // an account already exists with that username
                echo '<p class="error">Username unavailable. Choose a different username.</p>';
                $username = "";
            }
            
        } else {
            echo '<p class="error">All fields are required and the two passwords must match exactly.</p>';
        }
    
    }
    
    mysqli_close($dbc);
    
?>

            <form class="generalForm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" value="<?php if (!empty($username)) echo $username; ?>"/><br/>
                <label for="password1">Password:</label>
                <input type="password" id="password1" name="password1"/><br/>
                <label for="password2">Confirm Password:</label>
                <input type="password" id="password2" name="password2"/></br>
                <label for="username">First Name:</label>
                <input type="text" id="firstName" name="firstName" value=""/><br/>
                <label for="username">Last Name:</label>
                <input type="text" id="lastName" name="lastName" value=""/><br/>
                <label for="username">Email:</label>
                <input type="text" id="email" name="email" value=""/><br/>
                <input type="submit" value="Sign Up" name="submit" />
            </form>
    
        </div>
    </div>


<?php require_once('footer.html') ?> 
</body>
</html>