<?php

namespace Page;

use SensioLabs\Behat\PageObjectExtension\PageObject\Page;
use Behat\Mink;

class Homepage extends Page
{

    /**
     * @param string $email
     * @param string $password
     * @return Page
     */
    public function loginCredentials($email, $password)
    {
        $this->fillField('user_login', $email);
        $this->fillField('user_pass', $password);
        $this->pressButton('wp-submit');
    }
}