<?php

namespace Tests\Application\UseCases\LoanUseCases;

use PHPUnit\Framework\TestCase;
use DateTime;
use InvalidArgumentException;
use Library\Application\UseCases\LoanUseCases\UpdateLoanUseCase;
use Library\Domain\Repositories\LoanRepositoryInterface;
use Library\Domain\Entities\Loan;

class UpdateLoanUseCaseTest extends TestCase
{
    private $loanRepository;
    private $updateLoanUseCase;

    protected function setUp(): void
    {
        $this->loanRepository = $this->createMock(LoanRepositoryInterface::class);
        $this->updateLoanUseCase = new UpdateLoanUseCase($this->loanRepository);
    }

    public function testUpdateLoanSuccessfully()
    {
        $loan = new Loan('bookId', 'userId', new DateTime('2024-11-01'), new DateTime('2024-11-15'), 'loanId');
        
        $returnDate = new DateTime('2024-11-10');

        $this->loanRepository->method('findById')->willReturn($loan);
        
        $this->loanRepository->expects($this->once())
            ->method('save')
            ->with($loan);

        $this->updateLoanUseCase->execute($loan->getId(), $returnDate);
        
        $this->assertEquals($returnDate, $loan->getReturnDate());
    }

    public function testThrowExceptionIfLoanNotFound()
    {
        $loanId = 'loanId';
        
        $this->loanRepository->method('findById')->willReturn(null);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Loan with ID $loanId not found.");

        $this->updateLoanUseCase->execute($loanId, new DateTime('2024-11-10'));
    }

    public function testThrowExceptionIfReturnDateIsBeforeLoanDate()
    {
        $loan = new Loan('bookId', 'userId', new DateTime('2024-11-01'), new DateTime('2024-11-15'), 'loanId');
        
        $this->loanRepository->method('findById')->willReturn($loan);

        $returnDate = new DateTime('2024-10-31');

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The return date must be later than the loan date.');

        $this->updateLoanUseCase->execute($loan->getId(), $returnDate);
    }
}
