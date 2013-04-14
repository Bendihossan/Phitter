<?php
namespace Bendihossan\Phitter\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Bendihossan\Phitter\Command\PhitterCommand;

class UserTimelineCommand extends PhitterCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('user:timeline')
            ->addArgument(
                'username',
                InputArgument::OPTIONAL,
                'The ID of the user for whom to return results for. Defaults value is the logged in user.'
            )
            ->setDescription('Lists latest tweets from a user. Defaults to you.')
            ->setHelp('The <info>user:timeline</info> takes an optional argument for a username. Defaults to you.');

        // Load parameters
        parent::setup();
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument('username');

        if (!isset($name)) {
            $parameters = '';
        } else {
            $parameters = '&screen_name='.$name;
        }

        $tweets = $this->makeApiGetRequest('statuses/user_timeline', '?count=10'.$parameters);

        foreach ($tweets as $tweet) {
            $output->writeln($tweet['text']);
            $output->writeln('');
        }
    }
}
