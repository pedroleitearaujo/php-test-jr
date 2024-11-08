<?php

namespace Library\Application\UseCases\LoanUseCases;

use Library\Domain\Repositories\LoanRepositoryInterface;

class RemoveLoanUseCase
{
    private LoanRepositoryInterface $loanRepository;

    public function __construct(LoanRepositoryInterface $loanRepository)
    {
        $this->loanRepository = $loanRepository;
    }

    public function execute(string $id): void
    {
        $this->loanRepository->delete($id);
    }
}
