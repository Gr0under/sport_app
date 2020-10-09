<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Entity\SportEvent;  


// Voter permettant de vérifier qu'un participant est bien enregistré sur un évènement avant d'ouvrir et d'écrire sur le mur de l'évènement. 

class EventParticipantVoter extends Voter
{
    protected function supports($attribute, $subject)
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, ['WALL_EDIT', 'WALL_VIEW'])
            && $subject instanceof SportEvent;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case 'WALL_EDIT':
                // logic to determine if the user can EDIT
                // return true or false
                break;
            case 'WALL_VIEW':
                // logic to determine if the user can VIEW
                // return true or false

                $event_participants = $subject->getPlayers();

                foreach ($event_participants as $player) {
                    if($player === $user){
                        return true; 
                    }
                }

                return false; 
                
                break;
        }

        return false;
    }
}
