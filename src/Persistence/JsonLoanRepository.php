<?php

namespace Library\Persistence;

use Library\Domain\Entities\Loan;
use Library\Domain\Repositories\LoanRepositoryInterface;
use DateTime;

class JsonLoanRepository implements LoanRepositoryInterface
{
    private string $filePath;
    private array $loans = [];

    public function __construct(string $filePath = 'data/loans.json')
    {
        $this->filePath = $filePath;
        $this->loadData();
    }

    private function loadData(): void
    {
        if (file_exists($this->filePath)) {
            $data = json_decode(file_get_contents($this->filePath), true);
            foreach ($data as $loanData) {
                $this->loans[] = new Loan(
                    $loanData['bookId'],
                    $loanData['userId'],
                    new DateTime($loanData['loanDate']),
                    new DateTime($loanData['dueDate']),
                    $loanData['id']
                );
            }
        }
    }

    private function saveData(): void
    {
        $data = array_map(function (Loan $loan) {
            return $loan->toArray();
        }, $this->loans);

        file_put_contents($this->filePath, json_encode($data, JSON_PRETTY_PRINT));
    }

    public function save(Loan $loan): void
    {
        if (is_null($loan->getId())) {
            $loan->setId();
        }
        $this->loans[] = $loan;
        $this->saveData();
    }

    public function findById(string $id): ?Loan
    {
        foreach ($this->loans as $loan) {
            if ($loan->getId() === $id) {
                return $loan;
            }
        }
        return null;
    }

    public function findAll(): array
    {
        return array_map(function (Loan $loan) {
            return $loan->toArray();
        }, $this->loans);
    }

    public function delete(string $id): void
    {
        $this->loans = array_filter($this->loans, function (Loan $loan) use ($id) {
            return $loan->getId() !== $id;
        });
        $this->saveData();
    }
}
