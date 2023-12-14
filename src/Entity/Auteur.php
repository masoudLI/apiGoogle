<?php

namespace App\Entity;

use App\Entity\Trait\IdNameTrait;
use App\Repository\AuteurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'google_auteur')]
#[ORM\Entity(repositoryClass: AuteurRepository::class)]
class Auteur
{
    use IdNameTrait;

    #[ORM\ManyToMany(targetEntity: Book::class, mappedBy: 'auteurs')]
    private Collection $books;

    public function __construct()
    {
        $this->books = new ArrayCollection();
    }

    /**
     * @return Collection<int, Book>
     */
    public function getBooks(): Collection
    {
        return $this->books;
    }

    public function addBook(Book $book): static
    {
        if (!$this->books->contains($book)) {
            $this->books->add($book);
            $book->addAuteur($this);
        }

        return $this;
    }

    public function removeBook(Book $book): static
    {
        if ($this->books->removeElement($book)) {
            $book->removeAuteur($this);
        }

        return $this;
    }
}
