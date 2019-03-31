<?php

    require_once('connectvars.php');

    class Event {
        private $id;
        private $name;
        private $date;
        private $startTime;
        private $endTime;
        private $boat;
        private $fleet;
        private $category;
        private $race;
        private $notes;
        private $eventCreator;
        
        // getters and setters forever and forever
        
        public function getId() {
            return $this->id;
        }
        
        public function setId($id) {
            $this->id = $id;
        }
        
        public function getName() {
            return $this->name;
        }
        
        public function setName($name) {
            $this->name = $name;
        }
        
        public function getDate() {
            return $this->date;
        }
        
        public function setDate($date) {
            $this->date = $date;
        }
        
        public function getStartTime() {
            return $this->startTime;
        }
        
        public function setStartTime($startTime) {
            $this->startTime = $startTime;
        }
        
        public function getEndTime() {
            return $this->endTime;
        }
        
        public function setEndTime($endTime) {
            $this->endTime = $endTime;
        }
        
        public function getBoat() {
            return $this->boat;
        }
        
        public function setBoat($boat) {
            $this->boat = $boat;
        }
        
        public function getFleet() {
            return $this->fleet;
        }
        
        public function setFleet($fleet) {
            $this->fleet = $fleet;
        }
        
        public function getCategory() {
            return $this->category;
        }
        
        public function setCategory($category) {
            $this->category = $category;
        }
        
        public function getRace() {
            return $this->race;
        }
        
        public function setRace($race) {
            $this->race = $race;
        }
        
        public function getNotes() {
            return $this->notes;
        }
        
        public function setNotes($notes) {
            $this->notes = $notes;
        }
        
        public function getEventCreator() {
            return $this->eventCreator;
        }
        
        public function setEventCreator($eventCreator) {
            $this->eventCreator = $eventCreator;
        }
        
        // this function inserts the event data in the db
        public function insertEvent() {
            $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
                	or die ('Error connecting to db.');
            
            $name = mysqli_real_escape_string($dbc, trim($this->name));
            $category = mysqli_real_escape_string($dbc, trim($this->category));
            $date = mysqli_real_escape_string($dbc, trim($this->date));
            $startTime = mysqli_real_escape_string($dbc, trim($this->startTime)) . ':00';
            $endTime = mysqli_real_escape_string($dbc, trim($this->endTime)) . ':00';
            $boat = mysqli_real_escape_string($dbc, trim($this->boat));
            $fleet = mysqli_real_escape_string($dbc, trim($this->fleet));
            $race = mysqli_real_escape_string($dbc, trim($this->race));
            $notes = mysqli_real_escape_string($dbc, trim($this->notes));
            $eventCreator = mysqli_real_escape_string($dbc, trim($this->eventCreator));
        
        	$query = "insert into event (date, startTime, endTime, category, fleet, notes, eventCreator) values ('" . $date . "', '" . $startTime . "', '" . $endTime . "', '" . $category . "', '" . $fleet . "', '" . $notes . "', '" . $eventCreator . "')";
        	mysqli_query($dbc, $query)
                	or die('Error querying db.');
            
            // get autoincremented event id and set this id equal to it
            $id = mysqli_insert_id($dbc);
            $this->setId($id);
        
        	mysqli_close($dbc);
        }
        
        //this function edits the event data in the db
        public function editEvent() {
            $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
                	or die ('Error connecting to db.');
                	
            $category = mysqli_real_escape_string($dbc, trim($this->category));
            $date = mysqli_real_escape_string($dbc, trim($this->date));
            $startTime = mysqli_real_escape_string($dbc, trim($this->startTime)) . ':00';
            $endTime = mysqli_real_escape_string($dbc, trim($this->endTime)) . ':00';
            $class = mysqli_real_escape_string($dbc, trim($this->fleet));
            $notes = mysqli_real_escape_string($dbc, trim($this->notes));
        
        	$query = "update event set category = '" . $category . "', date = '" . $date . "', startTime = '" . $startTime . "', endTime = '" . $endTime . "', fleet = '" . $fleet . "', notes = '" . $notes . "'  where id = " . $this->id . "";
        	mysqli_query($dbc, $query)
                	or die('Error querying db.');
        
        	mysqli_close($dbc);
        }
        
        //this functions deletes the event from the db
        public function deleteEvent() {
            $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
                	or die ('Error connecting to db.');
        
        	$query = "delete from event where id = " . $this->id . "";
        	mysqli_query($dbc, $query)
                	or die('Error querying db for delete query.');
        
        	mysqli_close($dbc);
        }
        
   
        
    }

?>