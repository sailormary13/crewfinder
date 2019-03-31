<?php
    require_once('startsession.php');
    require_once('connectvars.php');
    require_once('Event.php');
    require_once('header.html');

?>

<div id="main" class="container-fluid">
            
    <div class="container-fluid"><h1><span id="h1border">edit event</span></h1>
    </div>
            
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
<?php

    // Make sure the user is logged in before going any further.
    if (!isset($_SESSION['user_id'])) {
        echo '<p class="formDirections text-center"><a href="login.php">log in</a> to access this page</p>';
        exit();
    }
    
    // set the event id
    if (isset($_GET['event_id'])) {
        $event_id = $_GET['event_id'];
    } else {
        $event_id = $_POST['event_id'];
    }

    // Connect to the database
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
            or die ('Error connecting to db.');

    if (isset($_POST['submit'])) {
        // Grab the profile data from the POST
        $date = mysqli_real_escape_string($dbc, trim($_POST['date']));
        $startTime = mysqli_real_escape_string($dbc, trim($_POST['startTime']));
        $endTime = mysqli_real_escape_string($dbc, trim($_POST['endTime']));
        $category = mysqli_real_escape_string($dbc, trim($_POST['category']));
        $fleet = mysqli_real_escape_string($dbc, trim($_POST['fleet']));
        $notes = mysqli_real_escape_string($dbc, trim($_POST['notes']));
        $error = false;
        

        // Update the profile data in the database
        if (!$error) {
            // check that no fields are empty
            if (!empty($date) && !empty($startTime) && !empty($endTime) && !empty($category) && !empty($fleet) && !empty($notes)) {
        
                $query = "UPDATE event SET date = '$date', startTime = '$startTime', endTime = '$endTime', " .
                        " category = '$category', fleet = '$fleet', notes = '$notes' WHERE id = '" . $event_id . "'";
                mysqli_query($dbc, $query)
                        or die('Error querying db.');
        
                // Confirm success with the user
                echo '<p>Event updated. <a href="viewevent.php?event_id=' . $event_id . '">View event</a>.</p>';
        
                mysqli_close($dbc);
                exit();
            } else {
                echo '<p class="error">All fields are required.</p>';
            }
        }
    } // End of check for form submission
    else {
        // Grab the profile data from the database
        $query = "SELECT date, startTime, endTime, category, fleet, notes FROM event WHERE id = '" . $event_id . "'";
        $data = mysqli_query($dbc, $query);
        $row = mysqli_fetch_array($data);

        if ($row != NULL) {
            $date = $row['date'];
            $startTime = $row['startTime'];
            $endTime = $row['endTime'];
            $category = $row['category'];
            $fleet = $row['fleet'];
            $notes = $row['notes'];
            
        }
        else {
            echo '<p class="text-center">There was a problem accessing the event data.</p>';
        }
    }

    mysqli_close($dbc);
?>

    <form id="createEventForm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <label>Date</label>
                <input class="formField" id="date" name="date" type="date" value="<?php if (!empty($date)) echo $date; ?>" /><br/><br/>
                <label>Start Time</label>
                <input class="formField" id="startTime" name="startTime" type="time" value="<?php if (!empty($startTime)) echo $startTime; ?>" /><br/><br/>
                <label>End Time</label>
                <input class="formField" id="endTime" name="endTime" type="time" value="<?php if (!empty($endTime)) echo $endTime; ?>" /><br/><br/>
                <label>Category</label>
                <select name="category">
                  <option value="1">Day Sailing</option>
                  <option value="2">HSC Sloop Racing</option>
                  <option value="3">MYC Wed Series</option>
                  <option value="4">MYC Sun Series</option>
                  <option value="5">Pirates' Day</option>
                  <option value="6">Commodore's Cup</option>
                  <option value="7">HSC 420 Racing</option>
                  <option value="8">Other</option>
                </select><br/><br/>
                <label>Fleet</label>
                <select name="fleet">
                  <option value="1">Badger Sloop</option>
                  <option value="2">E-Scow</option>
                  <option value="3">C-Scow</option>
                  <option value="4">420</option>
                  <option value="5">Windsurfing</option>
                  <option value="6">Tech</option>
                  <option value="7">Laser / Byte</option>
                  <option value="8">J 24</option>
                  <option value="9">J 22</option>
                  <option value="10">O'Day</option>
                  <option value="11">Capri 22</option>
                  <option value="12">Heavy Keelboat</option>
                </select><br/><br/>
                <label>Description</label>
                <textarea class="formField" id="notes" name="notes" maxlength="65535"><?php echo $notes; ?></textarea><br/><br/>
                <input type="submit" name="submit" value="edit event">
                <input type="hidden" name="event_id" value="<?php echo $event_id; ?>">
                <input type="hidden" name="eventCreator" value="<?php echo $_SESSION['user_id']; ?>">
            </form>
        </div>
    
</div>
</div>
</div>
   
<?php require_once('footer.html') ?> 
    
</body> 
</html>
