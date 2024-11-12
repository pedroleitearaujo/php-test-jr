<?php

use Library\Controllers\BookController;

return function ($app, BookController $bookController) {
    $app->route('POST /books', function () use ($bookController, $app) {
        $data = $app->request()->data->getData();
        try {
            $bookController->addBook($data);
            $app->json(['message' => 'Book added successfully'], 201);
        } catch (InvalidArgumentException $e) {
            $app->json(['error' => $e->getMessage()], 400);
        } catch (Exception $e) {
            $app->json(['error' => $e->getMessage()], 500);
        }
    });

    $app->route('GET /books/@id', function ($id) use ($bookController, $app) {
        try {
            $book = $bookController->findBookById($id);
            if ($book) {
                $app->json($book->toArray());
            } else {
                $app->json(['message' => 'Book not found'], 404);
            }
        } catch (\Exception $e) {
            $app->json(['error' => $e->getMessage()], 500);
        }
    });

    $app->route('GET /books', function () use ($bookController, $app) {
        try {
            $books = $bookController->listBooks();
            $app->json($books);
        } catch (\Exception $e) {
            $app->json(['error' => $e->getMessage()], 500);
        }
    });

    $app->route('DELETE /books/@id', function ($id) use ($bookController, $app) {
        try {
            $bookController->removeBook($id);
            $app->json(['message' => 'Book removed successfully']);
        } catch (\Exception $e) {
            $app->json(['error' => $e->getMessage()], 500);
        }
    });
};
