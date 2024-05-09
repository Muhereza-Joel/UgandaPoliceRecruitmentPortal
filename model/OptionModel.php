<?php
namespace model;

use core\DatabaseConnection;

class OptionModel{

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

    public function create(Option $option)
    {
        $questionId = $option->getQuestionId();
        $optionText = $option->getOptionText();
        $isCorrect = $option->getIsCorrect();

        $query = "INSERT INTO options(question_id, option_text, is_correct) VALUES(?, ?, ?)";

        $stmt = $this->database->prepare($query);
        $stmt->bind_param("isi", $questionId, $optionText, $isCorrect);

        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $response = ['message' => 'Option saved successfully'];
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
        $query = "SELECT * FROM options WHERE question_id = ?";

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
        $query = "SELECT * FROM options WHERE option_id = ?";

        $stmt = $this->database->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        return ['httpStatus' => 200, 'response' => $row];

        $stmt->close();
    }

    public function update(Option $option)
    {
        $id = $option->getOptionId();
        $questionId = $option->getQuestionId();
        $optionText = $option->getOptionText();
        $isCorrect = $option->getIsCorrect();


        $query = "UPDATE options SET question_id = ?, option_text = ?, is_correct = ? WHERE option_id = ?";

        $stmt = $this->database->prepare($query);
        $stmt->bind_param("isii", $questionId, $optionText, $isCorrect, $id);

        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $response = ['message' => 'Option updated successfully'];
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
        $query = "DELETE FROM options WHERE option_id = ?";

        $stmt = $this->database->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $response = ['message' => 'Option Deleted Successfully'];
            $httpStatus = 200;

            return ['httpStatus' => $httpStatus, 'response' => $response];
        } elseif ($stmt->affected_rows == 0) {
            $response = ['message' => 'Option Not Found'];
            $httpStatus = 200;

            return ['httpStatus' => $httpStatus, 'response' => $response];
        } else {
            $response = ['message' => $stmt->error];
            $httpStatus = 500;

            return ['httpStatus' => $httpStatus, 'response' => $response];
        }
    }
}
?>