<?php

namespace Library\Application\UseCases\UserUseCases;

use Library\Domain\Entities\User;
use Library\Domain\Repositories\UserRepositoryInterface;

class AddUserUseCase
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(string $name, string $email): void
    {
        $user = new User($name, $email);
        $this->userRepository->save($user);
    }
}
