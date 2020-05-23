<?php

// namespace OOP\Date;

class Date
{
    private string $format = 'd/m/Y H:m';

    public function __construct(?string $format = null)
    {
        if (null !== $format) {
            $this->format = $format;
        }
    }

    public function getTime(): string
    {
        return date($this->format, time());
    }

    public function __toString()
    {
        return $this->getTime();
    }
}
