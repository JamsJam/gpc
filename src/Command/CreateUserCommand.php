<?php

namespace App\Command;

use App\Service\UserCreateService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Output\ConsoleOutputInterface;


#[AsCommand(
    name: 'app:create-user',
    description: 'Creates a new user.',
    hidden: false,
    aliases: ['app:add-user']
)]
class CreateUserCommand extends Command
{


    public function __construct
    (
        private UserCreateService $userCreateService,
    )
    {

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            // ...
            ->addArgument('prenom', InputArgument::OPTIONAL, 'The username of the user.')
            ->addArgument('nom', InputArgument::OPTIONAL, 'The username of the user.')
            ->addArgument('email', InputArgument::OPTIONAL, 'The username of the user.')
            ->addArgument('password',  InputArgument::OPTIONAL , 'User password')
        ;
    }


    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        if (!$output instanceof ConsoleOutputInterface) {
            throw new \LogicException('This command accepts only an instance of "ConsoleOutputInterface".');
        }

                $io = new SymfonyStyle($input, $output);

        // Afficher le titre de la commande
        $output->writeln([
            '  User Creator',
            '===================',
            '',
        ]);

        // Introduction
        $output->write('You are about to ');
        $output->write('create a user.');
        $output->writeln(['', '', '']);

        // Poser les questions à l'utilisateur avec un affichage personnalisé
        $output->writeln([
            '=========================',
            'What\'s the user\'s last name?',
            '=========================',
        ]);
        $nom = $io->ask('Enter the last name');

        $output->writeln([
            '============================',
            'What\'s the user\'s first name?',
            '============================',
        ]);
        $prenom = $io->ask('Enter the first name');

        $output->writeln([
            '=========================',
            'What\'s the user\'s email?',
            '=========================',
        ]);
        $email = $io->ask('Enter the email address');

        $output->writeln([
            '============================',
            'What\'s the user\'s password?',
            '============================',
        ]);
        $password = $io->askHidden('Enter the password (input will be hidden)');

        // Résumé des informations collectées
        $output->writeln([
            '',
            '=========================',
            'Summary of User Information',
            '=========================',
        ]);
        $output->writeln('Last Name: ' . $nom);
        $output->writeln('First Name: ' . $prenom);
        $output->writeln('Email: ' . $email);
        $output->writeln('Password: (hidden for security)');

        // Appeler le service pour créer l'utilisateur
        // $this->userManager->createUser($prenom, $nom, $email, $password);

        // Afficher un message de succès








        $progressBar = new ProgressBar($output, 50);
        $progressBar->setMessage('Start');
        $progressBar->display();
        $progressBar->start();
        sleep(2);
        $i = 0;
            $progressBar->setMessage('Task is in progress...');
            $progressBar->display();
        while ($i++ < 10) {

            $progressBar->advance();
            usleep(100000);
        }
            $progressBar->setMessage('Create passport...');
            $progressBar->display();
        while ($i++ < 30) {

            $progressBar->advance();
            usleep(100000);
        }
            $progressBar->setMessage('jumping firewall...');
            $progressBar->display();
        while ($i++ < 50) {

            $progressBar->advance();
            usleep(100000);
        }
        $progressBar->setMessage('END');
        $progressBar->display();
        $progressBar->finish();

            try {
                $this->userCreateService->createUser(
                    $nom,
                    $prenom,
                    $email,
                    $password
                );
            } catch (\Throwable $th) {
                $output->writeln([
                    '',
                    '-------------------------',
                    '    USER CREATE FAIL!',
                    $th->getMessage(),
                    '=========================',
                ]);
        
                return Command::FAILURE;
            }



        $output->writeln([
            '',
            '=========================',
            'User Successfully Created!',
            '=========================',
        ]);

        return Command::SUCCESS;

    }


}