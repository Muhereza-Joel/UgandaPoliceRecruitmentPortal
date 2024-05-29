<?php

namespace controller;

use core\Request;
use model\UserResponse;

class ResponseController
{
    private $request;
    private $responseObject;

    public function __construct()
    {
        $this->request = new Request();
        $this->responseObject = new UserResponse();
    }

    public function create()
    {
        $result = $this->responseObject
            ->setUserId($this->request->input('user_id'))
            ->setTestId($this->request->input('test_id'))
            ->setQuestionId($this->request->input('question_id'))
            ->setSelectedOptionId($this->request->input('selected_option_id'))
            ->save();

        Request::send_response($result['httpStatus'], $result['response']);
    }

    public function read_all()
    {
        $result = $this->responseObject->all();
        Request::send_response($result['httpStatus'], $result['response']);
    }

    public function read_one()
    {
        $result = $this->responseObject->findOne($this->request->input('id'));
        Request::send_response($result['httpStatus'], $result['response']);
    }

    public function update()
    {
        $result = $this->responseObject
            ->setResponseId($this->request->input('id'))
            ->setUserId($this->request->input('user-id'))
            ->setTestId($this->request->input('test-id'))
            ->setQuestionId($this->request->input('question-id'))
            ->setSelectedOptionId($this->request->input('selected-option-id'))
            ->update();

        Request::send_response($result['httpStatus'], $result['response']);
    }

    public function delete()
    {
        $result = $this->responseObject->delete($this->request->input('id'));
        Request::send_response($result['httpStatus'], $result['response']);
    }
}
