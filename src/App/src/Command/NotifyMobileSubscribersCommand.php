<?php

declare(strict_types=1);

namespace App\Command;

use App\Repository\UserRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Twilio\Rest\Client;

use function sprintf;

#[AsCommand(
    name: 'notify:subscribers:mobile',
    description: 'Notifies mobile users of their next bin collection day.'
)]
class NotifyMobileSubscribersCommand extends Command
{
    use NotifySubscribersTrait;

    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly Client $client
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setHelp('This command notifies all subscribers of their next bin collection day.')
            ->addArgument(
                'user-type',
                InputArgument::OPTIONAL,
                'The user type to notify. Defaults to all users.'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln("<info>Notifying mobile users about their next bin collection day.</info>\n");

        $users = $this->userRepository->getMobileUsers();
        if (empty($users)) {
            $output->writeln("<info>No email users to send quotes to.</info>");
            return Command::SUCCESS;
        }

        foreach ($users as $user) {
            $bodyTemplate = <<<EOF
Your next bin collection is on %s. 

Not sure about what to put in which bin? Check out our helpful guide at %s
EOF;

            $this->client
                ->messages
                ->create(
                    $user->getMobile(),
                    [
                        'from' => $_ENV['TWILIO_PHONE_NUMBER'],
                        'body' => sprintf(
                            $bodyTemplate,
                            $this->getNextBinCollectionDay($user->getBinCollectionDay()),
                            self::URL_BIN_GUIDE
                        ),
                    ]
                );

            $output->writeln(
                sprintf(" - Sending notification to mobile number: %s.", $user->getMobile())
            );
        }

        $output->writeln("\n<info>Notifying mobile users about their next bin collection day.</info>");

        return Command::SUCCESS;
    }
}
