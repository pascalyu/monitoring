<?php

namespace App\Command;

use App\Controller\HomeController;
use App\Repository\WebsiteRepository;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CheckStatusCommand extends Command
{
    protected static $defaultName = 'check:status';

    public function __construct(HomeController $controller, WebsiteRepository $repository,EntityManagerInterface $manager)
    {
        parent::__construct();
        $this->controller=$controller;
        $this->repository= $repository;
        $this->manager=$manager;
    }

    protected function configure()
    {
        $this
            ->setDescription('Add a short description for your command')
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $arg1 = $input->getArgument('arg1');

        if ($arg1) {
            $io->note(sprintf('You passed an argument: %s', $arg1));
        }

        if ($input->getOption('option1')) {
            // ...
        }
        $this->controller->analyze($this->repository,$this->manager);
        $io->success("Cette commandder sert à récupérer le status actuel des sites stockés en base. ENtrer check:status --helo pour plus d infos");

        return 0;
    }
}
