<?php

namespace App\Service;

use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class UserCreateService
{
    public function __construct(
        private readonly ValidatorInterface $validator,
        private readonly UserPasswordHasherInterface $passwordHasher,
        private readonly EntityManagerInterface $entityManager
    ) {}

    /**
     * Create a standard user.
     *
     * @throws BadRequestHttpException If validation fails.
     * @throws \RuntimeException If saving the user to the database fails.
     */
    public function createUser(string $nom, string $prenom, string $email, string $password): User
    {
        $this->validateInput($nom, $prenom, $email, $password);

        $user = (new User())
            ->setNom($nom)
            ->setPrenom($prenom)
            ->setEmail($email)
             // Standard user has no additional roles
        ;

        $user->setPassword($this->hashPassword($user, $password));

        $this->saveUser($user);

        return $user;
    }

    /**
     * Create an admin user.
     *
     * @throws BadRequestHttpException If validation fails.
     * @throws \RuntimeException If saving the admin to the database fails.
     */
    public function createAdmin(string $nom, string $prenom, string $email, string $password): User
    {
        $this->validateInput($nom, $prenom, $email, $password);

        $user = (new User())
            ->setNom($nom)
            ->setPrenom($prenom)
            ->setEmail($email)
            ->setRoles(['ROLE_ADMIN'])

;

        $user->setPassword($this->hashPassword($user, $password));

        $this->saveUser($user);

        return $user;
    }

    /**
     * Validate user input using Symfony Validator constraints.
     *
     * @throws BadRequestHttpException If any constraint validation fails.
     */
    private function validateInput(string $nom, string $prenom, string $email, string $password): void
    {
        $constraints = new Assert\Collection([
            'nom' => [new Assert\NotBlank(), new Assert\Length(max: 255)],
            'prenom' => [new Assert\NotBlank(), new Assert\Length(max: 255)],
            'email' => [new Assert\NotBlank(), new Assert\Email()],
            'password' => [new Assert\NotBlank(), new Assert\Length(min: 8)]
        ]);

        $input = compact('nom', 'prenom', 'email', 'password');
        $violations = $this->validator->validate($input, $constraints);

        if ($violations->count() > 0) {
            $errors = array_map(
                fn($violation) => sprintf('%s: %s', $violation->getPropertyPath(), $violation->getMessage()),
                iterator_to_array($violations)
            );

            throw new BadRequestHttpException('Validation errors: ' . implode(', ', $errors));
        }
    }

    /**
     * Hash the user's password.
     */
    private function hashPassword(User $user, string $password): string
    {
        return $this->passwordHasher->hashPassword($user, $password);
    }

    /**
     * Persist and save the user to the database.
     *
     * @throws \RuntimeException If saving to the database fails.
     */
    private function saveUser(User $user): void
    {
        try {
            $this->entityManager->persist($user);
            $this->entityManager->flush();
        } catch (\Throwable $e) {
            throw new \RuntimeException('Failed to save the user: ' . $e->getMessage());
        }
    }
}
