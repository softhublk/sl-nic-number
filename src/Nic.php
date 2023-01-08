<?php

namespace Softhub\SlNicNumber;

class Nic
{

    public const OLD_NIC = "Old Nic";
    public const NEW_NIC = "New Nic";

    private string $nic;
    public bool $isValid;

    public string $type;


    public function __construct(string $nic)
    {
        $this->nic = $nic;
        $this->isValid = $this->validate();
        $this->getData();
    }

    public function validate(): bool
    {
        $paten = "/[0-9]{9}[vV]|[0-9]12/";
        return preg_match($paten, $this->nic);
    }


    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    private function getData(): void
    {
        if (strlen($this->nic) == 10) {
            $this->type = Nic::OLD_NIC;
        } else {
            $this->type =  Nic::NEW_NIC;
        }
    }
}
