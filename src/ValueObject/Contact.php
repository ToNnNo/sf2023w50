<?php

namespace App\ValueObject;

class Contact
{

    // https://www.php.net/releases/8.0/fr.php
    // https://www.php.net/manual/fr/language.oop5.properties.php#language.oop5.properties.readonly-properties
    public function __construct(
        private readonly ?string $firstname,
        private readonly ?string $lastname,
        private readonly bool $company = false
    )
    {
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function isCompany(): bool
    {
        return $this->company;
    }
}
