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


    /**
     * @param string $count
     * @param string $area
     * @return Page
     * @throws \Exception
     */
    public function countTheElements($count, $area)
    {
        $str = $this->getDriver()->getContent();
        $count2 = substr_count($str, $area);
        if ($count != $count2) {
            throw new \Exception($count . ' is incorrect, it should be: ' . $count2);
        };
    }

}