<?php

use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Behat\Context\Context;
use Guzzle\Service\Client,
    Guzzle\Http\Exception\BadResponseException;

require_once '../../vendor/phpunit/phpunit/PHPUnit/Autoload.php';
require_once '../../vendor/phpunit/phpunit/PHPUnit/Framework/Assert/Functions.php';

/**
 * Features context.
 */
class FeatureContext implements Context, SnippetAcceptingContext
{
    /**
     * The HTTP Client.
     *
     * @var Guzzle\Service\Client
     */
    protected $client;

    /**
     * The response given from the resource.
     */
    protected $response;

    protected $json_response;
    private $_response;

    /**
     * Initializes context.
     * Every scenario gets it's own context object.
     * @param   array $parameters Context parameters (set them up through behat.yml)
     */
    public function __construct(array $parameters)
    {
        $this->parameters = $parameters;
        $this->client = new Client($parameters['base_url']);
        new SharedContext($parameters['base_url']);
    }

    public function spin($lambda, $wait = 60)
    {
        for ($i = 0; $i < $wait; $i++) {
            try {
                if ($lambda($this)) {
                    return true;
                }
            } catch (Exception $e) {
                // do nothing
            }

            sleep(1);
        }

        $backtrace = debug_backtrace();

        throw new Exception(
            "Timeout thrown by " . $backtrace[1]['class'] . "::" . $backtrace[1]['function'] . "()\n" .
            $backtrace[1]['file'] . ", line " . $backtrace[1]['line']
        );
    }

    /**
     * @Then /^the ([A-Za-z]+) property equals "([^"]*)"$/
     */
    public function theNamePropertyEquals($name, $value)
    {
        $data = $this->_response->json();
        if (!isset($data[$name])) {
            print_r($data);
            throw new Exception("$name property does not exist in response.");
        }
        if ($data[$name] != $value) {
            throw new Exception("$name does not match $value in response.");
        }
    }

}

?>
