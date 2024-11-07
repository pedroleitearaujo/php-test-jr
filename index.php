<?php

require 'vendor/autoload.php';

$app = new \Flight\Engine();

// Dependências
$bookRepository = new \Library\Persistence\JsonBookRepository('./data/books.json');
$addBookUseCase = new \Library\Application\UseCases\BookUseCases\AddBookUseCase($bookRepository);
$listBooksUseCase = new \Library\Application\UseCases\BookUseCases\ListBooksUseCase($bookRepository);
$findBookByIdUseCase = new \Library\Application\UseCases\BookUseCases\FindBookByIdUseCase($bookRepository);
$removeBookUseCase = new \Library\Application\UseCases\BookUseCases\RemoveBookUseCase($bookRepository);

$userRepository = new \Library\Persistence\JsonUserRepository('./data/users.json');
$addUserUseCase = new \Library\Application\UseCases\UserUseCases\AddUserUseCase($userRepository);
$listUsersUseCase = new \Library\Application\UseCases\UserUseCases\ListUsersUseCase($userRepository);
$findUserByIdUseCase = new \Library\Application\UseCases\UserUseCases\FindUserByIdUseCase($userRepository);
$removeUserUseCase = new \Library\Application\UseCases\UserUseCases\RemoveUserUseCase($userRepository);

// Controladores
$bookController = new \Library\Controllers\BookController(
    $addBookUseCase,
    $findBookByIdUseCase,
    $listBooksUseCase,
    $removeBookUseCase
);

$userController = new \Library\Controllers\UserController(
    $addUserUseCase,
    $findUserByIdUseCase,
    $listUsersUseCase,
    $removeUserUseCase
);


// Carregar e registrar as rotas
$bookRoutes = require __DIR__ . '/src/Routes/bookRoutes.php';
$bookRoutes($app, $bookController);

$userRoutes = require __DIR__ . '/src/Routes/userRoutes.php';
$userRoutes($app, $userController);

// Iniciar a aplicação
Flight::json(['error' => '$e->getMessage()'], 400);
$app->start();
