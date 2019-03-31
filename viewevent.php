<?php
    require_once('startsession.php');
    require_once('connectvars.php');
    require_once('Event.php');
    require_once('header.html');

?>

<div id="main" class="container-fluid">
            
    <div class="container-fluid"><h1><span id="h1border">view event</span></h1>
    </div>
            
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                                    

<?php
    // set the event id
    if (isset($_GET['event_id'])) {
        $event_id = $_GET['event_id'];
    } else {
        $event_id = $_POST['event_id'];
    }

    // if user clicked join or delete
    if (isset($_POST['submit'])) {
        
        $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
            or die ('Error connecting to db.');
        
        // add user to eventCrew table if they clicked join    
        if ($_POST['userAction'] == 'join') {
            $query = "insert into eventCrew values (" . $event_id . ", " . $_POST['crew_id'] . ")";
            
            $data = mysqli_query($dbc, $query)
                or die('Error inserting crew.');
                
            echo '<p class="formDirections text-center">' . $_SESSION['username'] . ' successfully joined as crew</p>';
        
        // remove user from eventCrew table if they clicked remove
        } else if ($_POST['userAction'] == 'remove') {
            $query = "delete from eventCrew where eventId = " . $event_id . " && crewId = " . $_POST['crew_id'] . "";

            $data = mysqli_query($dbc, $query)
                    or die('Error deleting crew.');
                
            echo '<p class="formDirections text-center">' . $_SESSION['username'] . ' successfully removed from crew</p>';  
        }
    }
        
    // get event data from DB
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
            or die ('Error connecting to db.');

    $query = "SELECT *, category.name as categoryName, fleet.name as fleetName, capacity - 1 as crewCapacity,
            CONCAT(IFNULL(sailor.firstName, ''), ' ', IFNULL(sailor.lastName, '')) as eventCreator FROM event 
            join category on category = category.id join fleet on fleet = fleet.id join sailor on eventCreator = sailor.id
            where event.id = '" . $event_id . "'";
    
    $data = mysqli_query($dbc, $query)
            or die('Error accessing event data.');
    
    // display event data
    while ($row = mysqli_fetch_array($data)) {
        
        // format date
        $date = explode("-", $row['date']);
        $monthNum  = $date[1];
        $monthName = date('F', mktime(0, 0, 0, $monthNum, 10));
        $year = $date[0];
        $day = $date[3];
        
        // calculate open spots
        
        $query22 = "select count(*) from eventCrew where eventId = " . $event_id . "";
    
        $data22 = mysqli_query($dbc, $query22)
            or die('Error inserting crew.');
    
        $row22 = mysqli_fetch_array($data22);
    
        $crewCount = $row22['count(*)'];
    
        $crewCount = (int)$crewCount;
        $crewCapacity = $row['crewCapacity'];
        $crewCapacity = (int)$crewCapacity;
        $open_spots = $crewCapacity - $crewCount;
        
        // table
        echo '<table id="viewEventTable" class="table borderless">
                <tr><th>date</th><td>' . $row['date'] . '</td></tr>';
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
        echo '<tr><th>time</th><td>' . $startTime[0] . ':' . $startTime[1] .' ' . $startMeridiem . '&nbsp 
                - &nbsp'. $endTime[0] . ':' . $endTime[1] .' ' . $endMeridiem . '</td></tr>';
        echo '<tr><th>category</th><td>' . $row['categoryName'] . '</td></tr>
                <tr><th>fleet</th><td>' . $row['fleetName'] . '</td></tr>
                <tr><th>description</th><td>' . $row['notes'] . '</td></tr>
                <tr><th>skipper</th><td>' . $row['eventCreator'] . '</td></tr>
                <tr><th>crew</th><td style="font-style: italic;">open spots = ' . $open_spots . '</td></tr>';
    }

    // get crew data from db
    $query = "SELECT *, CONCAT(IFNULL(sailor.firstName, ''), ' ', IFNULL(sailor.lastName, '')) as crewName FROM eventCrew 
            join sailor on crewId = sailor.id
            where eventId = '" . $event_id . "'";

    $data = mysqli_query($dbc, $query)
            or die('Error accessing crew data.');
            
    // display crew data
    while ($row = mysqli_fetch_array($data)) {
        echo '<tr><th></th><td>' . $row['crewName'] . '</td></tr>';
    }

            
    mysqli_close($dbc);
                                    
?>

<?php
    // display join or delete buttons
    // first check if user is logged in
    if (isset($_SESSION['user_id'])) {
        
        // next check if user is already the skipper
        $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
            or die ('Error connecting to db.');
            
        $query = "SELECT eventCreator FROM event where event.id = '" . $event_id . "'";
        
        $data = mysqli_query($dbc, $query)
                or die('Error accessing event data 2.');
        
        $row = mysqli_fetch_array($data);
        
        if ($_SESSION['user_id'] == $row['eventCreator']) {
            echo '</table><p class="formDirections text-center">You are the skipper of this event.</p>';
            echo '<div class="inlineFormButtonsDiv"><form class="inlineFormButtons" "method="get" action="deleteevent.php">
                    <div class="buttonHolder"><input type="submit" name="submit" value="delete event"></div>
                    <input type="hidden" name="event_id" value="' . $event_id . '">
                    </form>';
            echo '<form class="inlineFormButtons" method="get" action="editevent.php">
                    <div class="buttonHolder"><input type="submit" name="submit" value="edit event"></div>
                    <input type="hidden" name="event_id" value="' . $event_id . '">
                    </form></div>';
            mysqli_close($dbc);
        } else {
        
            // if not skipper, check if user is already signed up as crew
            $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
                    or die ('Error connecting to db.');
                
            $query = "SELECT crewId from eventCrew where eventId = '" . $event_id . "'";
                
            $data = mysqli_query($dbc, $query)
                    or die('Error for display buttons query');
            
            // put crew ids into an array
            while ($row = mysqli_fetch_array($data)) {
                $rows[] = $row;
            }
            
            //display remove button if session user is already a crew
            if (!empty($rows)) {        
                foreach($rows as $row) {
                    
                    if ($row['crewId'] == $_SESSION['user_id']) {
                        echo '</table><form method="post" action="' . $_SERVER['PHP_SELF'] . '">
                        <div class="buttonHolder"><input type="submit" name="submit" value="remove self from crew"></div>
                        <input type="hidden" name="crew_id" value="' . $_SESSION['user_id'] . '">
                        <input type="hidden" name="event_id" value="' . $event_id . '">
                        <input type="hidden" name="userAction" value="remove">
                        </form>';
                        $checker = 'true';
                        break;
                    } 
                }
            }
            
            // display join button if not signed up
            if ($checker !== 'true') {
                if ($open_spots > 0) {
                    echo '</table><form method="post" action="' . $_SERVER['PHP_SELF'] . '">
                        <div class="buttonHolder"><input type="submit" name="submit" value="join as crew"></div>
                        <input type="hidden" name="crew_id" value="' . $_SESSION['user_id'] . '">
                        <input type="hidden" name="event_id" value="' . $event_id . '">
                        <input type="hidden" name="userAction" value="join">
                        </form>';
                }
            }
            mysqli_close($dbc);
        }
    } else {
        echo '</table><p class="formDirections text-center"><a href="login.php">Log in</a> to join as crew!</p>';
    }
?>
                </table>
                <div class="inlineFormButtonsDiv"><a href="crewfinder.php"><button class="linkButton">back to events</button></a></div>
            </div>
            
        </div>
    </div>
</div>


<?php require_once('footer.html') ?> 

    
    </body>
</html>