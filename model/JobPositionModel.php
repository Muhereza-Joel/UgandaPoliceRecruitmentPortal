<?php

namespace model;

use core\DatabaseConnection;
use core\Request;

class JobPositionModel
{
    private $database;

    public function __construct()
    {
        $this->get_database_connection();
    }

    private function get_database_connection()
    {
        $database_connection = new DatabaseConnection(getenv('DB_HOST'), getenv('DB_DATABASE'), getenv('DB_USERNAME'), getenv('DB_PASSWORD'));
        $this->database = $database_connection->get_connection();
    }

    public function create(JobPosition $jobPosition)
    {
        $title = $jobPosition->getTitle();
        $description = $jobPosition->getDescription();
        $requirements = $jobPosition->getRequirements();
        $responsibilities = $jobPosition->getResponsibilities();

        $query = "INSERT INTO job_positions(title, description, requirements, responsibilities) VALUES(?, ?, ?, ?)";

        $stmt = $this->database->prepare($query);
        $stmt->bind_param("ssss", $title, $description, $requirements, $responsibilities);

        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $response = ['message' => 'Job position saved successfully'];
            $httpStatus = 200;
            return ['httpStatus' => $httpStatus, 'response' => $response];
        } else {
            $response = ['message' => $this->database->error];
            $httpStatus = 500;
            return ['httpStatus' => $httpStatus, 'response' => $response];
        }

        $stmt->close();
    }

    public function readAll()
    {
        $query = "SELECT * FROM job_positions";

        $stmt = $this->database->prepare($query);
        $stmt->execute();

        $result = $stmt->get_result();
        $jobs = $result->fetch_all(MYSQLI_ASSOC);

        $stmt->close();

        return ['httpStatus' => 200, 'response' => $jobs];
    }

    public function readOne($id)
    {
        $query = "SELECT * FROM job_positions WHERE id = ?";

        $stmt = $this->database->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        return ['httpStatus' => 200, 'response' => $row];

        $stmt->close();
    }

    public function update(JobPosition $jobPosition)
    {
        $id = $jobPosition->getId();
        $title = $jobPosition->getTitle();
        $description = $jobPosition->getDescription();
        $requirements = $jobPosition->getRequirements();
        $responsibilities = $jobPosition->getResponsibilities();

        $query = "UPDATE job_positions SET title = ?, description = ?, requirements = ?, responsibilities = ? WHERE id = ?";

        $stmt = $this->database->prepare($query);
        $stmt->bind_param("ssssi", $title, $description, $requirements, $responsibilities, $id);

        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $response = ['message' => 'Job position updated successfully'];
            $httpStatus = 200;
            return ['httpStatus' => $httpStatus, 'response' => $response];
        } elseif ($stmt->affected_rows == 0) {
            $response = ['message' => 'Nothing To Update'];
            $httpStatus = 200;
            return ['httpStatus' => $httpStatus, 'response' => $response];
        } else {
            $response = ['message' => $this->database->error];
            $httpStatus = 500;
            return ['httpStatus' => $httpStatus, 'response' => $response];
        }

        $stmt->close();
    }

    public function delete($id)
    {
        $query = "DELETE FROM job_positions WHERE id = ?";

        $stmt = $this->database->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $response = ['message' => 'Job Position Deleted Successfully'];
            $httpStatus = 200;

            return ['httpStatus' => $httpStatus, 'response' => $response];
        } elseif ($stmt->affected_rows == 0) {
            $response = ['message' => 'Job Position Not Found'];
            $httpStatus = 200;

            return ['httpStatus' => $httpStatus, 'response' => $response];
        } else {
            $response = ['message' => $stmt->error];
            $httpStatus = 500;

            return ['httpStatus' => $httpStatus, 'response' => $response];
        }
    }
}
