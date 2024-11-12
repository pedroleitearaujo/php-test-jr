<?php

namespace Tests\Application\UseCases\LoanUseCases;

use PHPUnit\Framework\TestCase;
use DateTime;
use InvalidArgumentException;
use Library\Application\UseCases\LoanUseCases\AddLoanUseCase;
use Library\Domain\Repositories\LoanRepositoryInterface;
use Library\Domain\Repositories\BookRepositoryInterface;
use Library\Domain\Repositories\UserRepositoryInterface;
use Library\Domain\Entities\Loan;
use Library\Domain\Entities\Book;
use Library\Domain\Entities\User;
use Library\Domain\ValueObjects\ISBN;


class AddLoanUseCaseTest extends TestCase
{
    private $loanRepository;
    private $bookRepository;
    private $userRepository;
    private $addLoanUseCase;

    protected function setUp(): void
    {
        $this->loanRepository = $this->createMock(LoanRepositoryInterface::class);
        $this->bookRepository = $this->createMock(BookRepositoryInterface::class);
        $this->userRepository = $this->createMock(UserRepositoryInterface::class);

        $this->addLoanUseCase = new AddLoanUseCase(
            $this->loanRepository,
            $this->bookRepository,
            $this->userRepository
        );
    }

    public function testCreateLoanSuccessfully()
    {
        $bookMock = new Book("Book Title", "Author Name", new ISBN("1234567890"), 'bookId');
        $userMock = new User("User Name", "User Email", 'userId');

        $this->bookRepository->method('findById')->willReturn($bookMock);
        $this->userRepository->method('findById')->willReturn($userMock);

        $loanDate = new DateTime('2024-11-10');
        $dueDate = new DateTime('2024-11-20');

        $this->loanRepository->expects($this->once())
            ->method('save')
            ->with($this->callback(function ($loan) use ($loanDate, $dueDate, $bookMock, $userMock) {
                return $loan instanceof Loan &&
                    $loan->getBookId() == $bookMock->getId() && 
                    $loan->getUserId() == $userMock->getId() &&
                    $loan->getLoanDate() == $loanDate &&
                    $loan->getDueDate() == $dueDate ;
            }));

        $this->addLoanUseCase->execute($bookMock->getId(), $userMock->getId(), $loanDate, $dueDate);
    }


    public function testThrowsExceptionWhenBookNotFound()
    {
        $bookMock = new Book("Book Title", "Author Name", new ISBN("1234567890"), 'bookId');
        $bookMockId = $bookMock->getId();
        $this->bookRepository->method('findById')->willReturn(null);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Book with ID $bookMockId not found.");

        $this->addLoanUseCase->execute($bookMock->getId(), 'userId', new DateTime('2024-11-10'), new DateTime('2024-11-20'));
    }

    public function testThrowsExceptionWhenUserNotFound()
    {   
        $bookMock = new Book("Book Title", "Author Name", new ISBN("1234567890"), 'bookId');
        $userMock = new User("User Name", "User Email", 'userId');
        $userMockId = $userMock->getId();
        
        $this->bookRepository->method('findById')->willReturn($bookMock);
        $this->userRepository->method('findById')->willReturn(null);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("User with ID $userMockId not found.");

        $this->addLoanUseCase->execute($bookMock->getId(), $userMock->getId(), new DateTime('2024-11-10'), new DateTime('2024-11-20'));
    }

    public function testThrowsExceptionWhenLoanDateIsAfterDueDate()
    {
        $bookMock = new Book("Book Title", "Author Name", new ISBN("1234567890"), 'bookId');
        $userMock = new User("User Name", "User Email", 'userId');

        $this->bookRepository->method('findById')->willReturn($bookMock);
        $this->userRepository->method('findById')->willReturn($userMock);

        $loanDate = new DateTime('2024-11-21');
        $dueDate = new DateTime('2024-11-20');

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("The loan date must be earlier than the due date.");

        $this->addLoanUseCase->execute($bookMock->getId(), $userMock->getId(), $loanDate, $dueDate);
    }
}
