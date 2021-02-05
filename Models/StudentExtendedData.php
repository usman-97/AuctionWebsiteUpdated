<?php

class StudentExtendedData {
    
    protected $_id, $_firstName, $_lastName, $_international, $_courseName, $_programmeLeader;

    public function __construct($dbRow) {
        $this->_id = $dbRow['id'];
        $this->_firstName = $dbRow['first_name'];
        $this->_lastName = $dbRow['last_name'];
        if ($dbRow['international']) $this->_international = 'yes'; else $this->_international = 'no';
        $this->_courseName = $dbRow['course_name'];
        $this->_programmeLeader = $dbRow['programme_leader'];
    }

    public function getStudentID() {
        return $this->_id;
    }
   
    public function getFirstName() {
       return $this->_firstName;
    }
    
    public function getLastName() {
       return $this->_lastName;
    }
    
    public function getInternational() {
       return $this->_international;
    }
    
    public function getCourseName() {
       return $this->_courseName;
    }
    
    public function getProgrammeLeader() {
       return $this->_programmeLeader;
    }
}