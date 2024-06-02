<?php

namespace controller;

use core\BaseController;
use core\Session;
use model\JobPosition;
use model\Model;
use model\Question;
use model\ShortList;
use model\Test;
use model\User;
use view\BladeView;

class PageController
{
    private $app_name;
    private $app_name_full;
    private $app_base_url;
    private $blade_view;
    private $model;
    private $user_model;
    private $jobsModel;
    private $testModel;
    private $questionsModel;
    private $shortlistModel;

    public function __construct()
    {
        $this->app_name = getenv("APP_NAME");
        $this->app_name_full = getenv("APP_NAME_FULL");
        $this->app_base_url = getenv("APP_BASE_URL");
        $this->user_model = new User();
        $this->blade_view = new BladeView();
        $this->model = new Model();
        $this->jobsModel = new JobPosition();
        $this->testModel = new Test();
        $this->questionsModel = new Question();
        $this->shortlistModel = new ShortList();
    }

    public function render_404()
    {
        $html = $this->blade_view->render('404', [
            'pageTitle' => " $this->app_name page not found",
            'appName' => $this->app_name,
            'baseUrl' => $this->app_base_url,
            'appNameFull' => $this->app_name_full,
            'username' => Session::get('username'),
            'role' => Session::get('role'),
            'avator' => Session::get('avator'),

        ]);

        echo ($html);
    }

    public function render_dashboard()
    {

        $html = $this->blade_view->render('dashboard', [
            'pageTitle' => " $this->app_name dashboard",
            'appName' => $this->app_name,
            'baseUrl' => $this->app_base_url,
            'appNameFull' => $this->app_name_full,
            'username' => Session::get('username'),
            'role' => Session::get('role'),
            'avator' => Session::get('avator'),

        ]);

        echo ($html);
    }

    public function render_jobs($action = null)
    {

        $jobs = $this->jobsModel->all();

        $html = $this->blade_view->render('jobs', [
            'pageTitle' => " $this->app_name jobs",
            'appName' => $this->app_name,
            'baseUrl' => $this->app_base_url,
            'appNameFull' => $this->app_name_full,
            'username' => Session::get('username'),
            'role' => Session::get('role'),
            'avator' => Session::get('avator'),
            'action' => $action,
            'listing' => $jobs['response'],

        ]);

        echo ($html);
    }

    public function render_job_details($action = null, $id = null)
    {

        $job = $this->jobsModel->findOne($id);

        $html = $this->blade_view->render('jobDetails', [
            'pageTitle' => " $this->app_name jobs",
            'appName' => $this->app_name,
            'baseUrl' => $this->app_base_url,
            'appNameFull' => $this->app_name_full,
            'username' => Session::get('username'),
            'role' => Session::get('role'),
            'avator' => Session::get('avator'),
            'action' => $action,
            'job' => $job['response'],

        ]);

        echo ($html);
    }

    public function render_job_apply($id = null)
    {

        $job = $this->jobsModel->findOne($id);
        $userDetails = $this->user_model->get_all_user_data(Session::get('user_id'));

        $html = $this->blade_view->render('apply', [
            'pageTitle' => " $this->app_name apply now",
            'appName' => $this->app_name,
            'baseUrl' => $this->app_base_url,
            'appNameFull' => $this->app_name_full,
            'username' => Session::get('username'),
            'role' => Session::get('role'),
            'avator' => Session::get('avator'),
            'job' => $job['response'],
            'userDetails' => $userDetails

        ]);

        echo ($html);
    }

    public function render_job_positions()
    {
        $html = $this->blade_view->render('jobPositions', [
            'pageTitle' => " $this->app_name job positions",
            'appName' => $this->app_name,
            'baseUrl' => $this->app_base_url,
            'appNameFull' => $this->app_name_full,
            'username' => Session::get('username'),
            'role' => Session::get('role'),
            'avator' => Session::get('avator'),

        ]);

        echo ($html);
    }

    public function render_applications()
    {

        $result = $this->model->get_all_applications();

        $html = $this->blade_view->render('applications', [
            'pageTitle' => " $this->app_name applications",
            'appName' => $this->app_name,
            'baseUrl' => $this->app_base_url,
            'appNameFull' => $this->app_name_full,
            'username' => Session::get('username'),
            'role' => Session::get('role'),
            'avator' => Session::get('avator'),
            'applications' => $result['response'],

        ]);

        echo ($html);
    }

