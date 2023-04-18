<?php

declare(strict_types=1);

namespace App\Command;

use App\Entity\User;
use App\Repository\UserRepository;
use SendGrid;
use SendGrid\Mail\HtmlContent;
use SendGrid\Mail\Mail;
use SendGrid\Mail\Personalization;
use SendGrid\Mail\PlainTextContent;
use SendGrid\Mail\To;
use SendGrid\Mail\TypeException;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use function sprintf;

#[AsCommand(
    name: 'notify:subscribers:email',
    description: 'Notifies email users of their next bin collection day.'
)]
class NotifyEmailSubscribersCommand extends Command
{
    use NotifySubscribersTrait;

    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly SendGrid $client
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setHelp('This command notifies all subscribers of their next bin collection day.')
            ->addArgument('user-type', InputArgument::OPTIONAL, 'The user type to notify. Defaults to all users.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $users = $this->userRepository->getEmailUsers();
        if (empty($users)) {
            $output->writeln("<info>No email users to send quotes to.</info>\n");
            return Command::SUCCESS;
        }

        $output->writeln("<info>Notifying email users about their next bin collection day.</info>\n");

        foreach ($users as $user) {
            $this->client->send($this->buildMailMessage(new Mail(), $user));

            $output->writeln(" - Sending notification to email number: {$user->getEmail()}.");
        }

        $output->writeln("\n<info>Notification complete.</info>");

        return Command::SUCCESS;
    }

    /**
     * @throws TypeException
     */
    public function buildMailMessage(Mail $mail, User $user): Mail
    {
        $emailTemplate     = <<<EOF
<p>Hi %s,</p>
<p>We just wanted to let you know that your next bin collection day is <strong>%s</strong>.</p>
<p>If you're not sure what to put in which bin, <a href="%s">check out our helpful, downloadable, guide</a>.</p>
<p><strong>Best,</strong></p>
<p><strong>Your local, regional council.</strong></p>
EOF;
        $plainTextTemplate = <<<EOF
Hi %s

Just wanted to let you know that your next bin collection is %s.

If you're not sure what to put in which bin, check out our helpful, downloadable, guide at %s.

Best,

Your local, regional council.
EOF;

        $mail->setFrom($_ENV['SEND_FROM_EMAIL_ADDRESS']);
        $mail->setReplyTo($_ENV['SEND_FROM_EMAIL_ADDRESS']);
        $mail->setSubject('Your Next Bin Collection Day');

        $binCollectionDay = $user->getBinCollectionDay();

        $mail->addContent(
            new HtmlContent(
                sprintf(
                    $emailTemplate,
                    $user->getFullName(),
                    $this->getNextBinCollectionDay($binCollectionDay),
                    self::URL_BIN_GUIDE
                )
            )
        );
        $mail->addContent(
            new PlainTextContent(
                sprintf(
                    $emailTemplate,
                    $user->getFullName(),
                    $this->getNextBinCollectionDay($binCollectionDay),
                    self::URL_BIN_GUIDE
                )
            )
        );

        $personalisation = new Personalization();
        $personalisation->addTo(new To($user->getEmail(), $user->getFullName()));
        $mail->addPersonalization($personalisation);

        return $mail;
    }
}
