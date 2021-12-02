<?php
namespace App\Core\Service\Response;


use App\Help\Core\Service\Response\MessageType;
use Illuminate\Support\Collection;

class BasicResponse
{
    private Collection $_messageList;

    private int $_status;

    public Collection $_messageResponses;

    public function __construct()
    {
        $this->_messageResponses = new Collection();

        $this->_status = 200;
    }

    /**
     * @return Collection
     */
    public function messageCollection(): Collection
    {
        return $this->_messageList ?? ($this->_messageList = new Collection());
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->_status;
    }

    /**
     * @param int $status
     */
    public function setStatus(int $status): void
    {
        $this->_status = $status;
    }

    public function isError(): bool
    {
        return $this->_messageResponses->filter(function($item) {
            return $item->type->getValue() == MessageType::ERROR()->getValue();
        })->count() > 0;
    }

    public function isContainInfo(): bool
    {
        return $this->_messageResponses->filter(function($item) {
            return $item->type->getValue() == MessageType::INFO()->getValue();
        })->count() > 0;
    }

    public function getMessageResponseTextArray(): array
    {
        $response = new Collection();

        $this->_messageResponses->each(function($item, $key) use($response) {
            $response->push($item->text);
        })->all();

        return $response->toArray();
    }

    public function getMessageResponseErrorTextArray(): array
    {
        $response = new Collection();

        $this->_messageResponses->each(function($item, $key) use($response) {
            if($item->type->getValue() == MessageType::ERROR())
                $response->push($item->text);
        })->all();

        return $response->toArray();
    }

    public function getMessageResponseInfoTextArray(): array
    {
        $response = new Collection();

        $this->_messageResponses->each(function($item, $key) use($response) {
            if($item->type->getValue() == MessageType::INFO())
                $response->push($item->text);
        })->all();

        return $response->toArray();
    }

    public function addErrorMessageResponse(string $errorMessageResponse)
    {
        $this->_messageResponses->push(
            new MessageResponse(MessageType::ERROR(),
                $errorMessageResponse)
        );
    }

    public function addInfoMessageResponse(string $infoMessageResponse)
    {
        $this->_messageResponses->push(
            new MessageResponse(MessageType::INFO(),
                $infoMessageResponse)
        );
    }
}
