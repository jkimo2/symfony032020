<?php


namespace App\Controller;


use App\Entity\BoardGame;
use App\Repository\BoardGameRepository;
use App\SearchQuery\BoardGameQuery;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

/**
 * @Route({"en" : "board-game", "fr": "jeux"})
 */
class BoardGameController extends AbstractController
{
    /**
     * example /search/name=example-name+age-group=12
     *
     * @Route("/search/{term}",methods="GET")
     * @Cache(public="true",maxage=600, smaxage=600)
     */
    public function search(String $term,BoardGameRepository $repository,BoardGameQuery $query)
    {
        $criteria = $query->createCriteria($term);
        $boardGames = $repository->findSearch($criteria);
        return $this->json($boardGames,Response::HTTP_OK,[], [AbstractNormalizer::IGNORED_ATTRIBUTES => ['categories', 'createur']]);
    }

    /**
     * @Route("",methods="GET")
     */
    public function index(BoardGameRepository $repository)
    {
        $boardGames = $repository->findAll();
        $boardGames = $repository->findWithCategories2(); //il faut la créer - elle récupère les jeux avec leurs catégories pour éviter de fait un chargement jeu par jeu des catégories dans le tempaltes index
        return $this->render('board_game/index.html.twig',[
            'board_games' => $boardGames,
        ]);
    }

    /**
     * @Route("/{id}",requirements={"id" : "\d+"})
     */
    public function show(BoardGame $boardGame, Request $request)
    {
        $etag = md5($boardGame->getName().$boardGame->getDescription());
        $response = new Response();
        $response->setEtag($etag);
        if($response->isNotModified($request)){
            return $response;
        }
        return $response->setContent( $this->renderView('board_game/show.html.twig',[
            'board_game' => $boardGame,
        ]));
    }


}
