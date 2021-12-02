<?php


namespace App\Service\Contracts\Media\Request;


use App\Core\Service\Request\AuditableRequest;

class FileUploadRequest extends AuditableRequest
{
    public $file;

    /**
     * @return mixed
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param mixed $file
     */
    public function setFile($file): void
    {
        $this->file = $file;
    }
}
