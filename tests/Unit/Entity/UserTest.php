<?php

namespace App\Tests\Unit\Entity;

use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testUserSettersAndGetters(): void
    {
        $user = new User();

        $user->setEmail('test@example.com');
        $this->assertSame('test@example.com', $user->getEmail());

        $user->setPassword('hashedPassword');
        $this->assertSame('hashedPassword', $user->getPassword());

        $user->setRoles(['ROLE_USER']);
        $this->assertContains('ROLE_USER', $user->getRoles());

    }
}
