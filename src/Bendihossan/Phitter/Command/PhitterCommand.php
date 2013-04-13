<?php
namespace Bendihossan\Phitter\Command;

use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command;

class PhitterCommand extends Command
{
    protected  $CONSUMER_KEY = null;
    protected  $CONSUMER_SECRET = null;
    protected  $TWITTER_TOKEN = null;
    protected  $TWITTER_TOKEN_SECRET = null;

    protected function setup() {
        $parameters = file_get_contents(__DIR__.'/../../../../Resources/config/parameters.json');
        $parameters = json_decode($parameters, true);

        $this->CONSUMER_KEY = $parameters['tokens']['CONSUMER_KEY'];
        $this->CONSUMER_SECRET = $parameters['tokens']['CONSUMER_SECRET'];
        $this->TWITTER_TOKEN = $parameters['tokens']['TWITTER_TOKEN'];
        $this->TWITTER_TOKEN_SECRET = $parameters['tokens']['TWITTER_TOKEN_SECRET'];
    }

    /**
     * @Prints a message before a section of info.
     *
     * @param string $sectionMessage Message to be printed for this section
     * @param OutputInterface $output Allows us to write to the console.php in colour
     */
    protected function newSection($sectionMessage, OutputInterface $output)
    {
        $output->writeln('<comment>'.$sectionMessage.': </comment>');
    }
}
