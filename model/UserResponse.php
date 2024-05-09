<?php

namespace model;

class UserResponse
{

    private $responseId;
    private $userId;
    private $testId;
    private $questionId;
    private $selectedOptionId;
    private $userResponseModel;

    public function __construct()
    {
        $this->userResponseModel = new UserResponseModel();
    }

    public function getResponseId()
    {
        return $this->responseId;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function getTestId()
    {
        return $this->testId;
    }

    public function getQuestionId()
    {
        return $this->questionId;
    }

    public function getSelectedOptionId()
    {
        return $this->selectedOptionId;
    }

    public function setResponseId($responseId)
    {
        $this->responseId = $responseId;
        return $this;
    }

    public function setUserId($userId)
    {
        $this->userId = $userId;
        return $this;
    }

    public function setTestId($testId)
    {
        $this->testId = $testId;
        return $this;
    }

    public function setQuestionId($questionId)
    {
        $this->questionId = $questionId;
        return $this;
    }

    public function setSelectedOptionId($selectedOptionId)
    {
        $this->selectedOptionId = $selectedOptionId;
        return $this;
    }

    public function save()
    {
        return $this->userResponseModel->create($this);
    }

    public function all()
    {
        return $this->userResponseModel->readAll();
    }

    public function findOne($id)
    {
        return $this->userResponseModel->readOne($id);
    }

    public function update()
    {
        return $this->userResponseModel->update($this);
    }

    public function delete($id)
    {
        return $this->userResponseModel->delete($id);
    }
}
