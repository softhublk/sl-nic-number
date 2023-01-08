<?php

namespace Softhub\SlNicNumber;

use DateInterval;
use DateTime;

class Nic
{

    public const OLD_NIC = "Old Nic";
    public const NEW_NIC = "New Nic";
    public const MALE = "Male";
    public const FEMALE = "Female";

    public string $nic;
    public bool $isValid;

    public string $type;

    public ?string $birthDay = null;

    private int $days;

    public ?string $gender = null;
    public function __construct(string $nic)
    {
        $this->nic = $nic;
        $this->isValid = $this->validate();
        $this->getData();
        $this->checkGender();
        $this->calculateDateOfBirth();
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

    /**
     * @return string
     */
    public function getGender(): ?string
    {
        return $this->gender;
    }

    /**
     * @return string|null
     */
    public function getBirthDay(): ?string
    {
        return $this->birthDay;
    }


    private function getData(): void
    {
        if (strlen($this->nic) == 10) {
            $this->type = Nic::OLD_NIC;
            $this->convertNewFormat();
        } else {
            $this->type =  Nic::NEW_NIC;
        }
    }

    public function convertNewFormat(): void
    {
        $this->nic = "19". substr($this->nic, 0, 5) . "0" . substr($this->nic, 5, 4);
    }

    public function checkGender()
    {
        $this->days = (int) substr($this->nic, 4, 3);
        if ($this->days  <= 366) {
            $this->gender = Nic::MALE;
        } elseif ($this->days  > 500 and $this->days <866) {
            $this->gender = Nic::FEMALE;
        } else {
            $this->gender = null;
            $this->isValid = false;
        }
    }

    public function calculateDateOfBirth()
    {
        if ($this->isValid) {
            if ($this->gender == Nic::MALE) {
                list($month_name, $day) = $this->getMonthNameAndDay($this->days);
            } else {
                list($month_name, $day) = $this->getMonthNameAndDay($this->days-500);
            }
            $this->birthDay = substr($this->nic, 0, 4) . "-". $month_name . "-" . $day;
        }
    }

    private function getMonthNameAndDay($num): array
    {
        $days_in_month = array(31, 29, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
        $month = 1;
        $day = $num;

        while ($day > $days_in_month[$month - 1]) {
            $day -= $days_in_month[$month - 1];
            $month++;
        }

        $date = new DateTime("first day of January");
        $date->add(new DateInterval("P" . ($month - 1) . "M"));
        $month_name = $date->format('F');

        return array($month_name, $day);
    }
}
