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
    public function countOfElements($count, $area)
    {
        $str = $this->getContent();
        $count2 = substr_count($str, $area);
        echo $count2;
        if ($count != $count2) {
            throw new \Exception('Count is incorrect');
        };
    }

}