<?php

declare(strict_types=1);

namespace App\Model\User\Entity\User;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="user_users", uniqueConstraints={
 *     @ORM\UniqueConstraint(columns={"email"}),
 *     @ORM\UniqueConstraint(columns={"reset_token_token"})
 * })
 */
class User
{
    public const STATUS_WAIT = 'wait';
    public const STATUS_ACTIVE = 'active';
    public const STATUS_BLOCKED = 'blocked';

    /**
     * @ORM\Column(type="user_user_id")
     * @ORM\Id
     */
    private $id;
    /**
     * @var \DateTimeImmutable
     * @ORM\Column(type="datetime_immutable")
     */
    private $date;
    /**
     * @var Email|null
     * @ORM\Column(type="user_user_email", nullable=true)
     */
    private $email;
    /**
     * @var string|null
     * @ORM\Column(type="string", name="password_hash", nullable=true)
     */
    private $passwordHash;
    /**
     * @var string|null
     * @ORM\Column(type="string", name="confirm_token", nullable=true)
     */
    private $confirmToken;
    /**
     * @var Name
     * @ORM\Embedded(class="Name")
     */
    private $name;
    /**
     * @var Email|null
     * @ORM\Column(type="user_user_email", name="new_email", nullable=true)
     */
    private $newEmail;
    /**
     * @var string|null
     * @ORM\Column(type="string", name="new_email_token", nullable=true)
     */
    private $newEmailToken;
    /**
     * @var ResetToken|null
     * @ORM\Embedded(class="ResetToken", columnPrefix="reset_token_")
     */
    private $resetToken;
    /**
     * @var string
     * @ORM\Column(type="string", length=16)
     */
    private $status;

    /**
     * @var UchKak
     * @ORM\Column(type="user_user_uchkak", name="uchkak", length=16)
     */
    private $uchkak;

    /**
     * @var Role
     * @ORM\Column(type="user_user_role", length=16)
     */
    private $role;
    /**
     * @var Network[]|ArrayCollection
     * @ORM\OneToMany(targetEntity="Network", mappedBy="user", orphanRemoval=true, cascade={"persist"})
     */
    private $networks;

    private function __construct(Id $id, \DateTimeImmutable $date, Name $name)
    {
        $this->id = $id;
        $this->date = $date;
        $this->name = $name;
        $this->role = Role::user();
        $this->uchkak = UchKak::nablud();
        $this->networks = new ArrayCollection();
    }

    public static function create(Id $id, \DateTimeImmutable $date, Name $name, Email $email, string $hash): self
    {
        $user = new self($id, $date, $name);
        $user->email = $email;
        $user->passwordHash = $hash;
        $user->status = self::STATUS_ACTIVE;
        return $user;
    }

    public function edit(Email $email, Name $name): void
    {
        $this->name = $name;
        $this->email = $email;
    }

//Регистрация по электронной почте
    public static function signUpByEmail(Id $id, \DateTimeImmutable $date, Name $name, Email $email, string $hash, string $token): self
    {
        $user = new self($id, $date, $name);
        $user->email = $email;
        $user->passwordHash = $hash;
        $user->confirmToken = $token;
        $user->status = self::STATUS_WAIT;
        return $user;
    }

    //Подтверждение регистрации
    public function confirmSignUp(): void
    {
        if (!$this->isWait()) {
            throw new \DomainException('Пользователь уже подтвержден.');
        }

        $this->status = self::STATUS_ACTIVE;
        $this->confirmToken = null;
    }

    //Регистрация в сети
    public static function signUpByNetwork(Id $id, \DateTimeImmutable $date, Name $name, string $network, string $identity): self
    {
        $user = new self($id, $date, $name);
        $user->attachNetwork($network, $identity);
        $user->status = self::STATUS_ACTIVE;
        return $user;
    }

    //Присоединить сеть
    public function attachNetwork(string $network, string $identity): void
    {
        foreach ($this->networks as $existing) {
            if ($existing->isForNetwork($network)) {
                throw new \DomainException('Сеть уже подключена.');
            }
        }
        $this->networks->add(new Network($this, $network, $identity));
    }

