<?php

namespace Softhub\SlNicNumber;

class Nic
{

    private string $nic;
    public bool $isValid;

    public function __construct(string $nic)
    {
        $this->nic = $nic;
        $this->isValid = $this->validate();
    }

    public function validate(): bool
    {
        $paten = "/[0-9]{9}[vV]|[0-9]12/";
        return preg_match($paten, $this->nic);
    }
}
