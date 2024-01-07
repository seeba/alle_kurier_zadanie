<?php

namespace App\Core\User\UserInterface\Cli;

use App\Common\Bus\QueryBusInterface;
use App\Core\User\Application\DTO\EmailDTO;
use App\Core\User\Application\Query\GetUsersEmailsByStatus\GetUsersEmailsByStatusQuery;
use App\Core\User\Domain\Status\UserStatus;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:user:get-inactive-email',
    description: 'Pobieranie adresów email użytkowników nieaktywnych'
)]
class GetInactiveUsersEmails extends Command
{
    public function __construct(private readonly QueryBusInterface $bus)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $emails = $this->bus->dispatch(new GetUsersEmailsByStatusQuery(
            UserStatus::INACTIVE
        ));

        /** @var EmailDTO $email */
        foreach ($emails as $email) {
            $output->writeln($email->email);
        }

        return Command::SUCCESS;
    }

    protected function configure(): void
    {
    }
}
