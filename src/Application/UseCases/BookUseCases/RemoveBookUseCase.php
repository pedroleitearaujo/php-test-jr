<?php

namespace Library\Application\UseCases\BookUseCases;

use Library\Domain\Repositories\BookRepositoryInterface;

class RemoveBookUseCase
{
    private BookRepositoryInterface $bookRepository;

    public function __construct(BookRepositoryInterface $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    public function execute(string $id): void
    {
        $this->bookRepository->delete($id);
    }
}
