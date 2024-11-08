<?php

namespace Library\Domain\Repositories;

use Library\Domain\Entities\Loan;

interface LoanRepositoryInterface
{
    public function save(Loan $loan): void;

    public function findById(string $id): ? Loan;

    public function findAll(): array;
    
    public function delete(string $id): void;
}
