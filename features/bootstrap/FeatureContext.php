<?php

use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Behat\Context\Context;
use GuzzleHttp\Client;

require_once __DIR__ . '/../../vendor/phpunit/phpunit/PHPUnit/Autoload.php';
require_once __DIR__ . '/../../vendor/phpunit/phpunit/PHPUnit/Framework/Assert/Functions.php';
require_once __DIR__ . '/../../vendor/phpunit/dbunit/PHPUnit/Extensions/Database/TestCase.php';

/**
 * Features context.
 */
class FeatureContext implements Context, SnippetAcceptingContext
{

    /**
     * The response given from the resource.
     */
    protected $response;

    protected $json_response;
    private $_response;
    public $_client;
    private $_parameters = array();

    /**
     * Initializes context.
     * Every scenario gets it's own context object.
     * @param   array $parameters Context parameters (set them up through behat.yml)
     */

    public function __construct()
    {
       $this->baseUrl = 'http://jaffamonkey.com';
        $client = new Client(['base_url' => 'http://jaffamonkey.com']);
        $this->_client = $client;
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
    public function getParameter($name)
    {
        if (count($this->_parameters) === 0) {
            throw new \Exception('Parameters not loaded!');
        } else {
            $parameters = $this->_parameters;
            return (isset($parameters[$name])) ? $parameters[$name] : null;
        }
    }

    /**
     * Adds Basic Authentication header to next request.
     *
     * @param string $username
     * @param string $password
     *
     * @Given /^I am authenticating as "([^"]*)" with "([^"]*)" password$/
     */
    public function iAmAuthenticatingAs($username, $password)
    {
        // $this->removeHeader('Authorization');
        //$this->authorization = base64_encode($username . ':' . $password);
        $this->addHeader('X-USER-ID:' . $username);
    }

    /**
     * Adds header
     *
     * @param string $header
     */
    protected function addHeader($header)
    {
        $this->headers[] = $header;
    }

    private $headers = array();

    /**
     * @When /^I request "([^"]*)"$/
     */
    public function iRequest($uri)
    {
        $request = $this->_client->get($uri);
        $this->_response = $request;
    }
    /**
     * @Then /^the response should be JSON$/
     */
    public function theResponseShouldBeJson()
    {
        $data = json_decode($this->_response->getBody(true));
        if (empty($data)) { throw new Exception("Response was not JSON\n" . $this->_response);
        }
    }

    /**
     * @Given /^the response has a "([^"]*)" property$/
     */
    public function theResponseHasAProperty($propertyName)
    {
        $data = json_decode($this->_response->getBody(true));
        if (!empty($data)) {
            if (!isset($data->$propertyName)) {
                throw new Exception("Property '".$propertyName."' is not set!\n");
            }
        } else {
            throw new Exception("Response was not JSON\n" . $this->_response->getBody(true));
        }
    }
    /**
     * @Then /^the "([^"]*)" property equals "([^"]*)"$/
     */
    public function thePropertyEquals($propertyName, $propertyValue)
    {
        $data = json_decode($this->_response->getBody(true));
        if (!empty($data)) {
            if (!isset($data->$propertyName)) {
                throw new Exception("Property '".$propertyName."' is not set!\n");
            }
            if ($data->$propertyName !== $propertyValue) {
                throw new \Exception('Property value mismatch! (given: '.$propertyValue.', match: '.$data->$propertyName.')');
            }
        } else {
            throw new Exception("Response was not JSON\n" . $this->_response->getBody(true));
        }
        echo $data->$propertyName;
    }
}

?>
