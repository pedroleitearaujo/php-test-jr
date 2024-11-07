<?php

namespace Library\Application\UseCases\BookUseCases;

use Library\Domain\Entities\Book;
use Library\Domain\Repositories\BookRepositoryInterface;
use Library\Domain\ValueObjects\ISBN;

class AddBookUseCase
{
    private BookRepositoryInterface $bookRepository;

    public function __construct(BookRepositoryInterface $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    public function execute(string $title, string $author, string $isbn): void
    {
        $book = new Book($title, $author, new ISBN($isbn));
        $this->bookRepository->save($book);
    }
}
