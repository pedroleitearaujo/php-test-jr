<?php

namespace Library\Application\UseCases\UserUseCases;

use Library\Domain\Entities\User;
use Library\Domain\Repositories\UserRepositoryInterface;

class FindUserByIdUseCase
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(string $id): ? user
    {
        return $this->userRepository->findById($id);
    }
}
