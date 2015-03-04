<?php

use SensioLabs\Behat\PageObjectExtension\Context\PageObjectContext;
use Page\Homepage;

class HomepageContext extends PageObjectContext
{

    private $homepage;

    public function __construct(Homepage $homepage)
    {
        $this->homepage = $homepage;
    }
    
    /**
     * @Given I am logged in as :arg1 with password :arg2
     */
    public function iAmLoggedInAsWithPassword($email, $password)
    {
        $this->homepage->loginCredentials($email, $password);
    }
}