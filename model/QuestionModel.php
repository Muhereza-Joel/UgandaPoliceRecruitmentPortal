<?php

namespace model;

use core\DatabaseConnection;

class questionModel
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

    public function create(Question $question)
    {
        $testId = $question->getTestId();
        $questionText = $question->getQuestionText();

        $query = "INSERT INTO questions(test_id, question_text) VALUES(?, ?)";

        $stmt = $this->database->prepare($query);
        $stmt->bind_param("is", $testId, $questionText);

        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $response = ['message' => 'Question saved successfully'];
            $httpStatus = 200;
            return ['httpStatus' => $httpStatus, 'response' => $response];
        } else {
            $response = ['message' => $this->database->error];
            $httpStatus = 500;
            return ['httpStatus' => $httpStatus, 'response' => $response];
        }

        $stmt->close();
    }

    public function readAll($id)
    {
        $query = "SELECT * FROM questions WHERE test_id = ?";

        $stmt = $this->database->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $result = $stmt->get_result();
        $row = $result->fetch_all(MYSQLI_ASSOC);

        $stmt->close();

        return ['httpStatus' => 200, 'response' => $row];
    }

    public function readOne($id)
    {
        $query = "SELECT * FROM questions WHERE question_id = ?";

        $stmt = $this->database->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        return ['httpStatus' => 200, 'response' => $row];

        $stmt->close();
    }

    public function update(Question $question)
    {
        $id = $question->getQuestionId();
        $testId = $question->getTestId();
        $questionText = $question->getQuestionText();


        $query = "UPDATE questions SET test_id = ?, question_text = ? WHERE question_id = ?";

        $stmt = $this->database->prepare($query);
        $stmt->bind_param("isi", $testId, $questionText, $id);

        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $response = ['message' => 'Question updated successfully'];
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
        $query = "DELETE FROM questions WHERE question_id = ?";

        $stmt = $this->database->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $response = ['message' => 'Question Deleted Successfully'];
            $httpStatus = 200;

            return ['httpStatus' => $httpStatus, 'response' => $response];
        } elseif ($stmt->affected_rows == 0) {
            $response = ['message' => 'Question Not Found'];
            $httpStatus = 200;

            return ['httpStatus' => $httpStatus, 'response' => $response];
        } else {
            $response = ['message' => $stmt->error];
            $httpStatus = 500;

            return ['httpStatus' => $httpStatus, 'response' => $response];
        }
    }
}
