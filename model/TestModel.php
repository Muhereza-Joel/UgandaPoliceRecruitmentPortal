<?php

namespace model;

use core\DatabaseConnection;

class TestModel
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

    public function create(Test $test)
    {
        $title = $test->getTitle();
        $description = $test->getDescription();
        $duration = $test->getDuration();
        $totalMarks = $test->getTotalMarks();

        $query = "INSERT INTO test(title, description, duration_minutes, total_marks) VALUES(?, ?, ?, ?)";

        $stmt = $this->database->prepare($query);
        $stmt->bind_param("ssii", $title, $description, $duration, $totalMarks);

        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $response = ['message' => 'Test saved successfully'];
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
        $query = "SELECT * FROM test";

        $stmt = $this->database->prepare($query);
        $stmt->execute();

        $result = $stmt->get_result();
        $row = $result->fetch_all(MYSQLI_ASSOC);

        $stmt->close();

        return ['httpStatus' => 200, 'response' => $row];
    }

    public function readOne($id)
    {
        $query = "SELECT * FROM test WHERE test_id = ?";

        $stmt = $this->database->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        return ['httpStatus' => 200, 'response' => $row];

        $stmt->close();
    }

    public function update(Test $test)
    {
        $id = $test->getId();
        $title = $test->getTitle();
        $description = $test->getDescription();
        $duration = $test->getDuration();
        $totalMarks = $test->getTotalMarks();


        $query = "UPDATE test SET title = ?, description = ?, duration_minutes = ?, total_marks = ? WHERE test_id = ?";

        $stmt = $this->database->prepare($query);
        $stmt->bind_param("ssiii", $title, $description, $duration, $totalMarks, $id);

        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $response = ['message' => 'Test updated successfully'];
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
        $query = "DELETE FROM test WHERE test_id = ?";

        $stmt = $this->database->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $response = ['message' => 'Test Deleted Successfully'];
            $httpStatus = 200;

            return ['httpStatus' => $httpStatus, 'response' => $response];

        } elseif ($stmt->affected_rows == 0) {
            $response = ['message' => 'Test Not Found'];
            $httpStatus = 200;

            return ['httpStatus' => $httpStatus, 'response' => $response];

        } else {
            $response = ['message' => $stmt->error];
            $httpStatus = 500;

            return ['httpStatus' => $httpStatus, 'response' => $response];
        }
    }
}
