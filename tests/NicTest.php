<?php

declare(strict_types=1);

namespace Softhub\SlNicNumber;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Softhub\SlNicNumber\Enums\Category;
use Softhub\SlNicNumber\Enums\Gender;
use Softhub\SlNicNumber\Exceptions\InvalidNicException;

class NicTest extends TestCase
{
    /**
     * @dataProvider validNicNumbersProvider
     */
    public function test_can_crete_an_instance_with_a_valid_nic($nic)
    {
        $this->assertInstanceOf(Nic::class, Nic::from($nic));
    }

    public function validNicNumbersProvider(): array
    {
        return [
            'old format' => ['123456789v'],
            'new format' => ['199912345782'],
        ];
    }

    /**
     * @dataProvider invalidNicNumbersProvider
     */
    public function test_it_validate_nic($nic)
    {
        $this->expectException(InvalidNicException::class);

        new Nic($nic);
    }

    public function invalidNicNumbersProvider(): array
    {
        return [
            'short' => ['123456789'],
            'long' => ['123456789646464'],
            'with white space' => ['12 34567 89v'],
        ];
    }

    /**
     * @dataProvider nicWithCategoryProvider
     */
    public function test_can_get_the_category(string $nicNumber, Category $category)
    {
        $nic  = Nic::from($nicNumber);
        $this->assertEquals($category, $nic->getCategory());
    }

    public function nicWithCategoryProvider(): array
    {
        return[
            'old format' => ['123456789V', Category::Old],
            'new format' => ['199912345783', Category::New],
        ];
    }

    /**
     * @dataProvider nicWithGenderProvider
     */
    public function test_can_get_the_gender(string $nicNumber, Gender $gender)
    {
        $nic = Nic::from($nicNumber);
        $this->assertEquals($gender, $nic->getGender());
    }

    public function nicWithGenderProvider(): array
    {
        return[
            'female old format' => ['996261000v', Gender::Female],
            'female new format' => ['199962345784', Gender::Female],
            'male old format' => ['123456789v', Gender::Male],
            'male new format' => ['199912345784', Gender::Male],
        ];
    }

    /**
     * @dataProvider nicWithDobDetailsProvider
     */
    public function test_can_get_the_date_of_birth(string $nicNumber, string $dateOfBirth)
    {
        $nic = Nic::from($nicNumber);
        $dob = $nic->getDateOfBirth();

        $this->assertInstanceOf(DateTimeImmutable::class, $dob);
        $this->assertEquals($dateOfBirth, $dob->format('Y-m-d'));
    }

    public function nicWithDobDetailsProvider(): array
    {
        return[
            ['890213529v', '1989-01-21'],
            ['198902130529', '1989-01-21'],
            ['918383794v', '1991-12-03'],
            ['199183830794', '1991-12-03'],
        ];
    }
}
