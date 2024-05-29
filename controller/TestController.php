<?php

namespace controller;

use core\Request;
use model\Model;
use model\Test;

class TestController
{

    private $request;
    private $testObject;
    private $model;

    public function __construct()
    {
        $this->request = new Request();
        $this->testObject = new Test();
        $this->model = new Model();
    }
    public function create()
    {
        $result = $this->testObject
            ->setTitle($this->request->input('title'))
            ->setDescription($this->request->input('description'))
            ->setDuration($this->request->input('duration'))
            ->setTotalMarks($this->request->input('total-marks'))
            ->save();

        Request::send_response($result['httpStatus'], $result['response']);
    }

    public function read_all()
    {
        $result = $this->testObject->all();
        Request::send_response($result['httpStatus'], $result['response']);
    }

    public function read_one()
    {
        $result = $this->testObject->findOne($this->request->input('id'));
        Request::send_response($result['httpStatus'], $result['response']);
    }

    public function update()
    {
        $result = $this->testObject
            ->setId($this->request->input('id'))
            ->setTitle($this->request->input('title'))
            ->setDescription($this->request->input('description'))
            ->setDuration($this->request->input('duration'))
            ->setTotalMarks($this->request->input('total-marks'))
            ->update();

        Request::send_response($result['httpStatus'], $result['response']);
    }

    public function delete()
    {
        $result = $this->testObject->delete($this->request->input('id'));
        Request::send_response($result['httpStatus'], $result['response']);
    }

    public function get_questions($test_id, $user_id)
    {
        $this->model->get_questions_for_test($test_id, $user_id);
    }

    public function get_my_marks($test_id, $user_id)
    {
        $result = $this->model->get_my_marks($test_id, $user_id);
        Request::send_response($result['httpStatus'], $result['response']);
    }
}
