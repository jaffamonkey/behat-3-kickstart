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

}?>
