<?php

use SensioLabs\Behat\PageObjectExtension\Context\PageObjectContext;
use Behat\Gherkin\Node\TableNode;
use Page\Profileform;

class ProfileformContext extends PageObjectContext

{

    private $profileform;

    public function __construct(Profileform $profileform)
    {
        $this->profileform = $profileform;
    }

    /**
     * @param TableNode $table
     * @Given /^I fill form with:$/
     */
    public function iFillFormWith(TableNode $table)
    {
        $this->profileform->fillForm($table);
    }

    /**
     * @param TableNode $table
     * @Given /^I should see form with:$/
     */
    public function iShouldSeeFormWith(TableNode $table)
    {
        $this->profileform->assertFormContain($table);
    }

}