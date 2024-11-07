<?php

namespace Library\Domain\Repositories;

use Library\Domain\Entities\Book;

interface BookRepositoryInterface
{
    public function save(Book $book): void;

    public function findById(string $id): ? Book;

    public function findAll(): array;

    public function delete(string $id): void;
}
