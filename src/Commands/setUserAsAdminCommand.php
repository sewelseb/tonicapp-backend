<?php
namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

// the name of the command is what users type after "php bin/console"
#[AsCommand(name: 'app:set-user-as-admin',hidden: false)]
class SetUserAsAdminCommand extends Command
{
    protected static $defaultDescription = 'add the ADMIN_ROLE to a user';

    public function __construct($name)
    {
        parent::__construct($name);
    }
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('email: '.$input->getArgument('email'));


        return Command::SUCCESS;

    }
}