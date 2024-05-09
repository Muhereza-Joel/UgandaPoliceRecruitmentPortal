<?php

namespace model;

class Question
{

    private $questionId;
    private $testId;
    private $questionText;
    private $questionModel;

    public function __construct()
    {
        $this->questionModel = new QuestionModel();
    }

    public function getQuestionId()
    {
        return $this->questionId;
    }

    public function getTestId()
    {
        return $this->testId;
    }

    public function getQuestionText()
    {
        return $this->questionText;
    }

    public function setQuestionId($questionId)
    {
        $this->questionId = $questionId;
        return $this;
    }

    public function setTestId($testId)
    {
        $this->testId = $testId;
        return $this;
    }

    public function setQuestionText($questionText)
    {
        $this->questionText = $questionText;
        return $this;
    }

    public function save()
    {
        return $this->questionModel->create($this);
    }

    public function all($id)
    {
        return $this->questionModel->readAll($id);
    }

    public function findOne($id)
    {
        return $this->questionModel->readOne($id);
    }

    public function update()
    {
        return $this->questionModel->update($this);
    }

    public function delete($id)
    {
        return $this->questionModel->delete($id);
    }
}
