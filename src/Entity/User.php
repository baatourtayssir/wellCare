<?php
namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $age = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column(type: 'boolean')]
    private $isVerified = false;

    #[ORM\Column]
    private array $roles = []; // Ajout d'une propriété pour les rôles

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;
        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): static
    {
        $this->age = $age;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;
        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;
        return $this;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): static
    {
        $this->isVerified = $isVerified;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getRoles(): array
    {
        // Retourne les rôles de l'utilisateur. Si l'utilisateur n'a pas de rôle, il recevra un rôle par défaut.
        return $this->roles ?: ['ROLE_USER'];  // Par défaut, les utilisateurs ont le rôle ROLE_USER
    }

    /**
     * {@inheritdoc}
     */
    public function getUserIdentifier(): string
    {
        // Retourne l'identifiant unique de l'utilisateur (ici l'email)
        return (string) $this->email;
    }

    /**
     * {@inheritdoc}
     */
    public function eraseCredentials(): void
    {
        // Effacer les données sensibles, comme un mot de passe temporaire, si nécessaire
        // Par exemple, si vous stockez un token ou un mot de passe temporaire, vous pouvez l'effacer ici.
    }

    // Vous pouvez ajouter des méthodes personnalisées ici, comme pour récupérer un tableau des rôles.
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;
        return $this;
    }
}
