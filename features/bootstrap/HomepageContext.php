<?php

use SensioLabs\Behat\PageObjectExtension\Context\PageObjectContext;

class HomepageContext extends PageObjectContext
{

    public function __construct()
    {
    }

    /**
     * @Given I am logged in as :arg1 with password :arg2
     */
    public function iAmLoggedInAsWithPassword($email, $password)
    {
        $this->getPage('Homepage')->loginCredentials($email, $password);
    }

    /**
     * @Then /^count of "([^"]*)" instances of "(?P<text>[^"]*)" exists on page$/
     */
    public function countOfExistsOnPage($count, $area)
    {
        $this->getPage('Homepage')->countTheElements($count, $area);
    }

    /**
     * @Given /^the current post display date is today plus "([^"]*)" working days$/
     */
    public function taskDueDateIsRegDueDatePlusDays($workingDays)
    {
        $this->getPage('Homepage')->theCurrentPostDateTodayPlusWorkingDays($workingDays);
    }

    /**
     * @Given /^I set system date to today plus "([^"]*)" working days$/
     */
    public function iSetSystemDateToTodayPlusWorkingDays($days)
    {
        $this->getPage('Homepage')->systemDateToTodayPlusWorkingDays($days);
    }

}