<?php
    require_once('startsession.php');
    require_once('connectvars.php');
    require_once('Event.php');
    require_once('header.html');

?>
    <div id="main" class="container-fluid">
        <div class="container-fluid"><h1><span id="h1border">create event</span></h1>
        </div>
        
    <div class="col-md-12">

<?php
    
    //GET the category (1 = daysail, 2 = race)
    $category = $_GET['category'];
    
    // Make sure the user is logged in before going any further
    if (!isset($_SESSION['user_id'])) {
        echo '<p class="formDirections text-center"><a href="login.php">log in</a> to access this page</p>';
        exit();
    }
    
    // create new event
    if (isset($_POST['submit'])) {
        $event = new Event();
        $event->setDate($_POST['date']);
        $event->setStartTime($_POST['startTime']);
        $event->setEndTime($_POST['endTime']);
        $event->setBoat($_POST['boat']);
        $event->setFleet($_POST['fleet']);
        $event->setCategory($_POST['category']);
        $event->setRace($_POST['race']);
        $event->setNotes($_POST['notes']);
        $event->setEventCreator($_POST['eventCreator']);
        $event->insertEvent();
        $event_id = $event->getId();
?>
        <div class="container-fluid">
            <p class="text-center">event created</p>
            <p class="text-center"><a href="viewevent.php?event_id=<?php echo $event_id; ?>"><button>view event</button></a></p>
            <p class="text-center"><a href="crewfinder.php"><button>view all events</button></a></p>
        </div>
<?php

    } else {
        // display create event form
?>

            <form id="createEventForm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <label>Date</label>
                <input class="formField" id="date" name="date" type="date" value="" /><br/><br/>
                <label>Start Time</label>
                <input class="formField" id="startTime" name="startTime" type="time" value="" /><br/><br/>
                <label>End Time</label>
                <input class="formField" id="endTime" name="endTime" type="time" value="" /><br/><br/>
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
                <textarea class="formField" id="notes" name="notes" maxlength="65535" placeholder="Describe your event. Give your crew any information that they'll need to know before sailing with you."></textarea><br/><br/>
                <input type="submit" name="submit" value="Create Event">
                <input type="hidden" name="eventCreator" value="<?php echo $_SESSION['user_id']; ?>">
            </form>
        </div>
        
<?php
    }
?>
        
    </div>
</div>
    
    <?php require_once('footer.html') ?> 
    
</body>
</html>