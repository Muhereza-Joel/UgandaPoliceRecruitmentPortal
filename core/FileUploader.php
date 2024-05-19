<?php

namespace core;

class FileUploader
{
    private $fileField;
    private $fileIndex;
    private $fileName;
    private $savePath;

    public function __construct($fileField, $fileIndex = 0) {
        $this->fileField = $fileField;
        $this->fileIndex = $fileIndex;

        if (is_array($_FILES[$fileField]['name'])) {
            $this->fileName = $_FILES[$fileField]['name'][$fileIndex];
        } else {
            $this->fileName = $_FILES[$fileField]['name'];
        }
    }

    public function save_in($path) {
        $this->savePath = $path;
    }

    public function save() {
        if (is_array($_FILES[$this->fileField]['tmp_name'])) {
            $tempName = $_FILES[$this->fileField]['tmp_name'][$this->fileIndex];
        } else {
            $tempName = $_FILES[$this->fileField]['tmp_name'];
        }
        return move_uploaded_file($tempName, $this->savePath . $this->fileName);
    }

    public function get_file_name() {
        return $this->fileName;
    }
}
