<?php
namespace Bendihossan\Phitter\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Bendihossan\Phitter\Command\PhitterCommand;

class HomeTimelineCommand extends PhitterCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('home:timeline')
            ->setDescription('Lists latest tweets from your followers.')
            ->setHelp('The <info>home:timeline</info> command will list the latest tweets from the people you follow.');

        // Load parameters
        parent::setup();
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $oauth = new \OAuth(
            $this->CONSUMER_KEY,
            $this->CONSUMER_SECRET,
            OAUTH_SIG_METHOD_HMACSHA1,
            OAUTH_AUTH_TYPE_URI
        );

        $oauth->setToken($this->TWITTER_TOKEN, $this->TWITTER_TOKEN_SECRET);
        $oauth->fetch('https://api.twitter.com/1.1/statuses/home_timeline.json?count=10');

        $tweets = json_decode($oauth->getLastResponse(), true);

        foreach ($tweets as $tweet) {
            $output->write('@'.$tweet['user']['screen_name'].': ');
            $output->writeln($tweet['text']);
            $output->writeln('');
        }
    }
}
