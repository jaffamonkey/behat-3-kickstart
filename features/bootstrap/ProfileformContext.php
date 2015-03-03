<?php

use SensioLabs\Behat\PageObjectExtension\Context\PageObjectContext;
use Behat\Gherkin\Node\TableNode;
use SensioLabs\Behat\PageObjectExtension\Context;
use Page\Profileform;

class ProfileformContext extends PageObjectContext

{

    /**
     * @Given /^I fill form with:$/
     */
    public function iFillFormWith(TableNode $table)
    {
        $this->getPage('Profileform');
    }

    /**
     * @Given /^I should see form with:$/
     */
    public function iShouldSeeFormWith(TableNode $table)
    {
        $this->getPage('Profileform');
    }

}