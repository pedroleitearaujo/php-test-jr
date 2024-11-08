<?php

namespace Library\Controllers;

use DateTime;
use Library\Application\UseCases\LoanUseCases\AddLoanUseCase;
use Library\Application\UseCases\LoanUseCases\FindLoanByIdUseCase;
use Library\Application\UseCases\LoanUseCases\ListLoansUseCase;
use Library\Application\UseCases\LoanUseCases\RemoveLoanUseCase;
use Library\Application\UseCases\LoanUseCases\UpdateLoanUseCase;

class LoanController
{
    private AddLoanUseCase $addLoanUseCase;
    private FindLoanByIdUseCase $findLoanByIdUseCase;
    private ListLoansUseCase $listLoansUseCase;
    private RemoveLoanUseCase $removeLoanUseCase;
    private UpdateLoanUseCase $updateLoanUseCase;

    public function __construct(
        AddLoanUseCase $addLoanUseCase,
        FindLoanByIdUseCase $findLoanByIdUseCase,
        ListLoansUseCase $listLoansUseCase,
        RemoveLoanUseCase $removeLoanUseCase,
        UpdateLoanUseCase $updateLoanUseCase
    ) {
        $this->addLoanUseCase = $addLoanUseCase;
        $this->findLoanByIdUseCase = $findLoanByIdUseCase;
        $this->listLoansUseCase = $listLoansUseCase;
        $this->removeLoanUseCase = $removeLoanUseCase;
        $this->updateLoanUseCase = $updateLoanUseCase;
    }

    public function addLoan(array $data)
    {

        if (!$this->isValidDate($data['loanDate']) || !$this->isValidDate($data['dueDate'])) {
            throw new \InvalidArgumentException("Invalid date format. Use 'Y-m-d'.");
        }

        $bookId = $data['bookId'] ?? null;
        $userId = $data['userId'] ?? null;
        $loanDate = new DateTime($data['loanDate']) ?? null;
        $dueDate = new DateTime($data['dueDate']) ?? null;

        if (!$bookId || !$userId || !$loanDate || !$dueDate) {
            throw new \InvalidArgumentException("Missing required loan data");
        }

        $this->addLoanUseCase->execute($bookId, $userId, $loanDate, $dueDate);
    }

    public function findLoanById(string $id)
    {
        return $this->findLoanByIdUseCase->execute($id);
    }

    public function listLoans()
    {
        return $this->listLoansUseCase->execute();
    }

    public function removeLoan(string $id): void
    {
        $this->removeLoanUseCase->execute($id);
    }

    public function updateLoanReturnDate(string $id, string $returnDate): void
    {
        if (!$this->isValidDate($returnDate)) {
            throw new \InvalidArgumentException("Invalid date format. Use 'Y-m-d'.");
        }
        $returnDate = new DateTime($returnDate);

        $this->updateLoanUseCase->execute($id, $returnDate);
    }

    private function isValidDate(string $date): bool
    {
        $d = DateTime::createFromFormat('Y-m-d', $date);
        return $d && $d->format('Y-m-d') === $date;
    }
}
