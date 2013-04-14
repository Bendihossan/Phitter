<?php
namespace Bendihossan\Phitter\Command;

use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command;

class PhitterCommand extends Command
{
    protected $CONSUMER_KEY = null;
    protected $CONSUMER_SECRET = null;
    protected $TWITTER_TOKEN = null;
    protected $TWITTER_TOKEN_SECRET = null;

    protected $oauth = null;
    protected $apiUrl = 'https://api.twitter.com/1.1/';

    protected function setup()
    {
        $parameters = file_get_contents(__DIR__.'/../../../../Resources/config/parameters.json');
        $parameters = json_decode($parameters, true);

        $this->CONSUMER_KEY = $parameters['tokens']['CONSUMER_KEY'];
        $this->CONSUMER_SECRET = $parameters['tokens']['CONSUMER_SECRET'];
        $this->TWITTER_TOKEN = $parameters['tokens']['TWITTER_TOKEN'];
        $this->TWITTER_TOKEN_SECRET = $parameters['tokens']['TWITTER_TOKEN_SECRET'];

        $this->oauth = new \OAuth(
            $this->CONSUMER_KEY,
            $this->CONSUMER_SECRET,
            OAUTH_SIG_METHOD_HMACSHA1,
            OAUTH_AUTH_TYPE_URI
        );

        $this->oauth->setToken($this->TWITTER_TOKEN, $this->TWITTER_TOKEN_SECRET);
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


    /**
     * Makes a GET request to the API to retrieve information.
     *
     * @param string $endpoint The endpoint to request data from.
     * @param string $parameters Parameters to send onthe GET request.
     * @return mixed
     */
    protected function makeApiGetRequest($endpoint, $parameters)
    {
        $this->oauth->fetch($this->apiUrl.$endpoint.'.json'.$parameters);

        return json_decode($this->oauth->getLastResponse(), true);
    }

    /**
     * Makes a POST request to send information to Twitter.
     *
     * @param string $endpoint The endpoint to POST to.
     * @param string $parameters The message being sent.
     * @return bool
     */
    protected function makeApiPostRequest($endpoint, $parameters)
    {
        return $this->oauth->fetch(
            $this->apiUrl.$endpoint.'.json',
            array(
                'status' => $parameters
            ),
            OAUTH_HTTP_METHOD_POST
        );
    }
}
