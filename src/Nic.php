<?php

namespace Softhub\SlNicNumber;

use DateTime;
use DateTimeImmutable;
use Softhub\SlNicNumber\Enums\Category;
use Softhub\SlNicNumber\Enums\Gender;
use Softhub\SlNicNumber\Exceptions\InvalidNicException;

class Nic
{
    const FEMALE_DOB_LEAD = 500;

    private string $nic;
    private Category $category;
    private ?DateTimeImmutable $birthDay = null;

    public function __construct(string $nic)
    {
        if ($this->validate($nic)) {
            $this->setCategoryAndParseToNewFormat($nic);
        }
    }

    public static function from(string $nic): Nic
    {
        return new Nic($nic);
    }

    public function getCategory(): Category
    {
        return $this->category;
    }

    public function getGender(): Gender
    {
        return $this->getBornDayOfTheYearSection() > self::FEMALE_DOB_LEAD ? Gender::Female : Gender::Male;
    }

    public function getBornDayOfTheYear(): int
    {
        $section = $this->getBornDayOfTheYearSection();

        return $this->isFemale() ? $section - (self::FEMALE_DOB_LEAD + 1) : $section;
    }

    public function getDateOfBirth(): DateTimeImmutable
    {
        if (is_null($this->birthDay)) {
            $dob = DateTime::createFromFormat('Y-m-d', $this->getBornYear() . '-01-01');
            $days = $this->getBornDayOfTheYear() - 1;
            $dob->modify("+{$days} days");
            $this->birthDay = DateTimeImmutable::createFromMutable($dob);
        }

        return $this->birthDay;
    }

    private function validate($nic): bool
    {
        if (preg_match('/^[0-9]{9}[vVxX]$|^[0-9]{12}$/', $nic)) {
            return true;
        }

        throw new InvalidNicException();
    }

    private function getBornYear(): int
    {
        return (int) substr($this->nic, 0, 4);
    }

    private function getBornDayOfTheYearSection(): int
    {
        return (int) substr($this->nic, 4, 3);
    }

    private function setCategoryAndParseToNewFormat($nic): void
    {
        $this->category = strlen($nic) == 10 ? Category::Old : Category::New;

        $this->nic = $this->getCategory() === Category::Old ?
            "19". substr($nic, 0, 5) . "0" . substr($nic, 5, 4) :
            $nic;
    }

    private function isFemale(): bool
    {
        return $this->getGender() === Gender::Female;
    }
}
