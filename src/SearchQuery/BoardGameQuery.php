<?php


namespace App\SearchQuery;


use App\Entity\BoardGame;
use App\Repository\BoardGameRepository;

class BoardGameQuery
{

    private $repository;

    public function __construct(BoardGameRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param String $query
     * @return BoardGame[]
     */
    public function createCriteria(String $query)
    {
        $listCriteria = explode('+',$query);

        $arrayCriteria = array();
        foreach($listCriteria as $criteria){
            list($fieldName,$value) = explode('=',$criteria);
            $arrayCriteria[$fieldName] = $value;
        }
        dump($arrayCriteria);

        $builder = $this->repository->createQueryBuilder('b');

        foreach($arrayCriteria as $fieldName => $value){
            //création de la requete
        }


        return $builder->getQuery()->getResult();
    }

}