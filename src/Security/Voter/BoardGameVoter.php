<?php

namespace App\Security\Voter;

use App\Entity\BoardGame;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class BoardGameVoter extends Voter
{
    protected function supports($attribute, $subject)
    {
        return ($attribute === 'GAME_EDIT')    #décide si on vote ou on s'abstient
            && $subject instanceof BoardGame;
    }
    private $em;

    public function __construct(EntityManagerInterface $em){
        $this->em = $em;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)   #si on vote : on décide ici si vote true ou false
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }
       // /** @var BoardGame $subject */
        $users = $this->em->createQuery('select c FROM '.User::class .' c')->getResult();
        if ($users[0]->getEmail() == 'toto@toto.com') return true;
       else return false;
        if ($subject->getCreateur() == $user){ return true; }
        return false;
    }
}
