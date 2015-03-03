<?php


use SensioLabs\Behat\PageObjectExtension\Context\PageObjectContext;
use Page\Homepage;

class HomepageContext extends PageObjectContext
{
    /**
     * @Given I am logged in as :arg1 with password :arg2
     */
    public function iAmLoggedInAsWithPassword($email, $password)
    {
        $this->getPage('Homepage')->loginCredentials($email, $password);
    }
}