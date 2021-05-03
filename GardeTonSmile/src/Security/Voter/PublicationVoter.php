<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class PublicationVoter extends Voter
{
    protected function supports($attribute, $subject)
    {
        return in_array($attribute, ['PUBLICATION_MANAGE'])
            && $subject instanceof \App\Entity\Publication;
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
            case 'PUBLICATION_MANAGE':
                return $user->isVerified() && $user == $subject->getUser();
        }

        return false;
    }
}
