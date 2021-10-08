<?php

namespace App\Controller;

use App\Form\SearchType;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'default')]
    public function index(Request $request, ArticleRepository $articleRepository): Response
    {
        $form = $this->createForm(SearchType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $articles = $articleRepository->findBySearch($form->getViewData()['search']);
            return $this->render('article/index.html.twig', [
                'controller_name' => 'DefaultController',
                'articles' => $articles,
                'sform' => $form->createView()
            ]);
        }

        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
            'sform' => $form->createView()
        ]);
    }
}
