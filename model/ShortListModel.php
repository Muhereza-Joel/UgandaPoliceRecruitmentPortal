<?php

namespace model;

use core\DatabaseConnection;
use core\Request;

class ShortListModel
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

    public function create(ShortList $shortList)
    {
        $count = 0;

        $applicationId = $shortList->getApplicationId();
        $status = $shortList->getStatus();
        $notes = $shortList->getNotes();

        // Check if application_id already exists
        $checkQuery = "SELECT COUNT(*) FROM shortlist WHERE application_id = ?";
        $checkStmt = $this->database->prepare($checkQuery);
        $checkStmt->bind_param("i", $applicationId);
        $checkStmt->execute();
        $checkStmt->bind_result($count);
        $checkStmt->fetch();
        $checkStmt->close();

        if ($count > 0) {
            $response = ['message' => 'Applicant already shortlisted'];
            $httpStatus = 400; // Bad Request
            return ['httpStatus' => $httpStatus, 'response' => $response];
        }

        // Insert new record if application_id does not exist
        $query = "INSERT INTO shortlist(application_id, status, notes) VALUES(?, ?, ?)";
        $stmt = $this->database->prepare($query);
        $stmt->bind_param("iss", $applicationId, $status, $notes);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $response = ['message' => 'Shortlist Item saved successfully'];
            $httpStatus = 200; // OK
        } else {
            $response = ['message' => $this->database->error];
            $httpStatus = 500; // Internal Server Error
        }

        $stmt->close();

        return ['httpStatus' => $httpStatus, 'response' => $response];
    }


    public function readAll()
    {
        $query = "SELECT * FROM shortlist";

        $stmt = $this->database->prepare($query);
        $stmt->execute();

        $result = $stmt->get_result();
        $jobs = $result->fetch_all(MYSQLI_ASSOC);

        $stmt->close();

        return ['httpStatus' => 200, 'response' => $jobs];
    }

    public function readOne($id)
    {
        $query = "SELECT * FROM shortlist WHERE id = ?";

        $stmt = $this->database->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        return ['httpStatus' => 200, 'response' => $row];

        $stmt->close();
    }

    public function update(ShortList $shortList)
    {
        $id = $shortList->getId();
        $applicationId = $shortList->getApplicationId();
        $status = $shortList->getStatus();
        $notes = $shortList->getNotes();

        $query = "UPDATE shortlist SET application_id = ?, status = ?, notes = ? WHERE id = ?";

        $stmt = $this->database->prepare($query);
        $stmt->bind_param("sssi", $applicationId, $status, $notes, $id);

        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $response = ['message' => 'Shortlist Item updated successfully'];
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
        $query = "DELETE FROM shortlist WHERE id = ?";

        $stmt = $this->database->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $response = ['message' => 'Shortlist Item Deleted Successfully'];
            $httpStatus = 200;

            return ['httpStatus' => 200, 'response' => $response];
        } else {
            $response = ['message' => $stmt->error];
            $httpStatus = 500;

            return ['httpStatus' => 500, 'response' => $response];
        }
    }
}
