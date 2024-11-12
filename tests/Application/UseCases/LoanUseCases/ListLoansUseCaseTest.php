<?php

namespace Tests\Application\UseCases\BookUseCases;

use PHPUnit\Framework\TestCase;
use DateTime;
use Library\Application\UseCases\LoanUseCases\ListLoansUseCase;
use Library\Domain\Repositories\LoanRepositoryInterface;
use Library\Domain\Entities\Loan;


class ListLoansUseCaseTest extends TestCase
{
    private $loanRepository;
    private $listLoansUseCase;

    protected function setUp(): void
    {
        $this->loanRepository = $this->createMock(LoanRepositoryInterface::class);
        $this->listLoansUseCase = new ListLoansUseCase($this->loanRepository);
    }

    public function testListLoansSuccessfully()
    {
        $loan1 = new Loan("bookId1", "userId1", new DateTime('2024-11-01'), new DateTime('2024-11-15'), "loanId1");
        $loan2 = new Loan("bookId2", "userId2", new DateTime('2024-11-10'), new DateTime('2024-11-20'), "loanId2");

        $this->loanRepository->method('findAll')->willReturn([$loan1, $loan2]);

        $loans = $this->listLoansUseCase->execute();

        $this->assertCount(2, $loans);
        $this->assertInstanceOf(Loan::class, $loans[0]);
        $this->assertInstanceOf(Loan::class, $loans[1]);
    }

    
}
