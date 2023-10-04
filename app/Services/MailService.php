<?php

namespace App\Services;


class MailService
{

    private $from;
    /**
     * @var string
     */
    private $to;

    public function __construct()
    {
        $this->from = env('MAIL_DEFAULT_SENDER', 'medbrasildigital@gmail.com');
    }

    /**
     * @return string
     */
    public function getFrom(): string
    {
        return $this->from;
    }

    /**
     * @param string $to
     */
    public function setFrom(string $from)
    {
        $this->from = $from;
        return $this;
    }

    public function queue($to, $subject, $views, $data)
    {
        return \Mail::queue($views, compact('data'), function ($message) use ($to, $subject, $data) {
            $message
                ->from($this->getFrom())
                ->to($to)
                ->subject($subject);
        });
    }
}
