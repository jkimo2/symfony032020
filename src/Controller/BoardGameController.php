<?php


namespace App\Controller;


use App\Entity\BoardGame;
use App\Repository\BoardGameRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("board-game")
 */
class BoardGameController extends AbstractController
{
    /**
     * @Route("",methods="GET")
     */
    public function index(BoardGameRepository $repository)
    {
        $boardGames = $repository->findAll();
        $boardGames = $repository->findWithCategories2(); //il faut la créer - elle récupère les jeux avec leurs catégories pour éviter de fait un chargement jeu par jeu des catégories dans le tempaltes index
        return$this->render('board_game/index.html.twig',[
            'board_games' => $boardGames,
        ]);
    }

    /**
     * @Route("/{id}",requirements={"id" : "\d+"})
     */
    public function show(BoardGame $boardGame)
    {
        return$this->render('board_game/show.html.twig',[
            'board_game' => $boardGame,
        ]);
    }


}
