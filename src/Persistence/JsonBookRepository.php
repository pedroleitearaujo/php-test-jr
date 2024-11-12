<?php

namespace Library\Persistence;

use Library\Domain\Entities\Book;
use Library\Domain\Repositories\BookRepositoryInterface;
use Library\Domain\ValueObjects\ISBN;

class JsonBookRepository implements BookRepositoryInterface
{
    private string $filePath;
    private array $books = [];

    public function __construct(string $filePath = 'books.json')
    {
        $this->filePath = $filePath;
        $this->loadData();
    }

    private function loadData(): void
    {
        if (file_exists($this->filePath)) {
            $data = json_decode(file_get_contents($this->filePath), true);
            foreach ($data as $bookData) {
                $this->books[] = new Book(
                    $bookData['title'],
                    $bookData['author'],
                    new ISBN($bookData['isbn']),
                    $bookData['id']
                );
            }
        }
    }

    private function saveData(): void
    {
        $data = array_map(function (Book $book) {
            return [
                'id' => $book->getId(),
                'title' => $book->getTitle(),
                'author' => $book->getAuthor(),
                'isbn' => (string) $book->getISBN() 
            ];
        }, $this->books);

        file_put_contents($this->filePath, json_encode($data, JSON_PRETTY_PRINT));
    }

    public function save(Book $book): void
    {
        if (is_null($book->getId())) {
            $book->setId(); 
        }
        $this->books[] = $book;
        $this->saveData();
    }

    // Encontrar livro por ID
    public function findById(string $id): ?Book
    {   
        foreach ($this->books as $book) {
            if ($book->getId() === $id) {
                return $book;
            }
        }
        return null;
    }

    // Obter todos os livros
    public function findAll(): array
    {
        return array_map(function (Book $book) {
            return [
                'id' => $book->getId(),
                'title' => $book->getTitle(),
                'author' => $book->getAuthor(),
                'isbn' => $book->getIsbn()->getIsbn()
            ];
        }, $this->books);
    }

    // Deletar livro por ID
    public function delete(string $id): void
    {
        $this->books = array_filter($this->books, function (Book $book) use ($id) {
            return $book->getId() !== $id;
        });
        $this->saveData();
    }
}
