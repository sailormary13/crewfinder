<?php
    require_once('startsession.php');
    require_once('connectvars.php');
    require_once('Event.php');
    require_once('header.html');

?>

<div id="main" class="container-fluid">
            
    <div class="container-fluid"><h1><span id="h1border">events</span></h1>
    </div>
            
    <div class="container-fluid">
        <div class="row">
            <div id="eventList" class="col-md-12">
                                    

<?php

    // make headers sortable
    require_once('sort.js');
    
    // get events from DB
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
            or die ('Error connecting to db.');

    $query = "SELECT *, event.id as event_id, category.name as categoryName, fleet.name as fleetName, capacity - 1 as crewCapacity,
            CONCAT(IFNULL(sailor.firstName, ''), ' ', IFNULL(sailor.lastName, '')) as eventCreator FROM event 
            join category on category = category.id join fleet on fleet = fleet.id join sailor on eventCreator = sailor.id
            where date >= CURDATE() order by date, startTime limit 20";
    
    $data = mysqli_query($dbc, $query)
            or die('Error accessing posts.');
    
    // display posts       
    echo '<table id="eventTable" class="table borderless table-striped table-responsive-sm">
            <thead><tr><th class="sortableTH" onclick="sortTable(0)"><span class="thText">date</span></th><th>time</th>
            <th class="sortableTH" onclick="sortTable(2)"><span class="thText">category</span></th>
            <th class="sortableTH" onclick="sortTable(3)"><span class="thText">fleet</span></th><th>open spots</th>
            <th class="sortableTH" onclick="sortTable(5)"><span class="thText">skipper</span></th></tr></thead>';
    
    while ($row = mysqli_fetch_array($data)) {
        
        // get crew count
        $query = "select count(*) from eventCrew where eventId = " . $row['event_id'] . "";
        
        $data2 = mysqli_query($dbc, $query)
                or die('Error inserting crew.');
        
        $row2 = mysqli_fetch_array($data2);
        
        $crewCount = $row2['count(*)'];
        
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
        echo '<td>' . $row['eventCreator'] . '</td></tr>';
    }
    echo '</table>';

    mysqli_close($dbc);
                                    
?>
        </div>
    </div>
</div>
</div>

<?php require_once('footer.html') ?> 

    
    </body>
</html>