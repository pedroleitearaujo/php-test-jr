<?php

namespace Library\Domain\Entities;

use Library\Domain\ValueObjects\ISBN;

class Book
{
    private ? string $id;
    private string $title;
    private string $author;
    private ISBN $isbn;

    public function __construct(string $title, string $author, ISBN $isbn, string $id = null)
    {
        $this->title = $title;
        $this->author = $author;
        $this->isbn = $isbn;
        $this->id = $id;
    }

    public function getId(): ? string
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function getISBN(): ISBN
    {
        return $this->isbn;
    }

    public function setId()
    {
        $this->id = uniqid();
    }

    public function toArray() {
        return [
            'id' => $this->getId(),
            'title' => $this->getTitle(),
            'author' => $this->getAuthor(),
            'isbn' => $this->getIsbn()->getIsbn() 
        ];
    }
}
