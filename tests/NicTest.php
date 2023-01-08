<?php

declare(strict_types=1);

namespace Softhub\SlNicNumber;

class NicTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider validityNicNumbers
     */
    public function test_nic_validate_by_regular_expression(string $nicnumber, bool $validity)
    {
        $nic = new Nic($nicnumber);
        $this->assertEquals($validity, $nic->isValid);
    }


    /**
     * @dataProvider validNic
     */
    public function test_nic_old_or_new(string $nicNumber, string $type)
    {
        $nic  = new Nic($nicNumber);
        $this->assertEquals($type, $nic->getType());
    }

    /**
     * @dataProvider toConvertNewFormat
     */
    public function test_convert_old_to_new_format(string $nicNumber, string $newNumber)
    {
        $nic = new Nic($nicNumber);
        $this->assertEquals($newNumber, $nic->nic);
    }

    public function validityNicNumbers()
    {
        return [
            ['123456789v', true],
            ['123456789V', true],
            ['19991234578', true],
            ['123456789y', false],
            ['1234v56789', false],
            ['v123456789', false],
            ['123456789', false],
            ['12 34567 89v',false],
        ];
    }

    public function validNic()
    {
        return[
            ['123456789v', Nic::OLD_NIC],
            ['123456789V', Nic::OLD_NIC],
            ['19991234578', Nic::NEW_NIC],
        ];
    }

    public function toConvertNewFormat()
    {
        return[
            ['123456789v', "191234506789"],
            ['123456789V', "191234506789"],
            ['993261000v', '199932601000']
        ];
    }

}
