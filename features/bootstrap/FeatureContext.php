<?php

use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\MinkExtension\Context\RawMinkContext;
use Behat\Behat\Context\Context;
use Behat\WebApiExtension;


/**
 * Features context.
 */
class FeatureContext extends RawMinkContext implements Context, SnippetAcceptingContext
{

    /**
     * Initializes context.
     * Every scenario gets it's own context object.
     */
    public function __construct()
    {
    }

    /**
     * @Then /^count of "([^"]*)" instances of "(?P<text>[^"]*)" exists on page$/
     */
    public function thePersonsAreUnlinked($count, $area)
    {
        $str = $this->getSession()->getPage()->getContent();
        $count2 = substr_count($str, $area);
        echo $count2;
        if ($count != $count2) {
            throw new \Exception('Count is incorrect');
        };
    }
}