    public function render_create_shortlist($application_id, $applicant_id, $position_id)
    {
        $userDetails = $this->model->get_user_details($applicant_id);
        $jobDetails = $this->jobsModel->findOne($position_id);

        $html = $this->blade_view->render('createShortlist', [
            'pageTitle' => " $this->app_name applications",
            'appName' => $this->app_name,
            'baseUrl' => $this->app_base_url,
            'appNameFull' => $this->app_name_full,
            'username' => Session::get('username'),
            'role' => Session::get('role'),
            'avator' => Session::get('avator'),
            'applicationId' => $application_id,
            'userDetails' => $userDetails['response'],
            'jobDetails' => $jobDetails['response'],

        ]);

        echo ($html);
    }

    public function render_my_applications()
    {

        $result = $this->model->get_user_applications();

        $html = $this->blade_view->render('applications', [
            'pageTitle' => " $this->app_name applications",
            'appName' => $this->app_name,
            'baseUrl' => $this->app_base_url,
            'appNameFull' => $this->app_name_full,
            'username' => Session::get('username'),
            'role' => Session::get('role'),
            'avator' => Session::get('avator'),
            'applications' => $result['response'],

        ]);

        echo ($html);
    }

    public function render_shortlist()
    {
        $result = $this->model->get_shortlist();

        $html = $this->blade_view->render('shortlist', [
            'pageTitle' => " $this->app_name shortlist",
            'appName' => $this->app_name,
            'baseUrl' => $this->app_base_url,
            'appNameFull' => $this->app_name_full,
            'username' => Session::get('username'),
            'role' => Session::get('role'),
            'avator' => Session::get('avator'),
            'shortlist' => $result['response'],

        ]);

        echo ($html);
    }

    public function render_assign_exam($id)
    {
        $tests = $this->testModel->all();
        $job = $this->jobsModel->findOne($id);
        $jobAssignment = $this->model->get_job_test_assignments($id);
        
        $html = $this->blade_view->render('assignTest', [
            'pageTitle' => " $this->app_name shortlist",
            'appName' => $this->app_name,
            'baseUrl' => $this->app_base_url,
            'appNameFull' => $this->app_name_full,
            'username' => Session::get('username'),
            'role' => Session::get('role'),
            'avator' => Session::get('avator'),
            'tests' => $tests['response'],
            'job' => $job['response'],
            'jobAssignment' => $jobAssignment['response'],


        ]);

        echo ($html);
    }

    public function render_user_shortlist()
    {
        $result = $this->model->get_user_shortlist();

        $html = $this->blade_view->render('shortlist', [
            'pageTitle' => " $this->app_name shortlist",
            'appName' => $this->app_name,
            'baseUrl' => $this->app_base_url,
            'appNameFull' => $this->app_name_full,
            'username' => Session::get('username'),
            'role' => Session::get('role'),
            'avator' => Session::get('avator'),
            'shortlist' => $result['response'],

        ]);

        echo ($html);
    }

    public function render_manage_exams()
    {

        $tests = $this->testModel->all();

        $html = $this->blade_view->render('manageExam', [
            'pageTitle' => " $this->app_name manageExam",
            'appName' => $this->app_name,
            'baseUrl' => $this->app_base_url,
            'appNameFull' => $this->app_name_full,
            'username' => Session::get('username'),
            'role' => Session::get('role'),
            'avator' => Session::get('avator'),
            'tests' => $tests['response'],

        ]);

        echo ($html);
    }

    public function render_add_questions($test_id = null)
    {

        $test = $this->testModel->findOne($test_id);
        $test_questions = $this->questionsModel->all($test_id);

        $html = $this->blade_view->render('addQuestion', [
            'pageTitle' => " $this->app_name manageExam",
            'appName' => $this->app_name,
            'baseUrl' => $this->app_base_url,
            'appNameFull' => $this->app_name_full,
            'username' => Session::get('username'),
            'role' => Session::get('role'),
            'avator' => Session::get('avator'),
            'test-id' => $test_id,
            'test' => $test['response'],
            'questions' => $test_questions['response'],

        ]);

        echo ($html);
    }

