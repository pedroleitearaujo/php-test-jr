<?php

require 'vendor/autoload.php';

$app = new \Flight\Engine();

// Dependências
$bookRepository = new \Library\Persistence\JsonBookRepository('./data/books.json');
$addBookUseCase = new \Library\Application\UseCases\BookUseCases\AddBookUseCase($bookRepository);
$listBooksUseCase = new \Library\Application\UseCases\BookUseCases\ListBooksUseCase($bookRepository);
$findBookByIdUseCase = new \Library\Application\UseCases\BookUseCases\FindBookByIdUseCase($bookRepository);
$removeBookUseCase = new \Library\Application\UseCases\BookUseCases\RemoveBookUseCase($bookRepository);

// Controladores
$bookController = new \Library\Controllers\BookController(
    $addBookUseCase,
    $findBookByIdUseCase,
    $listBooksUseCase,
    $removeBookUseCase
);

// Carregar e registrar as rotas
$bookRoutes = require __DIR__ . '/src/Routes/bookRoutes.php';
$bookRoutes($app, $bookController);

// Iniciar a aplicação
Flight::json(['error' => '$e->getMessage()'], 400);
$app->start();
