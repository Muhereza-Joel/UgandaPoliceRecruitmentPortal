<?php
namespace controller;

use core\Request;
use model\Question;

class QuestionsController{

    private $request;
    private $questionObject;

    public function __construct()
    {
        $this->request = new Request();
        $this->questionObject = new Question();
    }


    public function create()
    {
        $result = $this->questionObject
            ->setTestId($this->request->input('test-id'))
            ->setQuestionText($this->request->input('question-text'))
            ->save();

        Request::send_response($result['httpStatus'], $result['response']);
    }

    public function read_all()
    {
        $result = $this->questionObject->all($this->request->input('test-id'));
        Request::send_response($result['httpStatus'], $result['response']);
    }

    public function read_one()
    {
        $result = $this->questionObject->findOne($this->request->input('id'));
        Request::send_response($result['httpStatus'], $result['response']);
    }

    public function update()
    {
        $result = $this->questionObject
            ->setQuestionId($this->request->input('id'))
            ->setTestId($this->request->input('test-id'))
            ->setQuestionText($this->request->input('question-text'))
            ->update();

        Request::send_response($result['httpStatus'], $result['response']);
    }

    public function delete()
    {
        $result = $this->questionObject->delete($this->request->input('id'));
        Request::send_response($result['httpStatus'], $result['response']);
    }
}
?>