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
        $current_user = Session::get('user_id');

        // Check if the user has already applied for the same position
        $checkQuery = "SELECT COUNT(*) as count FROM application WHERE applicant_id = ? AND position_id = ?";
        $checkStmt = $this->database->prepare($checkQuery);
        $checkStmt->bind_param("ii", $current_user, $position_id);
        $checkStmt->execute();
        $result = $checkStmt->get_result();
        $row = $result->fetch_assoc();
        $checkStmt->close();

        if ($row['count'] > 0) {
            $response = ['message' => 'You have already applied for this position'];
            $httpStatus = 400;
            return ['httpStatus' => $httpStatus, 'response' => $response];
        }

        // Proceed with the application if the user hasn't applied yet
        $query = "INSERT INTO application(applicant_id, position_id) VALUES(?, ?)";
        $stmt = $this->database->prepare($query);
        $stmt->bind_param("ii", $current_user, $position_id);
        $stmt->execute();

        $lastInsertId = $this->database->insert_id; // Get the last insert ID

        if ($stmt->affected_rows > 0) {
            $response = ['message' => 'Application saved successfully', 'last_insert_id' => $lastInsertId];
            $httpStatus = 200;
        } else {
            $response = ['message' => $this->database->error];
            $httpStatus = 500;
        }

        $stmt->close();

        return ['httpStatus' => $httpStatus, 'response' => $response];
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
        $query = "SELECT a.application_id, s.id As shortlist_id, up.user_id, up.name, up.district, up.phone, jp.title, s.status, s.notes, s.created_at FROM shortlist s 
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

    public function get_application_details($application_id)
    {
        $query = "SELECT ap.application_id, ap.status, up.name, up.nin, up.dob, up.gender, up.about, up.company, up.job, up.country, up.phone, up.image_url, up.district, up.village, jp.title, jp.description, files.url AS file_url, ap.created_at FROM application ap 
        JOIN user_profile up ON ap.applicant_id = up.user_id
        JOIN job_positions jp ON jp.id = ap.position_id
        JOIN files ON files.application_id = ap.applicant_id
        WHERE ap.application_id = ?
        ";

        $stmt = $this->database->prepare($query);
        $stmt->bind_param("i", $application_id);
        $stmt->execute();

        $result = $stmt->get_result();
        $user_details = $result->fetch_assoc();

        $stmt->close();

        return ['httpStatus' => 200, 'response' => $user_details];
    }

    public function check_user_shortlist_status()
    {
        $query = "SELECT 
        application.application_id,
        CASE 
            WHEN shortlist.application_id IS NOT NULL THEN 'On-Shortlist'
            ELSE 'Not-on-Shortlist'
        END AS shortlist_status
        FROM application
        LEFT JOIN shortlist ON shortlist.application_id = application.application_id
        WHERE application.applicant_id = ?;
        ";

        $user_id = Session::get('user_id');

        $stmt = $this->database->prepare($query);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();

        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        $stmt->close();

        return ['httpStatus' => 200, 'response' => $row];
    }

    public function assign_test($test_id, $job_id)
    {
        // Check if a test is already assigned to the job
        $checkQuery = "SELECT COUNT(*) as count FROM test_mapping WHERE job_id = ?";
        $checkStmt = $this->database->prepare($checkQuery);
        $checkStmt->bind_param('i', $job_id);
        $checkStmt->execute();
        $result = $checkStmt->get_result();
        $row = $result->fetch_assoc();
        $testExists = $row['count'] > 0;
        $checkStmt->close();

        if ($testExists) {
            // Update the existing test assignment
            $query = "UPDATE test_mapping SET test_id = ? WHERE job_id = ?";
        } else {
            // Insert a new test assignment
            $query = "INSERT INTO test_mapping(test_id, job_id) VALUES(?, ?)";
        }

        $stmt = $this->database->prepare($query);
        $stmt->bind_param('ii', $test_id, $job_id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $response = ['message' => 'Assignment saved successfully'];
            $httpStatus = 200;
        } elseif ($stmt->affected_rows == 0) {
            $response = ['message' => 'Assignment saved successfully'];
            $httpStatus = 200;
        } else {
            $response = ['error' => $this->database->error];
            $httpStatus = 500;
        }

        $stmt->close();

        return ['httpStatus' => $httpStatus, 'response' => $response];
    }

    public function get_job_test_assignments($job_id)
    {
        $query = "SELECT test_mapping.id AS mapping_id, test.title, test.description, test.duration_minutes, test.total_marks FROM test_mapping
        JOIN test ON test.test_id = test_mapping.test_id
        WHERE test_mapping.job_id = ?";

        $stmt = $this->database->prepare($query);
        $stmt->bind_param('i', $job_id);
        $stmt->execute();

        $result = $stmt->get_result();
        $rows = $result->fetch_assoc();

        $stmt->close();

        return ['httpStatus' => 200, 'response' => $rows];
    }

    public function drop_test_mapping($mapping_id)
    {
        $query = "DELETE FROM test_mapping WHERE id = ?";

        $stmt = $this->database->prepare($query);
        $stmt->bind_param("i", $mapping_id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $response = ['message' => 'Mapping Deleted Successfully'];
            $httpStatus = 200;

            return ['httpStatus' => $httpStatus, 'response' => $response];
        } elseif ($stmt->affected_rows == 0) {
            $response = ['message' => 'Mapping Not Found'];
            $httpStatus = 200;

            return ['httpStatus' => $httpStatus, 'response' => $response];
        } else {
            $response = ['message' => $stmt->error];
            $httpStatus = 500;

            return ['httpStatus' => $httpStatus, 'response' => $response];
        }
    }

    public function get_my_test()
    {
        $query = "SELECT 
        tm.id AS mapping_id, 
        tm.status AS mapping_status,
        jp.title AS job_title, 
        jp.description AS job_description, 
        t.test_id,
        t.title AS test_title, 
        t.description AS test_description, 
        t.duration_minutes, 
        t.total_marks,
        (SELECT COUNT(*) 
        FROM questions q 
        WHERE q.test_id = t.test_id) AS question_count
        FROM 
            test_mapping tm
        JOIN 
            test t ON t.test_id = tm.test_id
        JOIN 
            job_positions jp ON jp.id = tm.job_id
        JOIN 
            application a ON a.position_id = tm.job_id
        WHERE 
            a.applicant_id = ?
            AND EXISTS (
                SELECT 1 
                FROM shortlist s 
                JOIN application a
                WHERE s.application_id = a.application_id
            )
        ";

        $user_id = Session::get('user_id');
        $stmt = $this->database->prepare($query);
        $stmt->bind_param('i', $user_id);
        $stmt->execute();

        $result = $stmt->get_result();
        $rows = $result->fetch_assoc();

        $stmt->close();

        return ['httpStatus' => 200, 'response' => $rows];
    }

    public function get_results()
    {
        $query = "SELECT
            user_response.user_id,
            user_profile.name AS person_name,
            user_profile.phone,
            user_profile.district,
            test.title AS test_title,
            COUNT(*) AS correct_questions_count,
            total_questions.total_questions_count,
            COUNT(*) * (test.total_marks / total_questions.total_questions_count) AS total_marks
            FROM
                user_response
            JOIN
                options ON user_response.selected_option_id = options.option_id
            JOIN
                (SELECT test_id, COUNT(*) AS total_questions_count FROM questions GROUP BY test_id) AS total_questions ON user_response.test_id = total_questions.test_id
            JOIN
                test ON user_response.test_id = test.test_id
            JOIN
                user_profile ON user_response.user_id = user_profile.user_id
            WHERE
                options.is_correct = 1
            GROUP BY
                user_response.user_id, user_profile.name, test.title, test.total_marks, total_questions.total_questions_count
        ";

        $stmt = $this->database->prepare($query);
        $stmt->execute();

        $result = $stmt->get_result();
        $rows = $result->fetch_all(MYSQLI_ASSOC);

        $stmt->close();

        return ['httpStatus' => 200, 'response' => $rows];
    }

    public function get_my_marks($test_id, $user_id)
    {
        $query = "SELECT 
            (correct_questions_count / total_questions_count) * t.total_marks AS total_marks_for_user
            FROM (
                SELECT 
                    COUNT(*) AS correct_questions_count
                FROM 
                    user_response ur
                JOIN 
                    options o ON ur.selected_option_id = o.option_id
                WHERE 
                    o.is_correct = 1
                AND 
                    ur.user_id = ?
                AND 
                    ur.test_id = ?
            ) AS correct_count,
            (
                SELECT 
                    COUNT(*) AS total_questions_count
                FROM 
                    questions q
                WHERE 
                    q.test_id = ?
            ) AS total_count,
            test t
            WHERE 
                t.test_id = ?
        ";

        $stmt = $this->database->prepare($query);
        $stmt->bind_param('iiii', $user_id, $test_id, $test_id, $test_id);
        $stmt->execute();

        $result = $stmt->get_result();
        $rows = $result->fetch_assoc();

        $stmt->close();

        return ['httpStatus' => 200, 'response' => $rows];
    }

    public function get_questions_for_test($test_id, $user_id)
    {
        $questions = []; // Initialize an array to store questions and options data

        // Query to fetch questions that the user has already attempted
        $attemptedQuestionsQuery = "SELECT question_id FROM user_response WHERE test_id = $test_id AND user_id = $user_id";
        $attemptedQuestionsResult = $this->database->query($attemptedQuestionsQuery);

        $attemptedQuestionIds = [];
        if ($attemptedQuestionsResult) {
            while ($row = $attemptedQuestionsResult->fetch_assoc()) {
                $attemptedQuestionIds[] = $row['question_id'];
            }
        }

        // Convert the array of attempted question IDs to a comma-separated string
        $attemptedQuestionIdsStr = implode(',', $attemptedQuestionIds);

        // Modify the main query to exclude attempted questions
        $query = "SELECT 
                q.question_id, 
                q.question_text, 
                o.option_id, 
                o.option_text 
            FROM 
                questions q 
            JOIN 
                options o 
            ON 
                q.question_id = o.question_id 
            WHERE 
                q.test_id = $test_id";

        if (!empty($attemptedQuestionIdsStr)) {
            $query .= " AND q.question_id NOT IN ($attemptedQuestionIdsStr)";
        }

        $query .= " ORDER BY q.question_id, o.option_id";

        // Execute the SQL query to fetch questions and options
        $result = $this->database->query($query);

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $questionId = $row['question_id'];
                $option = ['option_id' => $row['option_id'], 'option_text' => $row['option_text']];

                // Check if the question exists in the $questions array
                if (isset($questions[$questionId])) {
                    // Add the option to the existing question
                    $questions[$questionId]['options'][] = $option;
                } else {
                    // Create a new question entry
                    $questions[$questionId] = [
                        'question_id' => $questionId,
                        'question_text' => $row['question_text'],
                        'options' => [$option] // Start with the first option
                    ];
                }
            }
        }

        // Convert the associative array to indexed array
        $questions = array_values($questions);

        Request::send_response(200, $questions);
    }

    public function export_shortlist($district)
    {
        if (!empty($district)) {
            // Query with district filtering
            $query = "SELECT a.application_id, s.id AS shortlist_id, up.user_id, up.name, up.district, up.phone, jp.title, s.status, s.notes, s.created_at 
                  FROM shortlist s 
                  JOIN application a ON s.application_id = a.application_id
                  JOIN user_profile up ON up.user_id = a.applicant_id
                  JOIN job_positions jp ON jp.id = a.position_id
                  WHERE up.district = ?";

            // Prepare the statement
            $stmt = $this->database->prepare($query);

            // Bind the district parameter to the statement
            $stmt->bind_param('s', $district);
        } else {
            // Query without district filtering
            $query = "SELECT a.application_id, s.id AS shortlist_id, up.user_id, up.name, up.district, up.phone, jp.title, s.status, s.notes, s.created_at 
                  FROM shortlist s 
                  JOIN application a ON s.application_id = a.application_id
                  JOIN user_profile up ON up.user_id = a.applicant_id
                  JOIN job_positions jp ON jp.id = a.position_id";

            // Prepare the statement
            $stmt = $this->database->prepare($query);
        }

        // Execute the statement
        $stmt->execute();
        $result = $stmt->get_result();

        // Fetch all rows as an associative array
        $rows = $result->fetch_all(MYSQLI_ASSOC);

        // Close the statement
        $stmt->close();

        // Return the result with a 200 HTTP status
        return ['httpStatus' => 200, 'response' => $rows];
    }
}
