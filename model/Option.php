<?php

namespace model;

class Option
{

    private $optionId;
    private $questionId;
    private $optionText;
    private $isCorrect;
    private $optionModel;

    public function __construct()
    {
        $this->optionModel = new OptionModel();
    }

    public function getOptionId()
    {
        return $this->optionId;
    }

    public function getQuestionId()
    {
        return $this->questionId;
    }

    public function getOptionText()
    {
        return $this->optionText;
    }

    public function getIsCorrect()
    {
        return $this->isCorrect;
    }

    public function setOptionId($optionId)
    {
        $this->optionId = $optionId;
        return $this;
    }

    public function setQuestionId($questionId)
    {
        $this->questionId = $questionId;
        return $this;
    }

    public function setOptionText($optionText)
    {
        $this->optionText = $optionText;
        return $this;
    }

    public function setIsCorrect($isCorrect)
    {
        $this->isCorrect = $isCorrect;
        return $this;
    }

    public function save()
    {
        return $this->optionModel->create($this);
    }

    public function all($id)
    {
        return $this->optionModel->readAll($id);
    }

    public function findOne($id)
    {
        return $this->optionModel->readOne($id);
    }

    public function update()
    {
        return $this->optionModel->update($this);
    }

    public function delete($id)
    {
        return $this->optionModel->delete($id);
    }
}
