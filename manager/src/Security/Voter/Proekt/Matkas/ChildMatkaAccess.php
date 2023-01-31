<?php

declare(strict_types=1);

namespace App\Security\Voter\Proekt\Matkas;

use App\Model\Paseka\Entity\Matkas\Role\Permission;

use App\Model\Paseka\Entity\Matkas\ChildMatka\ChildMatka;
use App\Model\Paseka\Entity\Uchasties\Uchastie\Id;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class ChildMatkaAccess extends Voter
{
    public const VIEW = 'view';
    public const MANAGE = 'edit';
    public const DELETE = 'delete';

    private $security;

    public function __construct(AuthorizationCheckerInterface $security)
    {
        $this->security = $security;
    }

    protected function supports($attribute, $subject): bool
    {
        return in_array($attribute, [self::VIEW, self::MANAGE, self::DELETE], true) && $subject instanceof ChildMatka;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        if (!$user instanceof UserInterface) {
            return false;
        }

        if (!$subject instanceof ChildMatka) {
            return false;
        }
        switch ($attribute) {
            case self::VIEW:
                return
                    $this->security->isGranted('ROLE_PASEKA_MANAGE_PLEMMATKAS') ||
                    $subject->getPlemMatka()->isUchastieGranted(new Id($user->getId()), Permission::VIEW_CHILDMATKAS);
                break;
            case self::MANAGE:
                return
                    $this->security->isGranted('ROLE_PASEKA_MANAGE_PLEMMATKAS') ||
                    $subject->getPlemMatka()->isUchastieGranted(new Id($user->getId()), Permission::MANAGE_CHILDMATKAS);
                break;
            case self::DELETE:
                return
                    $this->security->isGranted('ROLE_PASEKA_MANAGE_PLEMMATKAS');
                break;
        }

        return false;
    }
}
