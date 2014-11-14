<?php
use Behat\Behat\Context\ClosuredContextInterface,
    Behat\Behat\Context\TranslatedContextInterface,
    Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;
use Guzzle\Service\Client,
    Guzzle\Http\Exception\BadResponseException;

require_once 'PHPUnit/Autoload.php';
require_once 'PHPUnit/Framework/Assert/Functions.php';

/**
 * Features context.
 */
class FeatureContext extends BehatContext
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

    /**
     * Initializes context.
     * Every scenario gets it's own context object.
     * @param   array $parameters Context parameters (set them up through behat.yml)
     */
    public function __construct(array $parameters)
    {
        $this->parameters = $parameters;
        $this->useContext('shared_context', new SharedContext($parameters));
        $this->useContext('rest_context', new RestContext($parameters));
        $this->client = new Client( $parameters['base_url'] );
    }



/**
 * @When /^I request "(GET|PUT|POST|DELETE) ([^"]*)"$/
 */
public function iRequest( $http_method, $resource )
{
    $method = strtolower( $http_method );
    $format = '';

    try
    {
        $this->response = $this->client->$method( $resource . $format )->send();
    }
    catch ( BadResponseException $e )
    {
        $response = $e->getResponse();

        // Sometimes there is not response at all. Guzzle will tell what is happening :D
        if ( $response === null )
        {
            throw $e;
        }

        $this->response = $response;
    }
}

/**
 * @Then /^I get a "([^"]*)" response$/
 */
public function iGetAResponse( $status_code )
{
    $response = $this->getResponse();

    assertSame( (int)$status_code, (int)$response->getStatusCode(), $response->getBody() );
}

/**
 * @Given /^the properties exist:$/
 */
public function thePropertiesExist( PyStringNode $properties_string )
{
    $properties = explode( "\n", (string)$properties_string );
    foreach ( $properties as $property )
    {
        $this->thePropertyExist( $property );
    }
}

/**
 * @Given /^the property "([^"]*)" exist$/
 */
public function thePropertyExist( $property )
{
    $response = $this->arrayGet( $this->getResponseInJson(), $property );
    $property = $this->getScopedProperty( $property );

    assertTrue( array_key_exists( $property, $response ), 'Property ' . $property . ' does not exists in the response' );
}

/**
 * @Given /^the "([^"]*)" property is an integer$/
 */
public function thePropertyIsAnInteger( $property )
{
    $this->propertyIsOfType( 'int', $property );
}

/**
 * @Given /^the "([^"]*)" property is a boolean$/
 */
public function thePropertyIsABoolean( $property )
{
    $this->propertyIsOfType( 'boolean', $property );
}

/**
 * @Given /^the "([^"]*)" property value is "([^"]*)"$/
 */
public function thePropertyValueIs( $property, $value )
{
    $response = $this->getResponseInJson();

    assertSame( $value, $response[$property], $property . ' has no value: ' . $value );
}

protected function propertyIsOfType( $type, $property )
{
    $response = $this->getResponseInJson();

    isType( $type, $response[$property], 'The property ' . $property . ' is not of the type: ' . $type );

}

protected function getResponseInJson()
{
    if ( $this->json_response )
    {
        return $this->json_response;
    }

    $response = $this->getResponse();

    $json = json_decode( $this->getResponse()->getBody( true ), true );

    if (json_last_error() !== JSON_ERROR_NONE)
    {
        throw new Exception( "Failed to parse JSON, error: " . json_last_error() );
    }

    $this->json_response = $json;

    return $this->json_response;
}

/**
 * Gets the response content and checks for some coding errors.
 */
protected function getResponse()
{
    if ( !$this->response )
    {
        throw new Exception( 'You must ask for a request first! asshole' );
    }

    return $this->response;
}

/**
 * Get an item from an array using "dot" notation.
 *
 * @copyright   Taylor Otwell
 * @link        http://laravel.com/docs/helpers
 * @param       array   $array
 * @param       string  $key
 * @return      mixed
 */
protected function arrayGet( $array, $key )
{
    if ( strpos( $key, '.') === false )
    {
        return $array;
    }

    if ( is_null($key) )
    {
        return $array;
    }

    $scopes = explode( '.', $key );

    // Remove the last element, we don't want to get there.
    array_pop( $scopes );

    foreach ( $scopes as $segment )
    {
        if ( is_array( $array ) )
        {
            if ( !array_key_exists( $segment, $array ) )
            {
                return;
            }

            $array = $array[$segment];
        }
    }

    return $array;
}

/**
 * Gets the property name for a scoped key.
 *
 * @param  string $property The property name: id or level1.level2.id
 * @return string           The last property in the string.
 */
protected function getScopedProperty( $property )
{
    $scopes = explode( '.', $property );

    return array_pop( $scopes );
}

}?>
