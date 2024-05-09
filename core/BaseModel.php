<?php
namespace core;


interface BaseModel{

    public function create();

    public function read_all();

    public function read_one($id);

    public function update($id);

    public function delete($id);

}
?>