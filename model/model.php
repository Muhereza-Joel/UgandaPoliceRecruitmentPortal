<?php

namespace model;

use core\DatabaseConnection;
use core\Request;
use core\Session;
use Exception;

class Model
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


    public function get_all_users()
    {
        $query = "SELECT up.*, au.id AS user_id, au.username, au.approved, au.email, au.role
                  FROM app_users au JOIN user_profile up
                  ON au.id = up.user_id";

        $stmt = $this->database->prepare($query);
        $stmt->execute();

        $result = $stmt->get_result();
        $users = $result->fetch_all(MYSQLI_ASSOC);

        $stmt->close();

        return ['httpStatus' => 200, 'response' => $users];
    }

    public function get_user_details($id)
    {
        $query = "SELECT up.*, au.id AS user_id, au.username, au.approved, au.email, au.role
                FROM app_users au JOIN user_profile up
                ON au.id = up.user_id
                WHERE up.id = ?";

        $stmt = $this->database->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $result = $stmt->get_result();
        $user_details = $result->fetch_assoc();

        $stmt->close();

        return ['httpStatus' => 200, 'response' => $user_details];
    }

    public function check_nin()
    {
        $request = Request::capture();

        $nin = $request->input('nin');

        $query = "SELECT nin FROM voters WHERE nin LIKE ?";

        $stmt = $this->database->prepare($query);
        $stmt->bind_param("s", $nin);
        $stmt->execute();

        $result = $stmt->get_result();
        $nin_exists = $result->fetch_assoc();


        if ($nin_exists) {
            $response = ['message' => 'NIN exists already in the system'];
            $httpStatus = 401;

            Request::send_response($httpStatus, $response);
        } else {
            $response = ['message' => 'No body has the same NIN in the system'];
            $httpStatus = 200;

            Request::send_response($httpStatus, $response);
        }

        $stmt->close();
    }

    public function generate_voter_number()
    {
        $schoolId = "SCH12345";
        $randomCode = substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(12 / strlen($x)))), 1, 12);
        $voterNumber = $schoolId . '-' . $randomCode;
        return $voterNumber;
    }

    public function create_application($position_id)
    {

        $query = "INSERT INTO application(applicant_id, position_id) VALUES(?, ?)";
        $current_user = Session::get('user_id');

        $stmt = $this->database->prepare($query);
        $stmt->bind_param("ii", $current_user, $position_id);

        $stmt->execute();

        $lastInsertId = $this->database->insert_id; // Get the last insert ID

        if ($stmt->affected_rows > 0) {
            $response = ['message' => 'Application saved successfully', 'last_insert_id' => $lastInsertId];
            $httpStatus = 200;
            return ['httpStatus' => $httpStatus, 'response' => $response];
        } else {
            $response = ['message' => $this->database->error];
            $httpStatus = 500;
            return ['httpStatus' => $httpStatus, 'response' => $response];
        }

        $stmt->close();
    }

    public function get_all_applications()
    {
        $query = "SELECT a.application_id, a.applicant_id, a.position_id, a.status, up.name, up.phone, jp.title, a.created_at FROM application a 
        JOIN user_profile up ON a.applicant_id = up.user_id
        JOIN job_positions jp ON jp.id = a.position_id";

        $stmt = $this->database->prepare($query);
        $stmt->execute();

        $result = $stmt->get_result();
        $rows = $result->fetch_all(MYSQLI_ASSOC);

        $stmt->close();

        return ['httpStatus' => 200, 'response' => $rows];
    }

    public function get_user_applications()
    {
        $query = "SELECT a.application_id, a.status, up.name, up.phone, jp.title, a.created_at FROM application a 
        JOIN user_profile up ON a.applicant_id = up.user_id
        JOIN job_positions jp ON jp.id = a.position_id
        WHERE a.applicant_id = ?";

        $current_user = Session::get('user_id');

        $stmt = $this->database->prepare($query);
        $stmt->bind_param('i', $current_user);
        $stmt->execute();

        $result = $stmt->get_result();
        $rows = $result->fetch_all(MYSQLI_ASSOC);

        $stmt->close();

        return ['httpStatus' => 200, 'response' => $rows];
    }

    public function get_shortlist()
    {
        $query = "SELECT a.application_id, s.id As shortlist_id, up.user_id, up.name, up.phone, jp.title, s.status, s.notes, s.created_at FROM shortlist s 
        JOIN application a ON s.application_id = a.application_id
        JOIN user_profile up ON up.user_id = a.applicant_id
        JOIN job_positions jp ON jp.id = a.position_id";

        $stmt = $this->database->prepare($query);
        $stmt->execute();

        $result = $stmt->get_result();
        $rows = $result->fetch_all(MYSQLI_ASSOC);

        $stmt->close();

        return ['httpStatus' => 200, 'response' => $rows];
    }

    public function get_user_shortlist()
    {
        $query = "SELECT a.application_id, s.id As shortlist_id, up.name, up.phone, jp.title, s.status, s.notes, s.created_at FROM shortlist s 
        JOIN application a ON s.application_id = a.application_id
        JOIN user_profile up ON up.user_id = a.applicant_id
        JOIN job_positions jp ON jp.id = a.position_id
        WHERE a.applicant_id = ?";

        $current_user = Session::get('user_id');

        $stmt = $this->database->prepare($query);
        $stmt->bind_param('i', $current_user);
        $stmt->execute();

        $result = $stmt->get_result();
        $rows = $result->fetch_all(MYSQLI_ASSOC);

        $stmt->close();

        return ['httpStatus' => 200, 'response' => $rows];
    }

    public function change_application_status($application_id, $status)
    {
        $query = "UPDATE application SET status = ? WHERE application_id = ?";

        $stmt = $this->database->prepare($query);
        $stmt->bind_param('si', $status, $application_id);
        $stmt->execute();

        
        if ($stmt->affected_rows > 0) {
            $response = ['message' => 'Application status updated successfully'];
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
}
