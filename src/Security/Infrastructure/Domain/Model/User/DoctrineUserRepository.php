<?php

declare(strict_types=1);

namespace App\Security\Infrastructure\Domain\Model\User;

use App\Security\Domain\Model\User\User;
use App\Security\Domain\Model\User\UserId;
use App\Security\Domain\Model\User\UserRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;

class DoctrineUserRepository implements UserRepositoryInterface
{
    private EntityManagerInterface $entityManager;

    private ObjectRepository $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository(User::class);
    }

    public function findById(UserId $id)
    {
        return $this->repository->find($id->id());
    }

    public function findByEmail(string $email)
    {
        return $this->repository->findOneBy(['email' => $email]);
    }
}
