<?php

namespace model;

class Test
{

    private $id;
    private $title;
    private $description;
    private $duration;
    private $totalMarks;
    private $testModel;

    public function __construct()
    {
        $this->testModel = new TestModel();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getDuration()
    {
        return $this->duration;
    }

    public function getTotalMarks()
    {
        return $this->totalMarks;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    public function setDuration($duration)
    {
        $this->duration = $duration;
        return $this;
    }

    public function setTotalMarks($totalMarks)
    {
        $this->totalMarks = $totalMarks;
        return $this;
    }

    public function save()
    {
        return $this->testModel->create($this);
    }

    public function all()
    {
        return $this->testModel->readAll();
    }

    public function findOne($id)
    {
        return $this->testModel->readOne($id);
    }

    public function update()
    {
        return $this->testModel->update($this);
    }

    public function delete($id)
    {
        return $this->testModel->delete($id);
    }
}
