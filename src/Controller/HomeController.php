<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ArticleRepository $articleRepository, Request $request): Response
    {
        $currentPage = $request->query->getInt('page', 1);
        $limit = 10;
        $paginator = $articleRepository->findPaginated($currentPage, $limit);
        $totalArticles = count($paginator);

        return $this->render(
            'home/home.html.twig',
            [
                'articles' => $paginator,
                'currentPage' => $currentPage,
                'limit' => $limit,
                'totalArticles' => $totalArticles,
            ]
        );
    }

    #[Route('/article/{id}', name: 'app_article_detail')]
    public function getArticleDetailAction(ArticleRepository $articleRepository, Request $request): Response
    {
        $id = $request->get('id');
        $article = $articleRepository->find($id);
        if (!$article) {
            throw $this->createNotFoundException(
                sprintf('No article found for id %s', $id)
            );
        }
//        $article->setNbViews($article->getNbViews() + 1);
        return $this->render('home/article_detail.html.twig', [
            'article' => $article,
        ]);
    }
}
