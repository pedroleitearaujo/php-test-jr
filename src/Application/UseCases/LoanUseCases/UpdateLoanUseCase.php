<?php

namespace Library\Application\UseCases\LoanUseCases;

use Library\Domain\Repositories\LoanRepositoryInterface;
use DateTime;

class UpdateLoanUseCase
{
    private LoanRepositoryInterface $loanRepository;

    public function __construct(LoanRepositoryInterface $loanRepository)
    {
        $this->loanRepository = $loanRepository;
    }

    public function execute(string $loanId, DateTime $returnDate): void
    {
        $loan = $this->loanRepository->findById($loanId);
        if (!$loan) {
            throw new \InvalidArgumentException("Loan with ID $loanId not found.");
        }
        
        if ($loan->getLoanDate() > $returnDate){
            throw new \InvalidArgumentException("The return date must be later than the loan date.");
        }

        $loan->setReturnDate($returnDate);
        $this->loanRepository->save($loan);
    }
}