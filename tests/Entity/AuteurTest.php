<?php

namespace App\Tests\Entity;

use App\Entity\Auteur;
use App\Entity\Book;
use PHPUnit\Framework\TestCase;

class AuteurTest extends TestCase
{
    public function testGetId(): void
    {
        $author = new Auteur();
        $this->assertNull($author->getId());
    }
    public function testName(): void
    {
        $author = new Auteur();
        $author->setName('John Doe');
        $this->assertSame('John Doe', $author->getName());
    }
    public function testBooks(): void
    {
        $author = new Auteur();
        $book1 = new Book();
        $book2 = new Book();
        $author->addBook($book1);
        $this->assertTrue($author->getBooks()->contains($book1));
        $author->addBook($book2);
        $this->assertTrue($author->getBooks()->contains($book2));
        $author->removeBook($book1);
        $this->assertFalse($author->getBooks()->contains($book1));
    }
}
