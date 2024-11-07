<?php

namespace Library\Domain\ValueObjects;

class ISBN
{
    private string $isbn;

    public function __construct(string $isbn)
    {
        if (!$this->isValidISBN($isbn)) {
            throw new \InvalidArgumentException("Invalid ISBN format.");
        }
        $this->isbn = $isbn;
    }

    public function __toString(): string
    {
        return $this->isbn;
    }

    private function isValidISBN(string $isbn): bool
    {
        return preg_match('/^(97(8|9))?\d{9}(\d|X)$/', $isbn) === 1;
    }

    public function getIsbn(): string
    {
        return $this->isbn;
    }
}
