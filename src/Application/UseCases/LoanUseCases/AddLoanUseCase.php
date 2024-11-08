<?php

namespace Library\Application\UseCases\LoanUseCases;

use DateTime;
use Library\Domain\Entities\Loan;
use Library\Domain\Repositories\LoanRepositoryInterface;
use Library\Domain\Repositories\BookRepositoryInterface;
use Library\Domain\Repositories\UserRepositoryInterface;

class AddLoanUseCase
{
    private LoanRepositoryInterface $loanRepository;
    private BookRepositoryInterface $bookRepository;
    private UserRepositoryInterface $userRepository;

    public function __construct(
        LoanRepositoryInterface $loanRepository,
        BookRepositoryInterface $bookRepository,
        UserRepositoryInterface $userRepository
    ) {
        $this->loanRepository = $loanRepository;
        $this->bookRepository = $bookRepository;
        $this->userRepository = $userRepository;
    }

    public function execute(string $bookId, string $userId, DateTime $loanDate, DateTime $dueDate): void
    {
        $book = $this->bookRepository->findById($bookId);
        if (!$book) {
            throw new \InvalidArgumentException("Book with ID $bookId not found.");
        }

        $user = $this->userRepository->findById($userId);
        if (!$user) {
            throw new \InvalidArgumentException("User with ID $userId not found.");
        }

        if ($loanDate > $dueDate) {
            throw new \InvalidArgumentException("The loan date must be earlier than the due date.");
        }

        $loan = new Loan(
            $bookId,
            $userId,
            $loanDate,
            $dueDate
        );

        $this->loanRepository->save($loan);
    }
}
