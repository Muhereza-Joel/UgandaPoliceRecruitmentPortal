<?php

namespace controller;

use core\Request;
use model\JobPosition;
use model\Model;

class JobsController
{

    private $request;
    private $jobObject;
    private $model;

    public function __construct()
    {
        $this->request = new Request();
        $this->jobObject = new JobPosition();
        $this->model = new Model();
    }

    public function create()
    {
        $result = $this->jobObject
            ->setTitle($this->request->input('title'))
            ->setDescription($this->request->input('description'))
            ->setRequirements($this->request->input('requirements'))
            ->setResponsibilities($this->request->input('responsibilities'))
            ->save();
            
        Request::send_response($result['httpStatus'], $result['response']);
    }

    public function applications_create($position_id){
        $result = $this->model->create_application($position_id);
        Request::send_response($result['httpStatus'], $result['response']);
    }

    public function read_all()
    {
        $result = $this->jobObject->all();
        Request::send_response($result['httpStatus'], $result['response']);
    }

    public function read_one()
    {
        $result = $this->jobObject->findOne($this->request->input('id'));
        Request::send_response($result['httpStatus'], $result['response']);
    }

    public function update()
    {
        $result = $this->jobObject
            ->setId($this->request->input('id'))
            ->setTitle($this->request->input('title'))
            ->setDescription($this->request->input('description'))
            ->setRequirements($this->request->input('requirements'))
            ->setResponsibilities($this->request->input('responsibilities'))
            ->update();

        Request::send_response($result['httpStatus'], $result['response']);
    }

    public function delete()
    {
        $result = $this->jobObject->delete($this->request->input('id'));
        Request::send_response($result['httpStatus'], $result['response']);
    }
}
