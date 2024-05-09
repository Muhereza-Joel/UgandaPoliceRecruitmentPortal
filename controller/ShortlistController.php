<?php

namespace controller;

use core\Request;
use model\ShortList;

class ShortlistController
{

    private $request;
    private $shortListObject;

    public function __construct()
    {
        $this->request = new Request();
        $this->shortListObject = new ShortList();
    }

    public function create()
    {
        $result = $this->shortListObject
            ->setApplicationId($this->request->input('application-id'))
            ->setStatus('shortlisted')
            ->setNotes($this->request->input('notes'))
            ->save();

        Request::send_response($result['httpStatus'], $result['response']);
    }

    public function read_all()
    {
        $result = $this->shortListObject->all();
        Request::send_response($result['httpStatus'], $result['response']);
    }

    public function read_one()
    {
        $result = $this->shortListObject->findOne($this->request->input('id'));
        Request::send_response($result['httpStatus'], $result['response']);
    }

    public function update()
    {
        $result = $this->shortListObject
            ->setId($this->request->input('id'))
            ->setApplicationId($this->request->input('application-id'))
            ->setStatus($this->request->input('status'))
            ->setNotes($this->request->input('notes'))
            ->update();

        Request::send_response($result['httpStatus'], $result['response']);
    }

    public function delete()
    {
        $result = $this->shortListObject->delete($this->request->input('id'));
        Request::send_response($result['httpStatus'], $result['response']);
    }
}
