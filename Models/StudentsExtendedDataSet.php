<?php

require_once 'Models/Database.php';
require_once 'Models/StudentExtendedData.php';

class StudentsExtendedDataSet {

protected $_dbConnection, $_dbInstance;
    
    public function __construct() {
        $this->_dbInstance = Database::getInstance();
        $this->_dbConnection = $this->_dbInstance->getDbConnection();
    }
    
    public function fetchAll() {
        $sqlQuery = 'SELECT students.id, first_name, last_name, international, course_name, programme_leader FROM students,courses WHERE (students.courseID = courses.id) ORDER BY students.id';
               
        $statement = $this->_dbConnection->prepare($sqlQuery); // prepare a PDO statement
        $statement->execute(); // execute the PDO statement
        
        $dataSet = [];
        while ($row = $statement->fetch()) {         
            $dataSet[] = new StudentExtendedData($row);
        }
        return $dataSet;
    } 
}
