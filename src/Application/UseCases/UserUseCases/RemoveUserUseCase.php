<?php

namespace Library\Application\UseCases\UserUseCases;

use Library\Domain\Repositories\UserRepositoryInterface;

class RemoveUserUseCase
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(string $id): void
    {
        $this->userRepository->delete($id);
    }
}
