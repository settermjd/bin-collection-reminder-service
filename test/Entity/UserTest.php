<?php

declare(strict_types=1);

namespace Entity;

use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    /**
     * @dataProvider userDataDataProvider
     */
    public function testCanInitialiseObject(?array $userData = [])
    {
        [
            'id'       => $id,
            'suburb'   => $suburb,
            'email'    => $email,
            'mobile'   => $mobile,
            'fullName' => $fullName,
        ]     = $userData;
        $user = new User($suburb, $email, $mobile, $fullName, $id);

        $this->assertSame($id, $user->getId());
        $this->assertSame($suburb, $user->getSuburb());
        $this->assertSame($email, $user->getEmail());
        $this->assertSame($mobile, $user->getMobile());
        $this->assertSame($fullName, $user->getFullName());
    }

    public function userDataDataProvider(): array
    {
        return [
            [
                [
                    'id'       => 1,
                    'suburb'   => 'Enoggera',
                    'email'    => 'user@example.org',
                    'mobile'   => '+4298798402322',
                    'fullName' => 'Hugh Jackman',
                ],
            ],
        ];
    }
}
