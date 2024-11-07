<?php

namespace Library\Domain\Repositories;

use Library\Domain\Entities\User;

interface UserRepositoryInterface
{
    public function save(User $user): void;

    public function findById(string $id): ? User;

    public function findAll(): array;

    public function delete(string $id): void;
}
