<?php
namespace controller;

use core\Request;
use model\Option;

class OptionsController{

    private $request;
    private $optionObject;

    public function __construct()
    {
        $this->request = new Request();
        $this->optionObject = new Option();
    }

    public function create()
    {
        $result = $this->optionObject
            ->setQuestionId($this->request->input('question-id'))
            ->setOptionText($this->request->input('option-text'))
            ->setIsCorrect($this->request->input('is-correct'))
            ->save();

        Request::send_response($result['httpStatus'], $result['response']);
    }

    public function read_all()
    {
        $result = $this->optionObject->all($this->request->input('question-id'));
        Request::send_response($result['httpStatus'], $result['response']);
    }

    public function read_one()
    {
        $result = $this->optionObject->findOne($this->request->input('id'));
        Request::send_response($result['httpStatus'], $result['response']);
    }

    public function update()
    {
        $result = $this->optionObject
            ->setOptionId($this->request->input('id'))
            ->setQuestionId($this->request->input('question-id'))
            ->setOptionText($this->request->input('option-text'))
            ->setIsCorrect($this->request->input('is-correct'))
            ->update();

        Request::send_response($result['httpStatus'], $result['response']);
    }

    public function delete()
    {
        $result = $this->optionObject->delete($this->request->input('id'));
        Request::send_response($result['httpStatus'], $result['response']);
    }
}
?>