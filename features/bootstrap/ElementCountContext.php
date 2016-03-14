<?php

use SensioLabs\Behat\PageObjectExtension\Context\PageObjectContext;

class ElementcountContext extends PageObjectContext
{

    public function __construct()
    {
    }

    /**
     * @Then /^count of "([^"]*)" instances of "(?P<text>[^"]*)" exists on page$/
     */
    public function countOfExistsOnPage($count, $area)
    {
        $this->getPage('Elementcount')->countOfElements($count, $area);
    }

}