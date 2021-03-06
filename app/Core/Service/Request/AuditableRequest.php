<?php
namespace App\Core\Service\Request;


abstract class AuditableRequest
{
    public ?string $request_by;

    public function getRequestBy(): string
    {
        return $this->request_by;
    }

    public function setRequestBy(string $request_by): void
    {
        $this->request_by = $request_by;
    }
}
