<?php


use SensioLabs\Behat\PageObjectExtension\Context\PageObjectContext;

class HomepageContext extends PageObjectContext
{
    /**
     * @Given I am logged in as :arg1 with password :arg2
     */
    public function iAmLoggedInAsWithPassword($email, $password)
    {
        $this->getPage('Page/Homepage')->loginCredentials($email, $password);
    }
}