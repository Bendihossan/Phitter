<?php
namespace Bendihossan\Phitter\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Bendihossan\Phitter\Command\PhitterCommand;

class HomeTweetCommand extends PhitterCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('home:tweet')
            ->setDescription('Post a new tweet.')
            ->addArgument(
                'tweet',
                InputArgument::REQUIRED,
                'The tweet to post.'
            )
            ->setHelp('The <info>home:tweet</info> command will post a new tweet.');

        // Load parameters
        parent::setup();
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $tweet = $input->getArgument('tweet');

        if (strlen($tweet) > 140) {
            $output->writeln('');
            $output->writeln('Your tweet was over 140 characters!');
            $output->writeln('Please shorten your message and try again.');
            exit(1);
        }

        $tweetSuccess = $this->makeApiPostRequest('statuses/update', $tweet);

        if (!$tweetSuccess) {
            $output->writeln('<error>Failed to send tweet!</error>');
        } else {
            $output->writeln('"'.$tweet.'" has been sent!');
        }
    }
}
