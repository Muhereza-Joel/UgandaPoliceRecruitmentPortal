<?php

namespace model;

class ShortList
{

    private $id;
    private $applicationId;
    private $status;
    private $notes;
    private $shortListModel;

    public function __construct()
    {
        $this->shortListModel = new ShortListModel();
    }

    public function getId()
    {
        return $this->id;
    }
    
    public function getApplicationId()
    {
        return $this->applicationId;
    }
    
    public function getStatus()
    {
        return $this->status;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }


    public function setApplicationId($applicationId)
    {
        $this->applicationId = $applicationId;
        return $this;
    }



    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    public function getNotes()
    {
        return $this->notes;
    }

    public function setNotes($notes)
    {
        $this->notes = $notes;
        return $this;
    }

    public function save()
    {
        return $this->shortListModel->create($this);
    }

    public function all()
    {
        return $this->shortListModel->readAll();
    }

    public function findOne($id)
    {
        return $this->shortListModel->readOne($id);
    }

    public function update()
    {
        return $this->shortListModel->update($this);
    }

    public function delete($id)
    {
        return $this->shortListModel->delete($id);
    }
}
