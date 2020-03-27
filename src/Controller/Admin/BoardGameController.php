<?php


namespace App\Controller\Admin;


use App\Entity\BoardGame;
use App\Form\BoardGameType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/board-game")
 */
class BoardGameController extends AbstractController
{
    /**
     * @Route("/new")
     * @IsGranted("ROLE_ADMIN")
     * @
     */
    public function new(Request $request,EntityManagerInterface $em)
    {
        $game = new BoardGame();
        $form = $this->createForm(BoardGameType::class, $game);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $game->setCreateur($this->getUser());
            $em->persist($game);
            $em->flush();  //lance l'ensemble des requetes SQL , symfony optimise les requetes (si il y a +ieurs insert into , ca va etre regroupé)
            $this->addFlash( 'success', 'Nouveau jeu inséré');

            return $this->redirectToRoute('app_boardgame_show',['id'=>$game->getId()]);
        }

        return $this->render('board_game/new.html.twig',[
            'new_form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/edit/{id}",requirements={"id" : "\d+"},methods={"GET","PUT"}))
     * @IsGranted("GAME_EDIT", subject="game")
     */
    public function edit(BoardGame $game,Request $request,EntityManagerInterface $em)
    {
        $form = $this->createForm(BoardGameType::class, $game, ['method'=>'PUT']);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em->flush();  //lance l'ensemble des requetes SQL , symfony optimise les requetes (si il y a +ieurs insert into , ca va etre regroupé)
            $this->addFlash( 'success', 'Jeu modifié');

            return $this->redirectToRoute('app_boardgame_show',['id'=>$game->getId()]);
        }

        return $this->render('board_game/edit.html.twig',[
            'edit_form' => $form->createView(),
            'game' => $game,
        ]);
    }
}