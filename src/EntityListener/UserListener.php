<?php
namespace App\EntityListener;

use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserListeren
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function prePersist(User $user)
    {
        $this->encodePassword($user);
    }
    public function preUpdate(User $user)
    {
        $this->encodePassword($user);
    }
    
    /**
     * Encode password based on plain password 
     * 
     * @param User $user
     * @return void
     */
    public function encodePassword(User $user)
    {
        if($user->getPlaintPassword()===null){
            return;
        }
        $user->setPassword(
            $this->hasher->hashPassword(
                $user,
                $user->getPlaintPassword()
            )
            );
            $user->setPlaintPassword(null);
    }
}


?>