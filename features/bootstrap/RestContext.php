<?php
use Behat\Behat\Context\BehatContext;

class RestContext extends BehatContext
{
    private $_client;
    private $_parameters;
    private $_response;
    public function __construct(array $parameters)
    {
        $this->_parameters = $parameters;
        $this->_client = new Guzzle\HTTP\Client();
    }
    /**
     * @When /^I ([A-Za-z]+) request "([^"]*)"$/
     */
    public function iRequest($method, $path)
    {
        $url = $this->_parameters['base_url'] . $path;
        $method = strtolower($method);
        try {
            $this->_response = $this->_client->$method($url)->send();
        } catch (Guzzle\Http\Exception\BadResponseException $e) {
            $this->_response = $e->getResponse();
            // don't care about 404
        }
    }
    /**
     * @Given /^I am logged in$/
     */
    public function iAmLoggedIn()
    {
        // NO-OP for now
        // throw new PendingException();
    }
    /**
     * @Then /^the list contains (\d+)$/
     */
    public function theListContains($count)
    {
        $data = $this->_response->json();
        if (count($data) != $count) {
            throw new Exception("Response does not count $count items.");
        }
    }
    /**
     * @Then /^the ([A-Za-z]+) property equals "([^"]*)"$/
     */
    public function theNamePropertyEquals($name, $value)
    {
        $data = $this->_response->json();
        if (!isset($data[$name])) {print_r($data);
            throw new Exception("$name property does not exist in response.");
        }
        if ($data[$name] != $value) {
            throw new Exception("$name does not match $value in response.");
        }
    }
    /**
     * @Then /^the response status is (\d+)$/
     */
    public function theResponseStatusIs($status)
    {
        $actualStatus = $this->_response->getStatusCode();
        if ($actualStatus != $status) {
            throw new Exception("HTTP Status $actualStatus != $status.");
        }
    }
    /**
     * @Given /^the response is blank$/
     */
    public function theResponseIsBlank()
    {
        if (strlen($this->_response->getBody(true)) > 0) {
            throw new Exception();
        }
    }
}