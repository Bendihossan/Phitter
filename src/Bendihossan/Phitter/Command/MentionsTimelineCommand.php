<?php
namespace Bendihossan\Phitter\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Bendihossan\Phitter\Command\PhitterCommand;

class MentionsTimelineCommand extends PhitterCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('home:mentions')
            ->setDescription('Lists latest mentions for this user.')
            ->setHelp('The <info>home:mentions</info> command will list the mentions for this user.');

        // Load parameters
        parent::setup();
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $tweets = $this->makeApiGetRequest('statuses/mentions_timeline', '?count=10');

        foreach ($tweets as $tweet) {
            $output->write('@'.$tweet['user']['screen_name'].': ');
            $output->writeln($tweet['text']);
            $output->writeln('');
        }
    }
}
