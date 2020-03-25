<?php


namespace App\Controller;


use App\Entity\BoardGame;
use App\Repository\BoardGameRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateType; //pas celle de Doctrine type
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/board-game")
 */
class BoardGameController extends AbstractController
{
    /**
     * @Route("",methods="GET")
     */
    public function index(BoardGameRepository $repository)
    {
        $boardGames = $repository->findAll();
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

    /**
     * @Route("/new")
     */
    public function new(Request $request,EntityManagerInterface $em)
    {
        $game = new BoardGame();
        $form = $this->createFormBuilder($game)
            ->add('name',null,['label'=>'Nom'])
            ->add('description',null,['label'=>'Description'])
            ->add('releasedAt',DateType::class,['html5' => true, 'widget' => 'single_text','label'=>'Date de sortie'])
            ->add('ageGroup',null,['label'=>'A partir de (Age)'])
            ->getForm();

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
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
     * @Route("/edit/{id}",requirements={"id" : "\d+"},methods={"GET","POST"}))
     */
    public function edit(BoardGame $game,Request $request,EntityManagerInterface $em)
    {
        $form = $this->createFormBuilder($game)
            ->add('name',null,['label'=>'Nom'])
            ->add('description',null,['label'=>'Description'])
            ->add('releasedAt',DateType::class,['html5' => true, 'widget' => 'single_text','label'=>'Date de sortie'])
            ->add('ageGroup',null,['label'=>'A partir de (Age)'])
            ->getForm();

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
