<?php

namespace App\Command;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Services\RhService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class RestoPeopleImportCommand extends Command
{
    protected static $defaultName = 'resto:people:import';

    private $rhService;
    private $userRepository;
    private $em;

    public function __construct(RhService $rhService, UserRepository $userRepository, EntityManagerInterface $em)
    {
        parent::__construct();
        $this->rhService = $rhService;
        $this->userRepository = $userRepository;
        $this->em = $em;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $people = $this->rhService->getPeople();

        foreach ($people as $person) {
            if ($user = $this->userRepository->findOneBy(['username' => $person['id']])) {
                $user->setFirstname($person['firstname'])
                    ->setLastName($person['lastname'])
                    ->setEmail($person['email'])
                    ->setJotTitle($person['jobtitle']);

                $io->success(sprintf('%s updated', $user->getUsername()));
            } else {
                $user = (new User())
                    ->setUsername($person['id'])
                    ->setFirstname($person['firstname'])
                    ->setLastName($person['lastname'])
                    ->setEmail($person['email'])
                    ->setJotTitle($person['jobtitle']);
                $io->success(sprintf('%s created', $user->getUsername()));
            }
            $this->em->persist($user);
            $this->em->flush();
        }

        return Command::SUCCESS;
    }
}