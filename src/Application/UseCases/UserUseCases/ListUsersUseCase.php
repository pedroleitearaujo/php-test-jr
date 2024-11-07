<?php

namespace Library\Application\UseCases\UserUseCases;

use Library\Domain\Repositories\UserRepositoryInterface;

class ListUsersUseCase
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(): array
    {
        return $this->userRepository->findAll();
    }
}
