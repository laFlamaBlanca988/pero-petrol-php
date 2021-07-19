<?php

class Users
{
    // DB stuff
    private $errors = [];
    private $conn;
    // Users properties
    public $userID;
    public $firstName;
    public $lastName;
    public $experience;
    public $salary;
    public $vacationDays;
    public $gasStation;
    public $email;
    public $password;

    // Constructor with DB
    public function __construct($db)
    {
        $this->conn = $db;
    }
    // Get users
    public function read_users()
    {
        // Create query
        $query = "SELECT
        gas_stations.gasStation, users.userID, users.firstName, users.lastName, users.experience, users.salary, users.vacationDays, users.email, users.password
        FROM users
        LEFT JOIN gas_stations ON gas_stations.stationID = users.gasStation
        ORDER BY userID
         ";
        $statement = $this->conn->prepare($query);
        $statement->execute();

        return $statement;
    }

    public function read_user_single()
    {
        $query = "SELECT
        gas_stations.gasStation, users.userID, users.firstName, users.lastName, users.experience, users.salary, users.vacationDays, users.email, users.password
        FROM users
        LEFT JOIN gas_stations ON gas_stations.stationID = users.gasStation
        WHERE users.userID = ?
        LIMIT 0,1";
        // Prepare query
        $statement = $this->conn->prepare($query);
        // Bind ID
        $statement->bindParam(1, $this->userID);
        // Execute query
        $statement->execute();

        $row = $statement->fetch(PDO::FETCH_ASSOC);

        // Set properties
        $this->userID = $row['userID'];
        $this->firstName = $row['firstName'];
        $this->lastName = $row['lastName'];
        $this->experience = $row['experience'];
        $this->salary = $row['salary'];
        $this->vacationDays = $row['vacationDays'];
        $this->gasStation = $row['gasStation'];
    }

    public function create_user()
    {
        $query = "INSERT INTO users SET firstName = :firstName, lastName = :lastName, email = :email, password = :password, vacationDays = :vacationDays, experience = :experience, salary = :salary, gasStation = :gasStation";

        $statement = $this->conn->prepare($query);

        // Clean data
        // $this->userID = htmlspecialchars(strip_tags($this->userID));
        $this->firstName = htmlspecialchars(strip_tags($this->firstName));
        $this->lastName = htmlspecialchars(strip_tags($this->lastName));
        $this->experience = htmlspecialchars(strip_tags($this->experience));
        $this->salary = htmlspecialchars(strip_tags($this->salary));
        $this->vacationDays = htmlspecialchars(strip_tags($this->vacationDays));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->gasStation = htmlspecialchars(strip_tags($this->gasStation));

        // $statement->bindParam(':userID', $this->userID);
        $statement->bindParam(':firstName', $this->firstName);
        $statement->bindParam(':lastName', $this->lastName);
        $statement->bindParam(':email', $this->email);
        $statement->bindParam(':password', $this->password);
        $statement->bindParam(':vacationDays', $this->vacationDays);
        $statement->bindParam(':experience', $this->experience);
        $statement->bindParam(':salary', $this->salary);
        $statement->bindParam(':gasStation', $this->gasStation);

        // Execute query
        if ($statement->execute()) {
            return true;
        }
        printf("Error: %s. /n", $statement->error);
        return false;
    }

    public function update_user()
    {
        $query = "UPDATE users SET userID = :userID, firstName = :firstName, lastName = :lastName, email = :email, password = :password, vacationDays = :vacationDays, experience = :experience, salary = :salary, gasStation = :gasStation WHERE userID = :userID";

        $statement = $this->conn->prepare($query);

        // Clean data
        $this->userID = htmlspecialchars(strip_tags($this->userID));
        $this->firstName = htmlspecialchars(strip_tags($this->firstName));
        $this->lastName = htmlspecialchars(strip_tags($this->lastName));
        $this->experience = htmlspecialchars(strip_tags($this->experience));
        $this->salary = htmlspecialchars(strip_tags($this->salary));
        $this->vacationDays = htmlspecialchars(strip_tags($this->vacationDays));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->gasStation = htmlspecialchars(strip_tags($this->gasStation));

        $statement->bindParam(':userID', $this->userID);
        $statement->bindParam(':firstName', $this->firstName);
        $statement->bindParam(':lastName', $this->lastName);
        $statement->bindParam(':email', $this->email);
        $statement->bindParam(':password', $this->password);
        $statement->bindParam(':vacationDays', $this->vacationDays);
        $statement->bindParam(':experience', $this->experience);
        $statement->bindParam(':salary', $this->salary);
        $statement->bindParam(':gasStation', $this->gasStation);

        // Execute query
        if ($statement->execute()) {
            return true;
        }
        printf("Error: %s. /n", $statement->error);
        return false;
    }

    public function delete_user()
    {
        $query = "DELETE FROM users WHERE userID = :userID";

        $statement = $this->conn->prepare($query);

        $this->userID = htmlspecialchars(strip_tags($this->userID));

        $statement->bindParam(':userID', $this->userID);

        // Execute query
        if ($statement->execute()) {
            return true;
        }
        printf("Error: %s. /n", $statement->error);
        return false;
    }
}