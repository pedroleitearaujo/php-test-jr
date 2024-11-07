<?php

namespace Library\Persistence;

use Library\Domain\Entities\User;
use Library\Domain\Repositories\UserRepositoryInterface;

class JsonUserRepository implements UserRepositoryInterface
{
    private string $filePath;
    private array $users = [];

    public function __construct(string $filePath = 'users.json')
    {
        $this->filePath = $filePath;
        $this->loadData();
    }

    private function loadData(): void
    {
        if (file_exists($this->filePath)) {
            $data = json_decode(file_get_contents($this->filePath), true);
            foreach ($data as $userData) {
                $this->users[] = new User($userData['name'], $userData['email'], $userData['id']);
            }
        }
    }

    private function saveData(): void
    {
        $data = array_map(function (User $user) {
            return [
                'id' => $user->getId(),
                'name' => $user->getName(),
                'email' => $user->getEmail()
            ];
        }, $this->users);

        file_put_contents($this->filePath, json_encode($data, JSON_PRETTY_PRINT));
    }

    public function save(User $user): void
    {
        $this->users[] = $user;
        $this->saveData();
    }

    public function findById(string $id): ?User
    {
        foreach ($this->users as $user) {
            if ($user->getId() === $id) {
                return $user;
            }
        }
        return null;
    }

    public function findAll(): array
    {
        return array_map(function (User $user) {
            return [
                'id' => $user->getId(),
                'name' => $user->getName(),
                'email' => $user->getEmail()
            ];
        }, $this->users);
    }

    public function delete(string $id): void
    {
        $this->users = array_filter($this->users, function (User $user) use ($id) {
            return $user->getId() !== $id;
        });
        $this->saveData();
    }
}
