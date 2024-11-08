<?php

use Library\Controllers\LoanController;

return function ($app, LoanController $loanController) {
    $app->route('POST /loans', function () use ($loanController, $app) {
        $data = Flight::request()->data->getData();
        try {
            $loanController->addLoan($data);
            $app->json(['message' => 'Loan added successfully'], 201);
        } catch (InvalidArgumentException $e) {
            $app->json(['error' => $e->getMessage()], 400);
        } catch (\Exception $e) {
            $app->json(['error' => $e->getMessage()], 500);
        }
    });

    $app->route('GET /loans/@id', function ($id) use ($loanController, $app) {
        try {
            $loan = $loanController->findLoanById($id);
            if ($loan) {
                $app->json($loan->toArray());
            } else {
                $app->json(['message' => 'Loan not found'], 404);
            }
        } catch (\Exception $e) {
            $app->json(['error' => $e->getMessage()], 500);
        }
    });

    $app->route('GET /loans', function () use ($loanController, $app) {
        try {
            $loans = $loanController->listLoans();
            $app->json($loans);
        } catch (\Exception $e) {
            $app->json(['error' => $e->getMessage()], 500);
        }
    });

    $app->route('DELETE /loans/@id', function ($id) use ($loanController, $app) {
        try {
            $loanController->removeLoan($id);
            $app->json(['message' => 'Loan removed successfully']);
        } catch (\Exception $e) {
            $app->json(['error' => $e->getMessage()], 500);
        }
    });

    $app->route('PUT /loans/@id', function ($id) use ($loanController, $app) {
        $data = $app->request()->data->getData();

        try {
            $loanController->updateLoanReturnDate(
                $id,
                $data['returnDate']
            );
            return $app->json(['message' => 'Loan return date updated successfully'], 200);
        } catch (InvalidArgumentException $e) {
            return $app->json(['error' => $e->getMessage()], 400);
        } catch (\Exception $e) {
            return $app->json(['error' => $e->getMessage()], 500);
        }
    });
};
