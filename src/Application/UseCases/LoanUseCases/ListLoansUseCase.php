<?php

namespace Library\Application\UseCases\LoanUseCases;

use Library\Domain\Repositories\LoanRepositoryInterface;

class ListLoansUseCase
{
    private LoanRepositoryInterface $loanRepository;

    public function __construct(LoanRepositoryInterface $loanRepository)
    {
        $this->loanRepository = $loanRepository;
    }

    public function execute(): array
    {
        return $this->loanRepository->findAll();
    }
}
