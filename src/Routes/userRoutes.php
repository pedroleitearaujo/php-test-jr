<?php

use Library\Controllers\UserController;

return function($app, UserController $userController) {

    $app->route('POST /users', function () use ($userController, $app) {
        $data = $app->request()->data->getData();
        try {
            $userController->addUser($data);
            $app->json(['message' => 'User added successfully'], 201);
        } catch (InvalidArgumentException $e) {
            $app->json(['error' => $e->getMessage()], 400);
        } catch (Exception $e) {
            $app->json(['error' => $e->getMessage()], 500);
        }
    });

    $app->route('GET /users', function () use ($userController, $app) {
        try {
            $users = $userController->listUsers();
            $app->json($users);
        } catch (\Exception $e) {
            $app->json(['error' => $e->getMessage()], 500);
        }
    });

    $app->route('GET /users/@id', function ($id) use ($userController, $app) {
        try {
            $user = $userController->findUserById($id);
            if ($user) {
                $app->json($user->toArray());
            } else {
                $app->json(['message' => 'User not found'], 404);
            }
        } catch (\Exception $e) {
            $app->json(['error' => $e->getMessage()], 500);
        }
    });

    $app->route('DELETE /users/@id', function ($id) use ($userController, $app) {
        try {
            $userController->removeUser($id);
            $app->json(['message' => 'User removed successfully']);
        } catch (\Exception $e) {
            $app->json(['error' => $e->getMessage()], 500);
        }
    });
};
