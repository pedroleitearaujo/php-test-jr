<?php

namespace Library\Controllers;

use Library\Application\UseCases\UserUseCases\AddUserUseCase;
use Library\Application\UseCases\UserUseCases\FindUserByIdUseCase;
use Library\Application\UseCases\UserUseCases\ListUsersUseCase;
use Library\Application\UseCases\UserUseCases\RemoveUserUseCase;

class UserController
{
    private AddUserUseCase $addUserUseCase;
    private FindUserByIdUseCase $findUserByIdUseCase;
    private ListUsersUseCase $listUsersUseCase;
    private RemoveUserUseCase $removeUserUseCase;

    public function __construct(
        AddUserUseCase $addUserUseCase,
        FindUserByIdUseCase $findUserByIdUseCase,
        ListUsersUseCase $listUsersUseCase,
        RemoveUserUseCase $removeUserUseCase
    ) {
        $this->addUserUseCase = $addUserUseCase;
        $this->findUserByIdUseCase = $findUserByIdUseCase;
        $this->listUsersUseCase = $listUsersUseCase;
        $this->removeUserUseCase = $removeUserUseCase;
    }

    public function addUser(array $data)
    {
        $name = $data['name'] ?? null;
        $email = $data['email'] ?? null;
        $isbn = $data['isbn'] ?? null;

        if (!$name || !$email) {
            throw new \InvalidArgumentException("Missing required user data");
        }

        $this->addUserUseCase->execute($name, $email);
    }

    public function findUserById(string $id): ? object
    {
        return $this->findUserByIdUseCase->execute($id);
    }

    public function listUsers()
    {
        return $this->listUsersUseCase->execute();
    }

    public function removeUser(string $id): void
    {
        $this->removeUserUseCase->execute($id);
    }
}
