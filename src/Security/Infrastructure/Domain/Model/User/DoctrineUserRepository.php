<?php

declare(strict_types=1);

namespace App\Security\Infrastructure\Domain\Model\User;

use App\Security\Domain\Model\User\User;
use App\Security\Domain\Model\User\UserId;
use App\Security\Domain\Model\User\UserRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class DoctrineUserRepository implements UserRepositoryInterface
{
    private EntityManagerInterface $entityManager;

    private ObjectRepository $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository(User::class);
    }

    public function findById(UserId $id): ?User
    {
        return $this->repository->find($id->id());
    }

    public function findByEmail(string $email): ?User
    {
        return $this->repository->findOneBy(['email' => $email]);
    }

    public function save(User $user): void
    {
        if ($this->findByEmail($user->email())) {
            throw new BadRequestException('Email already taken');
        }
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    public function update(User $user): void
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }
}
