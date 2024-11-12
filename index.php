<?php

require 'vendor/autoload.php';

$app = new \Flight\Engine();

// Depedencies
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

$loanRepository = new \Library\Persistence\JsonLoanRepository('./data/loans.json');
$addLoanUseCase = new \Library\Application\UseCases\LoanUseCases\AddLoanUseCase($loanRepository, $bookRepository, $userRepository);
$listLoansUseCase = new \Library\Application\UseCases\LoanUseCases\ListLoansUseCase($loanRepository);
$findLoanByIdUseCase = new \Library\Application\UseCases\LoanUseCases\FindLoanByIdUseCase($loanRepository);
$removeLoanUseCase = new \Library\Application\UseCases\LoanUseCases\RemoveLoanUseCase($loanRepository);
$updateLoanUseCase = new \Library\Application\UseCases\LoanUseCases\UpdateLoanUseCase($loanRepository);

// Controllers
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

$loanController = new \Library\Controllers\LoanController(
    $addLoanUseCase,
    $findLoanByIdUseCase,
    $listLoansUseCase,
    $removeLoanUseCase,
    $updateLoanUseCase
);


// Load Routes
$bookRoutes = require __DIR__ . '/src/Routes/bookRoutes.php';
$bookRoutes($app, $bookController);

$userRoutes = require __DIR__ . '/src/Routes/userRoutes.php';
$userRoutes($app, $userController);

$loanRoutes = require __DIR__ . '/src/Routes/loanRoutes.php';
$loanRoutes($app, $loanController);

// init
$app->start();
