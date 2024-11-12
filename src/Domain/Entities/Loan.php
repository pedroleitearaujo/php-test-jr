<?php

namespace Library\Domain\Entities;

use DateTime;

class Loan
{
    private ? string $id;
    private string $bookId;
    private string $userId;
    private DateTime $loanDate;
    private DateTime $dueDate;
    private ? DateTime $returnDate;

    public function __construct(string $bookId, string $userId, DateTime $loanDate, DateTime $dueDate, string $id = null)
    {
        $this->bookId = $bookId;
        $this->userId = $userId;
        $this->loanDate = $loanDate;
        $this->dueDate = $dueDate;
        $this->returnDate = null;
        $this->id = $id;
    }

    public function getId(): ? string
    {
        return $this->id;
    }

    public function getBookId(): string
    {
        return $this->bookId;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function getLoanDate(): DateTime
    {
        return $this->loanDate;
    }

    public function getDueDate(): DateTime
    {
        return $this->dueDate;
    }

    public function getReturnDate(): ?DateTime
    {
        return $this->returnDate;
    }

    public function setId()
    {
        $this->id = uniqid();
    }

    public function setReturnDate(DateTime $returnDate): void
    {
        $this->returnDate = $returnDate;
    }

    public function toArray() {
        return [
            'id' => $this->getId(),
            'bookId' => $this->getBookId(),
            'userId' => $this->getUserId(),
            'loanDate' => $this->getLoanDate()->format('Y-m-d'),
            'dueDate' => $this->getDueDate()->format('Y-m-d'),
            'returnDate' => $this->getReturnDate() ? $this->getReturnDate()->format('Y-m-d') : null
        ];
    }
}
