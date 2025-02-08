<?php

declare(strict_types=1);

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:create-user',
    description: 'Creates a new user'
)]
class CreateUserCommand extends Command
{
    protected function configure(): void
    {
        $this
            ->addArgument(
                'username',
                InputArgument::REQUIRED,
                'Username for the new user'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln([
            'User Creator',
            '============',
            '',
        ]);

        $username = $input->getArgument('username');

        $output->writeln('Username: '.$username);

        $output->writeln('User created successfully!');

        return Command::SUCCESS;
    }
}
