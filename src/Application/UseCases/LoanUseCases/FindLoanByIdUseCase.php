<?php

namespace Library\Application\UseCases\LoanUseCases;

use Library\Domain\Entities\Loan;
use Library\Domain\Repositories\LoanRepositoryInterface;

class FindLoanByIdUseCase
{
    private LoanRepositoryInterface $loanRepository;

    public function __construct(LoanRepositoryInterface $loanRepository)
    {
        $this->loanRepository = $loanRepository;
    }

    public function execute(string $id): ? Loan
    {
        return $this->loanRepository->findById($id);
    }
}
