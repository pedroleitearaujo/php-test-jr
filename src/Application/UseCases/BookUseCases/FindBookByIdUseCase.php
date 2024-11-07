<?php

namespace Library\Application\UseCases\BookUseCases;

use Library\Domain\Entities\Book;
use Library\Domain\Repositories\BookRepositoryInterface;

class FindBookByIdUseCase
{
    private BookRepositoryInterface $bookRepository;

    public function __construct(BookRepositoryInterface $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    public function execute(string $id): ?Book
    {
        return $this->bookRepository->findById($id);
    }
}
