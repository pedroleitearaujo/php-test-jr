<?php

namespace Tests\Application\UseCases\LoanUseCases;

use PHPUnit\Framework\TestCase;
use DateTime;
use Library\Application\UseCases\LoanUseCases\RemoveLoanUseCase;
use Library\Domain\Repositories\LoanRepositoryInterface;
use Library\Domain\Entities\Loan;

class RemoveLoanUseCaseTest extends TestCase
{
    private $loanRepository;
    private $removeLoanUseCase;

    protected function setUp(): void
    {
        $this->loanRepository = $this->createMock(LoanRepositoryInterface::class);
        $this->removeLoanUseCase = new RemoveLoanUseCase($this->loanRepository);
    }

    public function testRemoveLoanSuccessfully()
    {
        $loan = new Loan("bookId", "userId", new DateTime('2024-11-01'), new DateTime('2024-11-15'), 'loanId');

        $this->loanRepository->method('findById')->willReturn($loan);
        
        $this->loanRepository->expects($this->once())
            ->method('delete')
            ->with($loan->getId());

        $this->removeLoanUseCase->execute($loan->getId());
    }
}
