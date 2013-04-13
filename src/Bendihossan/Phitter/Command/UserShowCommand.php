<?php
namespace Bendihossan\Phitter\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Bendihossan\Phitter\Command\PhitterCommand;

class UserShowCommand extends PhitterCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('user:show')
            ->addArgument(
                'username',
                InputArgument::REQUIRED,
                'The ID of the user for whom to return results for.'
            )
            ->setDescription('Lists latest tweets from a user.')
            ->setHelp('The <info>user:show</info> takes an required argument for a username.');

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
            $username = '';
        } else {
            $username = '?screen_name='.$name;
        }

        $oauth = new \OAuth(
            $this->CONSUMER_KEY,
            $this->CONSUMER_SECRET,
            OAUTH_SIG_METHOD_HMACSHA1,
            OAUTH_AUTH_TYPE_URI
        );

        $oauth->setToken($this->TWITTER_TOKEN, $this->TWITTER_TOKEN_SECRET);
        $oauth->fetch('http://api.twitter.com/1.1/users/show.json'.$username);

        $user = json_decode($oauth->getLastResponse(), true);

        $output->writeln('<info>Name</info>: '. $user['name']);
        $output->writeln('<info>Description</info>: '.$user['description']);
        $output->writeln('<info>Location</info>: '.$user['location']);
        $output->writeln('<info>Website</info>: '.$user['url']);
        $output->writeln('<info>Number of Tweets</info>: '.number_format($user['statuses_count']));
        $output->writeln('<info>Number of Followers</info>: '.number_format($user['friends_count']));
        $output->writeln('<info>Following</info>: '.($user['following'] == true ? 'Yes' : 'No'));
        $output->writeln('<info>Verified:</info> '.($user['verified'] == true ? 'Yes' : 'No'));
    }
}
