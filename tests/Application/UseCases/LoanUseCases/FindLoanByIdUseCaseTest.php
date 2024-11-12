<?php

namespace Tests\Application\UseCases\LoanUseCases;

use PHPUnit\Framework\TestCase;
use DateTime;
use Library\Application\UseCases\LoanUseCases\FindLoanByIdUseCase;
use Library\Domain\Repositories\LoanRepositoryInterface;
use Library\Domain\Entities\Loan;

class FindLoanByIdUseCaseTest extends TestCase
{
    private $loanRepository;
    private $findLoanByIdUseCase;

    protected function setUp(): void
    {
        $this->loanRepository = $this->createMock(LoanRepositoryInterface::class);
        $this->findLoanByIdUseCase = new FindLoanByIdUseCase($this->loanRepository);
    }

    public function testFindLoanByIdSuccessfully()
    {
        $loan = new Loan("bookId", "userId", new DateTime('2024-11-01'), new DateTime('2024-11-15'), 'loanId');

        $this->loanRepository->method('findById')->willReturn($loan);

        $foundLoan = $this->findLoanByIdUseCase->execute($loan->getId());

        $this->assertInstanceOf(Loan::class, $foundLoan);
        $this->assertEquals($loan->getId(), $foundLoan->getId());
    }

}
