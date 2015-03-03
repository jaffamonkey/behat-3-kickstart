<?php

namespace Page;

use SensioLabs\Behat\PageObjectExtension\PageObject\Page;

class Homepage extends Page
{

    /**
     * Initializes context.
     * Every scenario gets it's own context object.
     */
    public function __construct()
    {
        $this->getPage('Homepage');
    }

    /**
     * @param string $email
     * @param string $password
     * @return Page
     */
    public function loginCredentials($email, $password)
    {
        $this->open('/');
        $this->clickLink('Login');
        $this->fillField('username', $email);
        $this->fillField('password', $password);
        $this->pressButton('_submit');
    }
}