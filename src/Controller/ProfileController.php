<?php

namespace App\Controller;

use App\Entity\UserBook;
use App\Repository\UserBookRepository;
use App\Service\BookService;
use App\Service\GoogleBooksApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/profile')]
class ProfileController extends AbstractController
{
    #[Route('/', name: 'app_profile')]
    public function index(): Response
    {
        return $this->render('profile/index.html.twig', [
            'controller_name' => 'ProfileController',
        ]);
    }

    #[Route('/search', name: 'app_search')]
    #[IsGranted('ROLE_USER')]
    public function search(): Response
    {
        return $this->render('profile/search.html.twig');
    }

    #[Route('/search/api', name: 'api_google', methods: ['POST'])]
    #[IsGranted('ROLE_USER')]
    public function apiGoogle(Request $request, GoogleBooksApiService $googleBooksService): Response
    {
        $search = $googleBooksService->search($request->request->get("search"));
        return $this->render('profile/_apiGoogle.html.twig', [
            'resultes' => $search
        ]);
    }

    #[Route('/search/api/{id}', name: 'app_books_add')]
    public function addBooks($id, BookService $booksService)
    {
        $userBook = $booksService->addBookToProfile($this->getUser(), $id);
        return $this->redirectToRoute('my_books', [
            'id' => $userBook->getId()
        ]);
    }


    #[Route('/my-books/{id}', name: 'my_books')]
    public function showOneBook(UserBook $userBook, UserBookRepository $userBookRepository): Response
    {
        $userBook = $userBookRepository->find($userBook);
        return $this->render('profile/show_one_book.html.twig', [
            'userBook' => $userBook,
        ]);
    }

}
