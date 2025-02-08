<?php

declare(strict_types=1);

namespace App\Command;

use App\Entity\Exercise;
use App\Repository\ExerciseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:create-exercise',
    description: 'Creates a new exercise and saves it in the database'
)]
class CreateExerciseCommand extends Command
{
    private ExerciseRepository $exerciseRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(
        ExerciseRepository $exerciseRepository,
        EntityManagerInterface $entityManager
    ) {
        parent::__construct();
        $this->exerciseRepository = $exerciseRepository;
        $this->entityManager = $entityManager;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('name', InputArgument::REQUIRED, 'Name of the exercise')
            ->addArgument('muscleGroup', InputArgument::REQUIRED, 'Muscle group (e.g., Chest, Legs, etc.)')
            ->addArgument('equipment', InputArgument::OPTIONAL, 'Equipment (e.g., Barbell, Dumbbell)', '');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $name = $input->getArgument('name');
        $muscleGroup = $input->getArgument('muscleGroup');
        $equipment = $input->getArgument('equipment');

        $exercise = new Exercise();
        $exercise->setName($name);
        $exercise->setMuscleGroup($muscleGroup);

        if (!empty($equipment)) {
            $exercise->setEquipment($equipment);
        }

        $this->entityManager->persist($exercise);
        $this->entityManager->flush();

        $output->writeln(sprintf(
            '<info>New exercise "%s" created for muscle group "%s".</info>',
            $name,
            $muscleGroup
        ));

        return Command::SUCCESS;
    }
}
