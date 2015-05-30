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

    /**
     * @param string $days
     * @return Page
     * @throws \Exception
     */
    public function theCurrentPostDateTodayPlusWorkingDays($days)
    {
        $displayeddate = $this->find('css', 'entry-date published updated')->getText();
        $initialDate = \DateTime::createFromFormat('j/M/y', $displayeddate);
        $initialDate->format('d-m-Y');
        $dayCounter = 1;
        $currentDay = $initialDate->getTimestamp();
        while ($dayCounter <= $days) {
            $date = date('d-m-Y', $currentDay);
            $currentDay = strtotime($date . ' +1 day');
            $weekday = date('N', $currentDay);
            if ($weekday < 6) {
                $dayCounter++;
            }
        }
        $final = date('m-d-Y', $currentDay);
        assertEquals($displayeddate, $final);
    }

    /**
     * Javascript method that checks for an element with a specific id
     * @param $idOfElement
     * @return string
     */
    public function javascriptCheckForIdElement($idOfElement)
    {
        $script = 'if ($("#' . $idOfElement . '").length) { return true; } else { return false; }';
        $result = $this->getDriver()->evaluateScript($script);
        return $result;
    }

    /**
     * Javascript method that checks for A Tag element with a specific title tag
     *
     * @param $value
     * @return string
     */
    public function javascriptCheckForHrefThatHasTitleAttributeWithSpecificValue($value)
    {
        $script = '
          Element = jQuery("[title=\'' . $value . '\']");
          if(Element.length == 0) {
            return false
          }
          return true;
          ';
        $result = $this->getDriver()->evaluateScript($script);
        return $result;
    }

    public function checkForBankHolidays($year)
    {
        $bankHolsThisYear = $this->getElement('Holidays')->calculateBankHolidays($year);
        return $bankHolsThisYear;
    }


    /**
     * @Given /^I fill random email for "([^"]*)"$/
     */
    public function iFillRandomEmailFor($emailAddress)
    {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < 15; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        echo($randomString . '@test.com');
        $this->getSession()->getPage()->fillField($emailAddress, $randomString . '@test.com');
    }

    /**
     * @Then /^I should see expected fields "([^"]*)"$/
     */
    public function iShouldSeeExpectedFields($fields)
    {
        $fields2 = 'Salutation,First name,Middle name,Surname,Company name (if relevant),Address 1,Address 2,Address 3,City/Town,County,Postcode,Date of birth,Daytime telephone number,Email address,DX Number,DX Exchange,Occupation,Place a cross (x) against one option that best describes your relationship to the donor,Date attorney signed LPA Part C:,Is attorney applying to register,Date attorney signed LPA002,Active';
        $params = explode(',', $fields);
        foreach ($params as $param) {
            $this->hasField($param);
        }

    }


    /**
     * @Then /^I select first autocomplete option for "([^"]*)"$/
     */
    public function iSelectFirstAutcompleteOption($assigneeField, $searchTerm)

    {
        /**
         * The code below puts text in the input type, calls the jquery autocomplete feature
         * and then simulates clicking an item in the list that is returned.
         * To debug this javascript run a feature that runs this step and echo the $script variable below.
         * Then in the actual application go to allocate on the Widget.
         * On Assign to me: select user and then run the javascript in the console on firefox.
         */
        $this->fillField('searchBox', $searchTerm);
        $script = 'jQuery("#searchBox").autocomplete( "search", "' . $searchTerm . '");
var c = setInterval(function() {


var collection = jQuery("#ui-id-1").find("a"), exists;

collection.each(function(el) {

    if ($(this).text() === "' . $searchTerm . '") {
        exists = $(this);
    }

});

if (exists) {
    exists.click();
    clearInterval(c);
}

}, 50);';
        $this->getDriver()->evaluateScript($script);

    }


    /**
     * Takes current date and adds number of working days
     * @param $days
     * @return Page
     * @throws \Exception
     */
    public function systemDateToTodayPlusWorkingDays($days)
    {
        $t = date('Y-m-d');
        $initialDate = \DateTime::createFromFormat('Y-m-d', $t);
        $dayCounter = 0;
        $currentDay = $initialDate->getTimestamp();
        $currentYear = $initialDate->format('Y');
        $bankHolsThisYear = $this->getElement('Holidays')->calculateBankHolidays($currentYear);
        $bankHolsThisYear2 = $this->getElement('Holidays')->calculateBankHolidays('2015');
        while ($dayCounter <= $days) {
            $date = date('Y-m-d', $currentDay);
            if ((in_array($date, $bankHolsThisYear)) || (in_array($date, $bankHolsThisYear2))) {
                $currentDay = strtotime($date . ' +2 days');
            } else {
                $currentDay = strtotime($date . ' +1 day');
            }
            $date = date('Y-m-d', $currentDay);
            $weekday = date('N', $currentDay);
            if ($weekday < 6) {
                $dayCounter++;
            }
        }
        //return $currentDay;
        $final = date('Y-m-d', $currentDay);
        echo $final;
        exec("sudo /bin/date -s " . $final);
    }


}