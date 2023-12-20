<?php

namespace App\Service;

use App\Entity\Auteur;
use App\Entity\Book;
use App\Entity\Publisher;
use App\Entity\User;
use App\Entity\UserBook;
use App\Repository\AuteurRepository;
use App\Repository\BookRepository;
use App\Repository\PublisherRepository;
use App\Repository\UserBookRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;

class BookService
{

    public function __construct(
        private readonly GoogleBooksApiService $googleBooksApiService,
        private readonly BookRepository $bookRepository,
        private readonly AuteurRepository $auteurRepository,
        private readonly PublisherRepository $publisherRepository,
        private readonly UserBookRepository $userBookRepository,
        private readonly EntityManagerInterface $em
    )
    {
    }


    public function addBookToProfile (User $user, string $id)
    {
        $book = $this->getOrCreateBook($id);

        $userBook = $this->userBookRepository->findOneBy([
            'reader' => $user,
            'book' => $book,
        ]);

        if ($userBook === null) {
            $userBook = new UserBook();
            $userBook->setBook($book);
            $userBook->setReader($user);
            $userBook->setCreatedAt(new DateTimeImmutable());
            ;
            $this->em->persist($userBook);
        }

        $this->em->flush();

        return $userBook;
    }


    private function getOrCreateBook (string $id): Book
    {
        $bookFromGoogle = $this->googleBooksApiService->get($id);
        $book = $this->bookRepository->findOneBy([
            'googleBookId' => $id
        ]);

        if ($book === null) {
            $book = (new Book())
                ->setTitle($bookFromGoogle['volumeInfo']['title'] ?? null)
                ->setSubtitle($bookFromGoogle['volumeInfo']['subtitle'] ?? null)
                ->setDescription($bookFromGoogle['volumeInfo']['description'] ?? null)
                ->setGoogleBookId($id)
                ->setIsbn10($bookFromGoogle['volumeInfo']['industryIdentifiers'][0]['identifier'] ?? null)
                ->setIsbn13($bookFromGoogle['volumeInfo']['industryIdentifiers'][1]['identifier'] ?? null)
                ->setPageCount($bookFromGoogle['volumeInfo']['pageCount'] ?? null)
                ->setPublishedDate(new \DateTimeImmutable($bookFromGoogle['volumeInfo']['publishedDate'] ?? null))
                ->setSmallThumbnail($bookFromGoogle['volumeInfo']['imageLinks']['smallThumbnail'] ?? null)
                ->setThumbnail($bookFromGoogle['volumeInfo']['imageLinks']['thumbnail'] ?? null)
                ;
        }


        /** Ajoute des auteurs */
        foreach ($bookFromGoogle['volumeInfo']['authors'] ?? [] as $authorName) {
            $book->addAuteur($this->getOrCreateAuteur($authorName));
        }
        /** Ajoute un publisher */
        $book->addPublisher($this->getOrCreatePublisher($bookFromGoogle['volumeInfo']['publisher'] ?? null));

        /** ON persiste dans la base de donnee */
        $this->em->persist($book);
        $this->em->flush();

        return $book;
    }


    private function getOrCreateAuteur (string $name)
    {
        $author = $this->auteurRepository->findOneBy([
            'name' => $name
        ]);
        if ($author === null) {
            $author = new Auteur();
            $author->setName($name);
            $this->em->persist($author);
            $this->em->flush();
        }

        return $author;
    }

    private function getOrCreatePublisher(string $name): Publisher
    {
        $publisher = $this->publisherRepository->findOneBy([
            'name' => $name,
        ]);

        if ($publisher === null) {
            $publisher = new Publisher();

            $publisher->setName($name);

            $this->em->persist($publisher);
            $this->em->flush();
        }

        return $publisher;
    }

}
