<?php
declare(strict_types=1);

namespace App\Mailer;

use App\Model\Entity\User;
use Cake\Mailer\Mailer;

/**
 * User mailer.
 */
class UserMailer extends Mailer
{
    /**
     * Mailer's name.
     *
     * @var string
     */
    public static $name = 'User';

    /**
     * @param User $user
     */
    public function welcome(User $user)
    {
        $this
            ->setTransport('gmail')
            ->setEmailFormat('html')
            ->setTo($user->username)
            ->setSubject(sprintf('Welcome %s', $user->name))
            ->setViewVars(['token' => $user->token])
            ->viewBuilder()
                ->setTemplate('welcome')
                ->setLayout('backoffice');
    }

    /**
     * @param User $user
     */
    public function resetPassword(User $user)
    {
        $this
            ->setTransport('gmail')
            ->setEmailFormat('html')
            ->setTo($user->username)
            ->setSubject('Reset password')
            ->setViewVars(['token' => $user->token])
            ->viewBuilder()
                ->setTemplate('reset')
                ->setLayout('backoffice');
    }
}
