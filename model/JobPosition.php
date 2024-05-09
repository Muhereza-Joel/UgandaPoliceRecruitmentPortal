<?php

namespace model;

class JobPosition
{
    private $title;
    private $description;
    private $requirements;
    private $responsibilities;
    private $id;
    private $jobPositionModel;

    public function __construct()
    {
        $this->jobPositionModel = new JobPositionModel();
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getRequirements()
    {
        return $this->requirements;
    }

    public function getResponsibilities()
    {
        return $this->responsibilities;
    }

    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    public function setRequirements($requirements)
    {
        $this->requirements = $requirements;
        return $this;
    }

    public function setResponsibilities($responsibilities)
    {
        $this->responsibilities = $responsibilities;
        return $this;
    }

    public function save()
    {
        return $this->jobPositionModel->create($this);
    }

    public function all()
    {
        return $this->jobPositionModel->readAll();
    }

    public function findOne($id)
    {
        return $this->jobPositionModel->readOne($id);
    }

    public function update()
    {
        return $this->jobPositionModel->update($this);
    }

    public function delete($id)
    {
        return $this->jobPositionModel->delete($id);
    }
}
