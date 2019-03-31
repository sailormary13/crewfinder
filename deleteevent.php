<?php
    require_once('startsession.php');
    require_once('connectvars.php');
    require_once('Event.php');
    require_once('header.html');
?>

<div id="main" class="container-fluid">
    <div class="container-fluid"><h1><span id="h1border">delete event</span></h1>
    </div>
    <div class="col-md-12">

<?php

    $event_id = $_GET['event_id'];
    
    if (isset($_POST['submit'])) {
        //delete event from db
        $event = new Event();
        $event->setId($_POST['event_id']);
        $event->deleteEvent();
        
        //tell user successful deletion
        echo '<p class="formDirections text-center">event deleted</p>';
        
        //back to events button
        echo '<p class="text-center"><a href="crewfinder.php"><button>back to events</button></a></p>';
        
    } else {
        // display delete or cancel buttons

?>
        <p style="margin-top: 35px; margin-bottom: 15px" class="form directions text-center">are you sure you want to delete the event?</p>
        <div class="deleteFormWrapper">
            <form class="deleteForm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <div><input class="deleteForm" type="submit" name="submit" value="delete"></div>
                <input type="hidden" name="event_id" value="<?php echo $event_id; ?>">
            </form>&nbsp;&nbsp;
            <a style="font-size: 1em !important;" href="viewevent.php?event_id=<?php echo $event_id; ?>"><button>cancel</button></a>
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