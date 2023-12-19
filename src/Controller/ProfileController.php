<?php

namespace App\Controller;

use App\Entity\UserBook;
use App\Service\BookService;
use App\Service\GoogleBooksApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
    public function search(): Response
    {
        return $this->render('profile/search.html.twig');
    }

    #[Route('/search/api', name: 'api_google', methods: ['POST'])]
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
        $bookUsers = $booksService->addBookToProfile($this->getUser(), $id);
        return $this->render('profile/show_one_book.html.twig', [
            'userBook' => $bookUsers
        ]);
    }
}
