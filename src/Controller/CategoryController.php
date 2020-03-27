<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\BoardGameRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/category", name="category")
 */
class CategoryController extends AbstractController
{
    /**
     * @Route("/{id}")
     */
    public function show(Category $category, BoardGameRepository $rep)
    {
        $games = $rep->findBelongTo($category->getId());
        return $this->render('category/show.html.twig', [
            'category' => $category,
            'listeGames' => $games,
        ]);
    }
}
