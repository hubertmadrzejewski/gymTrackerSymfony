<?php

namespace App\Tests\Unit\Service;

use App\Entity\User;
use App\Entity\Workout;
use App\Service\WorkoutService;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;

class WorkoutServiceTest extends TestCase
{
    public function testCreateWorkout(): void
    {
        $em = $this->createMock(EntityManagerInterface::class);

        $em->expects($this->once())->method('persist');
        $em->expects($this->once())->method('flush');

        $service = new WorkoutService($em);

        $user = new User();
        $user->setEmail('user@example.com');

        $date = new \DateTimeImmutable('2025-01-01 10:00:00');
        $workout = $service->createWorkout($user, $date);

        $this->assertInstanceOf(Workout::class, $workout);
        $this->assertSame($user, $workout->getWhoDid());
        $this->assertSame($date, $workout->getDate());
    }
}