    public function render_users()
    {
        $html = $this->blade_view->render('users', [
            'pageTitle' => " $this->app_name users",
            'appName' => $this->app_name,
            'baseUrl' => $this->app_base_url,
            'appNameFull' => $this->app_name_full,
            'username' => Session::get('username'),
            'role' => Session::get('role'),
            'avator' => Session::get('avator'),

        ]);

        echo ($html);
    }

    public function render_apply()
    {
        $html = $this->blade_view->render('createApplication', [
            'pageTitle' => " $this->app_name create job application",
            'appName' => $this->app_name,
            'baseUrl' => $this->app_base_url,
            'appNameFull' => $this->app_name_full,
            'username' => Session::get('username'),
            'role' => Session::get('role'),
            'avator' => Session::get('avator'),

        ]);

        echo ($html);
    }

    public function render_start_exam()
    {
        $my_test = $this->model->get_my_test();

        $html = $this->blade_view->render('apptitude', [
            'pageTitle' => " $this->app_name exam",
            'appName' => $this->app_name,
            'baseUrl' => $this->app_base_url,
            'appNameFull' => $this->app_name_full,
            'username' => Session::get('username'),
            'role' => Session::get('role'),
            'avator' => Session::get('avator'),
            'myTest' => $my_test['response'],
            'user_id' => Session::get('user_id'),
        ]);

        echo ($html);
    }

    public function render_results_view()
    {
        $results = $this->model->get_results();

        $html = $this->blade_view->render('results', [
            'pageTitle' => " $this->app_name exam",
            'appName' => $this->app_name,
            'baseUrl' => $this->app_base_url,
            'appNameFull' => $this->app_name_full,
            'username' => Session::get('username'),
            'role' => Session::get('role'),
            'avator' => Session::get('avator'),
            'results' => $results['response'],
            'user_id' => Session::get('user_id'),
        ]);

        echo ($html);
    }

    public function render_attempt_exam($id, $time)
    {

        $html = $this->blade_view->render('attemptExam', [
            'pageTitle' => " $this->app_name exam",
            'appName' => $this->app_name,
            'baseUrl' => $this->app_base_url,
            'appNameFull' => $this->app_name_full,
            'username' => Session::get('username'),
            'role' => Session::get('role'),
            'avator' => Session::get('avator'),
            'test_id' => $id,
            'user_id' => Session::get('user_id'),
            'time' => $time,
            
        ]);

        echo ($html);
    }

    public function render_mail($shortlist_id, $applicant_id)
    {
        $shortListDetails = $this->shortlistModel->findOne($shortlist_id);
        $userDetails = $this->model->get_user_details($applicant_id);

        $html = $this->blade_view->render('mail', [
            'pageTitle' => " $this->app_name exam",
            'appName' => $this->app_name,
            'baseUrl' => $this->app_base_url,
            'appNameFull' => $this->app_name_full,
            'username' => Session::get('username'),
            'role' => Session::get('role'),
            'avator' => Session::get('avator'),
            'shortlist' => $shortListDetails['response'],
            'userDetails' => $userDetails['response'],

        ]);

        echo ($html);
    }

    public function render_shortlist_report_view()
    {
        $result = $this->model->get_shortlist();

        $html = $this->blade_view->render('shortListReport', [
            'pageTitle' => " $this->app_name exam",
            'appName' => $this->app_name,
            'baseUrl' => $this->app_base_url,
            'appNameFull' => $this->app_name_full,
            'username' => Session::get('username'),
            'role' => Session::get('role'),
            'avator' => Session::get('avator'),
            'shortlist' => $result['response'],
        ]);

        echo ($html);
    }

    public function render_view_application($application_id)
    {
        $result = $this->model->get_application_details($application_id);

        $html = $this->blade_view->render('viewApplication', [
            'pageTitle' => " $this->app_name view application details",
            'appName' => $this->app_name,
            'baseUrl' => $this->app_base_url,
            'appNameFull' => $this->app_name_full,
            'username' => Session::get('username'),
            'role' => Session::get('role'),
            'avator' => Session::get('avator'),
            'application' => $result['response'],
        ]);

        echo ($html);
    }
}
