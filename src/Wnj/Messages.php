<?php

namespace Wnj;

/**
 * @author Diego Cabrejas <dcabrejas@icloud.com>
 */
class Messages
{
    const KEY = 'messages';
    const TYPE_SUCCESS = 'success';
    const TYPE_ERROR   = 'error';

    /**
     * Messages constructor.
     */
    public function __construct()
    {
        if (!isset($_SESSION[self::KEY]) || !is_array($_SESSION[self::KEY])) {
            $_SESSION[self::KEY] = [];
        }
    }

    /**
     * @param string $message
     */
    public function addSuccess(string $message)
    {
        $this->addMessage($message);
    }

    /**
     * @param string $message
     */
    public function addError(string $message)
    {
        $this->addMessage($message, self::TYPE_ERROR);
    }

    /**
     * @param string $message
     * @param string $type
     */
    public function addMessage(string $message, string $type = self::TYPE_SUCCESS)
    {
        $_SESSION[self::KEY][] = [
            'message' => $message,
            'type'    => $type
        ];
    }

    /**
     * @return array
     */
    public function flushMessages() : array
    {
        $messages = $_SESSION[self::KEY];
        $_SESSION[self::KEY] = [];
        return $messages;
    }
}
