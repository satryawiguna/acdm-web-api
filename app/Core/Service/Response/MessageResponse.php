<?php
namespace App\Core\Service\Response;


use App\Help\Core\Service\Response\MessageType;

class MessageResponse
{
    public MessageType $type;

    public string $text;

    /**
     * MessageResponse constructor.
     * @param MessageType $type
     * @param string $text
     */
    public function __construct(MessageType $type, string $text)
    {
        $this->type = $type;
        $this->text = $text;
    }

    /**
     * @return MessageType
     */
    public function getType(): MessageType
    {
        return $this->type;
    }

    /**
     * @param MessageType $type
     */
    public function setType(MessageType $type): void
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText(string $text): void
    {
        $this->text = $text;
    }
}
