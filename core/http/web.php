<?php

use core\Route;

$app_name = getenv("APP_NAME");

// Routes for the auth controller
Route::post("/$app_name/", "controller\AuthController@index");
Route::post("/$app_name/auth/register/", "controller\AuthController@render_register_view");
Route::post("/$app_name/auth/login/", "controller\AuthController@index");
Route::post("/$app_name/auth/create-profile/", "controller\AuthController@render_create_profile_view");
Route::post("/$app_name/auth/login/sign-in/", "controller\AuthController@sign_in_user");
Route::post("/$app_name/auth/create-account/", "controller\AuthController@create_account");
Route::post("/$app_name/image-upload/", "controller\AuthController@upload_photo");
Route::post("/$app_name/file-upload/", "controller\AuthController@upload_pdf");
Route::post("/$app_name/auth/check-nin/", "controller\AuthController@check_nin");
Route::post("/$app_name/auth/check-email/", "controller\AuthController@check_email");
Route::post("/$app_name/auth/check-password/", "controller\AuthController@check_password");
Route::post("/$app_name/auth/change-password/", "controller\AuthController@change_password");
Route::post("/$app_name/auth/save-profile/", "controller\AuthController@save_profile");
Route::post("/$app_name/auth/update-profile/", "controller\AuthController@update_profile");
Route::post("/$app_name/auth/user/profile/update-photo/", "controller\AuthController@update_photo");
Route::post("/$app_name/auth/sign-out/", "controller\AuthController@sign_out");
Route::post("/$app_name/auth/user/profile/", "controller\AuthController@render_show_profile_view");
Route::post("/$app_name/auth/users/", "controller\AuthController@get_system_users");
Route::post("/$app_name/auth/users/get-user-details/", "controller\AuthController@get_user_details");


//Routes for PageController
Route::post("/$app_name/page-not-found/", "controller\PageController@render_404");
Route::post("/$app_name/dashboard/", "controller\PageController@render_dashboard");
Route::post("/$app_name/job-positions/", "controller\PageController@render_job_positions");
Route::post("/$app_name/job-positions/listing/", "controller\PageController@render_jobs");
Route::post("/$app_name/job-positions/listing/view", "controller\PageController@render_job_details");
Route::post("/$app_name/job-positions/listing/assign-exam", "controller\PageController@render_assign_exam");
Route::post("/$app_name/job-positions/listing/apply", "controller\PageController@render_job_apply");
Route::post("/$app_name/applications/", "controller\PageController@render_applications");
Route::post("/$app_name/applications/create-shortlist", "controller\PageController@render_create_shortlist");
Route::post("/$app_name/my-applications/", "controller\PageController@render_my_applications");
Route::post("/$app_name/shortlist/", "controller\PageController@render_shortlist");
Route::post("/$app_name/shortlist/mail", "controller\PageController@render_mail");
Route::post("/$app_name/u/shortlist/", "controller\PageController@render_user_shortlist");
Route::post("/$app_name/exam/", "controller\PageController@render_start_exam");
Route::post("/$app_name/apply/", "controller\PageController@render_apply");
Route::post("/$app_name/manage-exams/", "controller\PageController@render_manage_exams");
Route::post("/$app_name/manage-exams/test/add-questions", "controller\PageController@render_add_questions");
Route::post("/$app_name/users/", "controller\PageController@render_users");
Route::post("/$app_name/exam/attempt", "controller\PageController@render_attempt_exam");
Route::post("/$app_name/exams/results/", "controller\PageController@render_results_view");
Route::post("/$app_name/reports/shortlist/", "controller\PageController@render_shortlist_report_view");


//Routes for jobs controller
Route::post("/$app_name/jobs/create/", "controller\JobsController@create");
Route::post("/$app_name/jobs/applications/create/", "controller\JobsController@applications_create");
Route::post("/$app_name/jobs/applications/update-status/", "controller\JobsController@update_application_status");
Route::post("/$app_name/jobs/", "controller\JobsController@read_all");
Route::post("/$app_name/jobs/read-one/", "controller\JobsController@read_one");
Route::post("/$app_name/jobs/update/", "controller\JobsController@update");
Route::post("/$app_name/jobs/delete/", "controller\JobsController@delete");
Route::post("/$app_name/jobs/assign-test/", "controller\JobsController@assign_test");
Route::post("/$app_name/jobs/drop-test/", "controller\JobsController@drop_test");


//Routes for shortlist Controller
Route::post("/$app_name/shortlist/create/", "controller\ShortlistController@create");
Route::post("/$app_name/shortlist/all/", "controller\ShortlistController@read_all");
Route::post("/$app_name/shortlist/read-one/", "controller\ShortlistController@read_one");
Route::post("/$app_name/shortlist/update/", "controller\ShortlistController@update");
Route::post("/$app_name/shortlist/delete/", "controller\ShortlistController@delete");

//Routes for test Controller
Route::post("/$app_name/test/create/", "controller\TestController@create");
Route::post("/$app_name/test/all/", "controller\TestController@read_all");
Route::post("/$app_name/test/read-one/", "controller\TestController@read_one");
Route::post("/$app_name/test/update/", "controller\TestController@update");
Route::post("/$app_name/test/delete/", "controller\TestController@delete");
Route::post("/$app_name/test/questions/", "controller\TestController@get_questions");
Route::post("/$app_name/test/my-marks/", "controller\TestController@get_my_marks");

//Routes for questions Controller
Route::post("/$app_name/questions/create/", "controller\QuestionsController@create");
Route::post("/$app_name/questions/all/", "controller\QuestionsController@read_all");
Route::post("/$app_name/questions/read-one/", "controller\QuestionsController@read_one");
Route::post("/$app_name/questions/update/", "controller\QuestionsController@update");
Route::post("/$app_name/questions/delete/", "controller\QuestionsController@delete");

//Routes for options Controller
Route::post("/$app_name/options/create/", "controller\OptionsController@create");
Route::post("/$app_name/options/all/", "controller\OptionsController@read_all");
Route::post("/$app_name/options/read-one/", "controller\OptionsController@read_one");
Route::post("/$app_name/options/update/", "controller\OptionsController@update");
Route::post("/$app_name/options/delete/", "controller\OptionsController@delete");

//Routes for options Controller
Route::post("/$app_name/responses/create/", "controller\ResponseController@create");

//Routes for mail controller
Route::post("/$app_name/mail/create/", "controller\MailController@send_mail");

//Routes for reports controller
Route::post("/$app_name/pdf/shortlist/export/", "controller\ReportsController@export_shortlist_report");

?>
