<?php

namespace Page;

use SensioLabs\Behat\PageObjectExtension\PageObject\Page;
use Behat\Mink;

class Elementcount extends Page
{

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