    //запросить сброс пароля
    public function requestPasswordReset(ResetToken $token, \DateTimeImmutable $date): void
    {
        if (!$this->isActive()) {
            throw new \DomainException('Пользователь не активен.');
        }
        if (!$this->email) {
            throw new \DomainException('Адрес электронной почты не указан.');
        }
        if ($this->resetToken && !$this->resetToken->isExpiredTo($date)) {
            throw new \DomainException('Сброс уже запрошен.');
        }
        $this->resetToken = $token;
    }

    //сброс пароля
    public function passwordReset(\DateTimeImmutable $date, string $hash): void
    {
        if (!$this->resetToken) {
            throw new \DomainException('Сброс не запрашивается.');
        }
        if ($this->resetToken->isExpiredTo($date)) {
            throw new \DomainException('Срок действия токена сброса истек.');
        }
        $this->passwordHash = $hash;
        $this->resetToken = null;
    }

    //запрос на изменение электронной почты
    public function requestEmailChanging(Email $email, string $token): void
    {
        if (!$this->isActive()) {
            throw new \DomainException('Пользователь не активен.');
        }
        if ($this->email && $this->email->isEqual($email)) {
            throw new \DomainException('Электронная почта уже такая же.');
        }
        $this->newEmail = $email;
        $this->newEmailToken = $token;
    }
//подтвердите изменение электронной почты
    public function confirmEmailChanging(string $token): void
    {
        if (!$this->newEmailToken) {
            throw new \DomainException('Изменение не требуется.');
        }
        if ($this->newEmailToken !== $token) {
            throw new \DomainException('Неправильное изменение токена.');
        }
        $this->email = $this->newEmail;
        $this->newEmail = null;
        $this->newEmailToken = null;
    }

    //изменить имя
    public function changeName(Name $name): void
    {
        $this->name = $name;
    }

    //изменить role
    public function changeRole(Role $role): void
    {
        if ($this->role->isEqual($role)) {
            throw new \DomainException('Роль уже та же самая.');
        }
        $this->role = $role;
    }
//изменить учкак
    public function changeUchKak(UchKak $uchkak): void
    {
        if ($this->uchkak->isEqual($uchkak)) {
            throw new \DomainException('Вы так и участвуете.');
        }
        $this->uchkak = $uchkak;
    }

    public function activate(): void
    {
        if ($this->isActive()) {
            throw new \DomainException('Пользователь уже активен.');
        }
        $this->status = self::STATUS_ACTIVE;
    }

    public function block(): void
    {
        if ($this->isBlocked()) {
            throw new \DomainException('Пользователь уже заблокирован.');
        }
        $this->status = self::STATUS_BLOCKED;
    }

    public function isWait(): bool
    {
        return $this->status === self::STATUS_WAIT;
    }

    //является активным
    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    //заблокирован
    public function isBlocked(): bool
    {
        return $this->status === self::STATUS_BLOCKED;
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getDate(): \DateTimeImmutable
    {
        return $this->date;
    }

    public function getEmail(): ?Email
    {
        return $this->email;
    }

    public function getPasswordHash(): ?string
    {
        return $this->passwordHash;
    }

    public function getConfirmToken(): ?string
    {
        return $this->confirmToken;
    }

    public function getName(): Name
    {
        return $this->name;
    }

    public function getNewEmail(): ?Email
    {
        return $this->newEmail;
    }

    public function getNewEmailToken(): ?string
    {
        return $this->newEmailToken;
    }

    //получить токен сброса
    public function getResetToken(): ?ResetToken
    {
        return $this->resetToken;
    }

    public function getRole(): Role
    {
        return $this->role;
    }

    public function getUchkak(): UchKak
    {
        return $this->uchkak;
    }

    public function getStatus(): string
    {
        return $this->status;
    }


    /**
     * @return Network[]
     */
    public function getNetworks(): array
    {
        return $this->networks->toArray();
    }

    /**
     * @ORM\PostLoad()
     */
    public function checkEmbeds(): void
    {
        if ($this->resetToken->isEmpty()) {
            $this->resetToken = null;
        }
    }
}
