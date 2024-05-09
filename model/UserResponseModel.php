<?php

namespace model;

use core\DatabaseConnection;

class UserResponseModel
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

    public function create(UserResponse $userResponse)
    {
        $userId = $userResponse->getUserId();
        $testId = $userResponse->getTestId();
        $questionId = $userResponse->getQuestionId();
        $selectedOptionId = $userResponse->getSelectedOptionId();

        $query = "INSERT INTO user_response(user_id, test_id, question_id, selected_option_id) VALUES(?, ?, ?, ?)";

        $stmt = $this->database->prepare($query);
        $stmt->bind_param("iiii", $userId, $testId, $questionId, $selectedOptionId);

        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $response = ['message' => 'Resposes saved successfully'];
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
    }

    public function readOne($id)
    {
    }

    public function update(UserResponse $userResponse)
    {
    }

    public function delete($id)
    {
    }
}
