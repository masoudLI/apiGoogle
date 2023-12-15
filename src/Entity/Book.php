<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookRepository::class)]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $googleBookId = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $subTitle = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $publishedDate = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $isbn10 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $isbn13 = null;

    #[ORM\Column(nullable: true)]
    private ?int $pageCount = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $smallThumbnail = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $thumbnail = null;

    #[ORM\ManyToMany(targetEntity: Auteur::class, inversedBy: 'books')]
    private Collection $auteurs;

    #[ORM\ManyToMany(targetEntity: Publisher::class, inversedBy: 'books')]
    private Collection $publishers;

    #[ORM\OneToMany(mappedBy: 'book', targetEntity: UserBook::class)]
    private Collection $userBooks;

    public function __construct()
    {
        $this->auteurs = new ArrayCollection();
        $this->publishers = new ArrayCollection();
        $this->userBooks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGoogleBookId(): ?string
    {
        return $this->googleBookId;
    }

    public function setGoogleBookId(string $googleBookId): static
    {
        $this->googleBookId = $googleBookId;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getSubTitle(): ?string
    {
        return $this->subTitle;
    }

    public function setSubTitle(?string $subTitle): static
    {
        $this->subTitle = $subTitle;

        return $this;
    }

    public function getPublishedDate(): ?\DateTimeImmutable
    {
        return $this->publishedDate;
    }

    public function setPublishedDate(?\DateTimeImmutable $publishedDate): static
    {
        $this->publishedDate = $publishedDate;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getIsbn10(): ?string
    {
        return $this->isbn10;
    }

    public function setIsbn10(?string $isbn10): static
    {
        $this->isbn10 = $isbn10;

        return $this;
    }

    public function getIsbn13(): ?string
    {
        return $this->isbn13;
    }

    public function setIsbn13(?string $isbn13): static
    {
        $this->isbn13 = $isbn13;

        return $this;
    }

    public function getPageCount(): ?int
    {
        return $this->pageCount;
    }

    public function setPageCount(?int $pageCount): static
    {
        $this->pageCount = $pageCount;

        return $this;
    }

    public function getSmallThumbnail(): ?string
    {
        return $this->smallThumbnail;
    }

    public function setSmallThumbnail(?string $smallThumbnail): static
    {
        $this->smallThumbnail = $smallThumbnail;

        return $this;
    }

    public function getThumbnail(): ?string
    {
        return $this->thumbnail;
    }

    public function setThumbnail(?string $thumbnail): static
    {
        $this->thumbnail = $thumbnail;

        return $this;
    }

    /**
     * @return Collection<int, Auteur>
     */
    public function getAuteurs(): Collection
    {
        return $this->auteurs;
    }

    public function addAuteur(Auteur $auteur): static
    {
        if (!$this->auteurs->contains($auteur)) {
            $this->auteurs->add($auteur);
        }

        return $this;
    }

    public function removeAuteur(Auteur $auteur): static
    {
        $this->auteurs->removeElement($auteur);

        return $this;
    }

    /**
     * @return Collection<int, Publisher>
     */
    public function getPublishers(): Collection
    {
        return $this->publishers;
    }

    public function addPublisher(Publisher $publisher): static
    {
        if (!$this->publishers->contains($publisher)) {
            $this->publishers->add($publisher);
        }

        return $this;
    }

    public function removePublisher(Publisher $publisher): static
    {
        $this->publishers->removeElement($publisher);

        return $this;
    }

    /**
     * @return Collection<int, UserBook>
     */
    public function getUserBooks(): Collection
    {
        return $this->userBooks;
    }

    public function addUserBook(UserBook $userBook): static
    {
        if (!$this->userBooks->contains($userBook)) {
            $this->userBooks->add($userBook);
            $userBook->setBook($this);
        }

        return $this;
    }

    public function removeUserBook(UserBook $userBook): static
    {
        if ($this->userBooks->removeElement($userBook)) {
            // set the owning side to null (unless already changed)
            if ($userBook->getBook() === $this) {
                $userBook->setBook(null);
            }
        }

        return $this;
    }


    public function __toString()
    {
        return $this->title;
    }
}
