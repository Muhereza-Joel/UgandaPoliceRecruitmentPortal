<?php

namespace controller;

use core\Request;
use model\JobPosition;

class JobsController
{

    private $request;
    private $jobObject;

    public function __construct()
    {
        $this->request = new Request();
        $this->jobObject = new JobPosition();
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
