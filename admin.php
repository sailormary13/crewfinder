<?php
    require_once('startsession.php');
    require_once('connectvars.php');
    require_once('Event.php');
    require_once('header.html');

?>
    <div id="main" class="container-fluid">
        <div class="container-fluid"><h1><span id="h1border">admin</span></h1>
        </div>
        
    <div style="margin-top:30px;" class="col-md-12">

<?php
    
    // if user isn't logged in, try to let them in
    if (!isset($_SESSION['admin_id'])) {
        if (isset($_POST['submit'])) {
            
            // connect to db
            $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
                    or die('Error connecting to db.');
    
            // grab the user-entered log-in data
            $admin_username = mysqli_real_escape_string($dbc, trim($_POST['username']));
            $admin_password = mysqli_real_escape_string($dbc, trim($_POST['password']));
            
            if (!empty($admin_username) && !empty($admin_password)) {
                // look up username and pass in db
                $query = "SELECT id, username FROM admin WHERE " . 
                        "username = '$admin_username' AND password = SHA('$admin_password')";
                $data = mysqli_query($dbc, $query)
                        or die('Error querying db.');
                
                if (mysqli_num_rows($data) == 1) {
                    // log-in is OK so set the user ID and username session vars
                    $row = mysqli_fetch_array($data);
                    $_SESSION['admin_username'] = $row['username'];
                    $_SESSION['admin_id'] = $row['id'];
                    
                    mysqli_close($dbc);
                    
                    
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
    
    // display event list if admin logged in
    if (isset($_SESSION['admin_id'])) {
        // make headers sortable
        require_once('sort.js');
        
        // get events from DB
        
        $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
                    or die('Error connecting to db.');
    
        $query2 = "SELECT *, event.id as event_id, category.name as categoryName, 
                fleet.name as fleetName, capacity - 1 as crewCapacity, 
                CONCAT(IFNULL(sailor.firstName, ''), ' ', IFNULL(sailor.lastName, '')) as eventCreator FROM event 
                join category on category = category.id join fleet on fleet = fleet.id 
                join sailor on eventCreator = sailor.id where date >= CURDATE() order by date, startTime limit 20";
        
        
        $data2 = mysqli_query($dbc, $query2)
                or die('Error accessing posts.');
        
        // display posts       
        echo '<table id="eventTable" class="table borderless table-striped table-responsive-sm">
                <thead><tr><th class="sortableTH" onclick="sortTable(0)"><span class="thText">date</span></th><th>time</th>
                <th class="sortableTH" onclick="sortTable(2)"><span class="thText">category</span></th>
                <th class="sortableTH" onclick="sortTable(3)"><span class="thText">fleet</span></th><th>open spots</th>
                <th class="sortableTH" onclick="sortTable(5)"><span class="thText">skipper</span></th>
                <th>delete</th></tr></thead>';
        while ($row = mysqli_fetch_array($data2)) {
            // get crew count
            $query = "select count(*) from eventCrew where eventId = " . $row['event_id'] . "";
            
            $data3 = mysqli_query($dbc, $query)
                    or die('Error inserting crew.');
            
            $row3 = mysqli_fetch_array($data3);
            
            $crewCount = $row3['count(*)'];
            
            $crewCount = (int)$crewCount;
            
            // get open spots
            $crewCapacity = $row['crewCapacity'];
            $crewCapacity = (int)$crewCapacity;
            $open_spots = $crewCapacity - $crewCount;
            
            echo '<tr class="clickableTR" onclick="location.href=\'viewevent.php?event_id=' . $row['event_id'] . '\';"><td>' . $row['date'] . '</td>';
            // get nicely formatted time data
            $startTime = explode(":", $row['startTime']);
            $endTime = explode(":", $row['endTime']);
            $startMeridiem = "PM";
            $endMeridiem = "PM";
            if ($startTime[0] > 12) {
                $startTime[0] = ($startTime[0] - 12);
            } else if ($startTime[0] < 12) {
                $startTime[0] = ltrim($startTime[0], "0");
                $startMeridiem = "AM";
            }
            if ($endTime[0] > 12) {
                $endTime[0] = ($endTime[0] - 12);
            } else if ($endTime[0] < 12) {
                $endTime[0] = ltrim($endTime[0], "0");
                $endMeridiem = "AM";
            }
            echo '<td>' . $startTime[0] . ':' . $startTime[1] .' ' . $startMeridiem . '&nbsp 
                    - &nbsp'. $endTime[0] . ':' . $endTime[1] .' ' . $endMeridiem . '</td>';
            echo '<td>' . $row['categoryName'] . '</td>';
            echo '<td>' . $row['fleetName'] . '</td>';
            echo '<td>' . $open_spots . '</td>';
            echo '<td>' . $row['eventCreator'] . '</td>';
            echo '<td><a href="deleteevent.php?event_id=' . $row['event_id'] . '">delete</a></td></tr>';
        }
        echo '</table>';
    
        mysqli_close($dbc);
    }

    
    // display login form if not already logged in
    if (!isset($_SESSION['admin_id'])) {
        echo '<p class="formDirections text-center">log in to access admin</p>';
        echo '
                <form class="generalForm" method="post" action="' . $_SERVER['PHP_SELF'] . '">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" value="" /><br/>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" /><br/>
                <input type="submit" value="Log In" name="submit"/>
                </form>';
        
    }
    
?>



    </div>

</div>

<?php require_once('footer.html') ?> 
</body>
</html>