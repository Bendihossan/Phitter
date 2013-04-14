<?php
namespace Bendihossan\Phitter\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Bendihossan\Phitter\Command\PhitterCommand;

class RetweetsTimelineCommand extends PhitterCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('home:retweets')
            ->setDescription('Lists latest retweets for this user.')
            ->setHelp('The <info>home:retweets</info> command will list the retweets for this user.');

        // Load parameters
        parent::setup();
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $tweets = $this->makeApiGetRequest('statuses/retweets_of_me', '?count=10');

        foreach ($tweets as $tweet) {
            $output->writeln($tweet['text']);
            $output->writeln($tweet['retweet_count'].' retweets.');
            $output->writeln('');
        }
    }
}
