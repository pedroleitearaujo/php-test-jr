<?php

namespace Library\Application\UseCases\BookUseCases;

use Library\Domain\Repositories\BookRepositoryInterface;

class ListBooksUseCase
{
    private BookRepositoryInterface $bookRepository;

    public function __construct(BookRepositoryInterface $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    public function execute(): array
    {
        return $this->bookRepository->findAll();
    }
}
