<?php

namespace Library\Controllers;

use Library\Application\UseCases\BookUseCases\AddBookUseCase;
use Library\Application\UseCases\BookUseCases\FindBookByIdUseCase;
use Library\Application\UseCases\BookUseCases\ListBooksUseCase;
use Library\Application\UseCases\BookUseCases\RemoveBookUseCase;

class BookController
{
    private AddBookUseCase $addBookUseCase;
    private FindBookByIdUseCase $findBookByIdUseCase;
    private ListBooksUseCase $listBooksUseCase;
    private RemoveBookUseCase $removeBookUseCase;

    public function __construct(
        AddBookUseCase $addBookUseCase,
        FindBookByIdUseCase $findBookByIdUseCase,
        ListBooksUseCase $listBooksUseCase,
        RemoveBookUseCase $removeBookUseCase
    ) {
        $this->addBookUseCase = $addBookUseCase;
        $this->findBookByIdUseCase = $findBookByIdUseCase;
        $this->listBooksUseCase = $listBooksUseCase;
        $this->removeBookUseCase = $removeBookUseCase;
    }

    public function addBook(array $data)
    {
        $title = $data['title'] ?? null;
        $author = $data['author'] ?? null;
        $isbn = $data['isbn'] ?? null;

        if (!$title || !$author || !$isbn) {
            throw new \InvalidArgumentException("Missing required book data");
        }

        $this->addBookUseCase->execute($title, $author, $isbn);
    }

    public function findBookById(string $id): ? object
    {
        return $this->findBookByIdUseCase->execute($id);
    }

    public function listBooks(): array
    {
        return $this->listBooksUseCase->execute();
    }

    public function removeBook(string $id): void
    {
        $this->removeBookUseCase->execute($id);
    }
}
