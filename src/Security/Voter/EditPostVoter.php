<?php

namespace App\Security\Voter;

use App\Entity\Post;
use App\Entity\User;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class EditPostVoter extends Voter
{
    public const EDIT = 'POST_EDIT';

    public function __construct(
        private readonly Security $security
    )
    {
    }

    protected function supports(string $attribute, mixed $subject): bool
    {
        return $attribute == self::EDIT && $subject instanceof Post;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        if ($this->security->isGranted('ROLE_SUPER_ADMIN')) {
            return true;
        }

        $author = $subject->getUser();

        /** @var User $user */
        if($author->getId() != $user->getId()) {
            return false;
        }

        return true;
    }
}
