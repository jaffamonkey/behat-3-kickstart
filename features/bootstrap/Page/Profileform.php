<?php

namespace Page;

use SensioLabs\Behat\PageObjectExtension\PageObject\Page;
use Behat\Behat\Definition\Call;
use Behat\Gherkin\Node\TableNode;


class Profileform extends Page
{

    /**
     * @param TableNode $table
     * @return Page
     * @throws \Exception
     */
    public function fillOutForm(TableNode $table)
    {
        return $this->getElement('Formfilling')->fillForm($table);
    }

    /**
     * @param TableNode $table
     * @return Page
     * @throws \Exception
     */
    public function checkFormContains(TableNode $table)
    {
        return $this->getElement('Formfilling')->assertFormContains($table);
    }


    /**
     * @When /^I click the "([^"]*)" radio button$/
     */
    public function iClickTheRadioButton($radioLabel)
    {
        $radioButton = $this->findField($radioLabel);
        if (null === $radioButton) {
            throw new \Exception("Cannot find radio button " . $radioLabel);
        }
        $this->getDriver()->click($radioButton->getXPath());
    }

}