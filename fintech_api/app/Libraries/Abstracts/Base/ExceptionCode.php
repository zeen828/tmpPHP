<?php

namespace App\Libraries\Abstracts\Base;

use Exception;
use Illuminate\Support\MessageBag;

abstract class ExceptionCode extends Exception
{
    /**
     * The input replace converter message tags
     *
     * @var array
     */
    protected $replaceMessageTags = [];

    /**
     * @var MessageBag
     */
    protected $messageBag;

    /**
     * Custom exception code constructor.
     *
     * @param int $code
     * @param array $replaceMessageTags
     * @param array $replaceSourceMessageTags
     * @param MessageBag|null $messageBag
     * @return void
     */
    public function __construct(int $code, array $replaceMessageTags = [], array $replaceSourceMessageTags = [], ?MessageBag $messageBag = null)
    {
        $this->replaceMessageTags = $replaceMessageTags;

        $this->messageBag = $messageBag;

        $subclass = get_called_class();

        $message = (isset($subclass::DEBUG_MESSAGE[$code]) ? $subclass::DEBUG_MESSAGE[$code] : 'Unknown message.');

        $message = strtr($message, $replaceSourceMessageTags);

        parent::__construct($message, $code);
    }

    /**
     * Get the replace converter message.
     *
     * @param string $message
     * @return string
     */
    public function getReplaceConverterMessage(string $message): string
    {
        return strtr($message, $this->replaceMessageTags);
    }

    /**
     * @return MessageBag
     */
    public function getMessageBag()
    {
        return $this->messageBag;
    }
}
