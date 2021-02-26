<?php

namespace App\Entity;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Required;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class TelegramUser
{
    private $provider_id;

    private $provider_type = 'telegram';

    private $first_name;

    private $last_name;

    private $photo_url;

    private $hash;

    private $auth_date;

    private $username;

    public static function createFromRequest(Request $request): self
    {
        return new self(
            $request->request->get('id'),
            $request->request->get('first_name'),
            $request->request->get('last_name'),
            $request->request->get('photo_url'),
            $request->request->get('hash'),
            $request->request->get('auth_date'),
            $request->request->get('username')
        );
    }

    private function __construct(
        string $id,
        ?string $firstName,
        ?string $lastName,
        ?string $photoUrl,
        string $hash,
        string $authDate,
        string $username
    ) {
        $this->provider_id = $id;
        $this->first_name = $firstName;
        $this->last_name = $lastName;
        $this->photo_url = $photoUrl;
        $this->hash = $hash;
        $this->auth_date = $authDate;
        $this->username = $username;
    }

    public function toHashCheckArray()
    {
        return [
            'id' => $this->getProviderId(),
            'first_name' => $this->getFirstName(),
            'last_name' => $this->getLastName(),
            'photo_url' => $this->getPhotoUrl(),
            'auth_date' => $this->getAuthDate(),
            'username' => $this->getUsername(),
        ];
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('provider_id', new Required());
        $metadata->addPropertyConstraints('auth_date', [
            new Required(),
            new DateTime('U'),
        ]);
        $metadata->addGetterConstraints('hash', [
            new Required(),
            new Length([
                'min' => 64,
                'max' => 64,
            ]),
        ]);
    }

    /**
     * @return string
     */
    public function getProviderId(): string
    {
        return $this->provider_id;
    }

    /**
     * @return string
     */
    public function getProviderType(): string
    {
        return $this->provider_type;
    }

    /**
     * @return string|null
     */
    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    /**
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    /**
     * @return string|null
     */
    public function getPhotoUrl(): ?string
    {
        return $this->photo_url;
    }

    /**
     * @return string
     */
    public function getHash(): string
    {
        return $this->hash;
    }

    /**
     * @return string
     */
    public function getAuthDate(): string
    {
        return $this->auth_date;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }
}