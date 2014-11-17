<?php

/**
 * @author Paul Littlebury <paul.littlebury@gmail.com>
 */
use Behat\MinkExtension\Context\RawMinkContext;
use Behat\Behat\Context\SnippetAcceptingContext;

/**
 * Behat context class.
 */
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../vendor/phpunit/phpunit/PHPUnit/Autoload.php';
require_once __DIR__ . '/../../vendor/phpunit/phpunit/PHPUnit/Framework/Assert/Functions.php';
require_once __DIR__ . '/../../vendor/phpunit/dbunit/PHPUnit/Extensions/Database/TestCase.php';
//

define('BEHAT_ERROR_REPORTING', E_ERROR | E_WARNING | E_PARSE);

/**
 * Features context.
 */
class SharedContext extends RawMinkContext implements SnippetAcceptingContext
{
    var $originalWindowName = '';

//    /**
//     * Initializes context.
//     * Every scenario gets it's own context object.
//     *
//     * @param array $parameters context parameters (set them up through behat.yml)
//     */
//    public function __construct(array $parameters)
//    {
//        $this->parameters = $parameters;
//    }

    /**
     * @Then /^I should see the modal "([^"]*)"$/
     */
    public function iShouldSeeTheModal($title)
    {
        $this->getSession()->wait(20000, '(0 === jQuery.active && 0 === jQuery(\':animated\').length)');
        $this->assertElementContainsText('#modal-from-dom .modal-header h3', $title);
        assertTrue($this->getSession()->getPage()->find('css', '#modal-from-dom')->isVisible());
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
        $result = $this->getSession()->evaluateScript($script);
        return $result;
    }

    /**
     * Javascript method that checks for an element with a specific id
     * @param $idOfElement
     * @return string
     */
    public function javascriptCheckForIdElement($idOfElement)
    {
        $script = 'if ($("#' . $idOfElement . '").length) { return true; } else { return false; }';
        $result = $this->getSession()->evaluateScript($script);
        return $result;
    }

    /**
     * @Given /^I am logged in as "([^"]*)"$/
     */
    public function iAmLoggedInAs($userid)
    {
        $text = "Filter by:";
        $this->getSession()->visit($this->locatePath('/'));
        sleep(1);
        $this->getSession()->getPage()->fillField('email', $userid);
        $this->getSession()->getPage()->fillField('password', 'Password1');
        $this->getSession()->getPage()->pressButton('submit');
        $this->spin(function ($context) use ($text) {
            $this->assertPageContainsText($text);
            return true;
        }, intval(10));
        sleep(3);
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
        echo($randomString . '@opgtest.com');
        $this->getSession()->getPage()->fillField($emailAddress, $randomString . '@opgtest.com');
    }


    public function iClickOnTheElementWithXPath($xpath)
    {
        $session = $this->getSession(); // get the mink session
        $element = $session->getPage()->find('xpath', $session->getSelectorsHandler()->selectorToXpath('xpath', $xpath)); // runs the actual query and returns the element
        if (null === $element) {
            throw new \InvalidArgumentException(sprintf('Could not evaluate XPath: "%s"', $xpath));
        }
        $element->click();
    }

    /**
     * @Then /^count of "([^"]*)" instances of "(?P<text>[^"]*)" exists on page$/
     */
    public function thePersonsAreUnlinked($count, $area)
    {
        $str = $this->getSession()->getPage()->getContent();
        $count2 = substr_count($str, $area);
        echo $count2;
        assertEquals($count, $count2);
    }

    /**
     * @Given /^(?:|I )search for (?P<keywords>.*?)$/
     */
    public function iSearchFor($keywords)
    {
        $thekeywords = str_replace('"', "", $keywords);
        $this->getSession()->visit($this->locatePath('/#/search/' . $thekeywords));
        $this->getSession()->wait(3000);
    }

    /**
     * @When /^I search the phrase "([^"]*)"$/
     */
    public function iSearchThePhrase($keywords)
    {
        $thekeywords = str_replace(' ', ' AND ', $keywords);
        $this->getSession()->visit($this->locatePath('/#/search/' . $thekeywords));
        $this->getSession()->wait(3000);
    }


    /**
     * @When /^I double-click link "([^"]*)"$/
     */
    public function iDoubleClickCase($linkName)
    {
        $checkCase = $this->getSession()->getPage()->findLink($linkName);
        if ($checkCase !== null) {
            $checkCase->doubleClick();
            sleep(3);
        } else {
            throw new Exception('Cannot find link!');
        }

    }

    public function spin($lambda, $wait = 10)
    {
        for ($i = 0; $i < $wait; $i++) {
            try {
                if ($lambda($this)) {
                    return true;
                }
            } catch (Exception $e) {
                // do nothing
            }

            sleep(1);
        }
    }

    /**
     * @Then /^I should see user "([^"]*)" created$/
     */
    public function iShouldSeePersonCreated($email)
    {
        $pdo = new PDO('pgsql:user=opg;dbname=db_name;password=db_password;host=localhost');
        $sql = $pdo->query("SELECT email from persons ORDER BY id DESC LIMIT 1;");
        $sql2 = $sql->fetch(PDO::FETCH_OBJ);
        $sql3 = $sql2->email;
        assertEquals($sql3, $email);
    }


    /**
     * @Given /^"([^"]*)" is valid Luhn ID$/
     */
    public function isValidLuhnId($fieldId)
    {

        $number = substr($fieldId, 4, 0);
        $number2 = str_replace('-', '', $number);
        settype($number2, 'string');
        $sumTable = array(array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9), array(0, 2, 4, 6, 8, 1, 3, 5, 7, 9));
        $sum = 0;
        $flip = 0;
        for ($i = strlen($number2) - 1; $i >= 0; $i--) {
            $sum += $sumTable[$flip++ & 0x1][$number[$i]];
        }
        return $sum % 10 === 0;
    }


    /**
     * @Then /^I should not see event notification created by "([^"]*)"$/
     */
    public function iShouldNotSeeEventNotificationCreatedBy($username)
    {
        $displayTime = $this->getSession()->getPage()->find('xpath', '//section/ul/li[4]/time')->getText();
        if ($displayTime !== null) {
            $now = new DateTime();
            $currenttime = $now->format('H:i');
            $currentdate = $now->format('d M Y');
            $fullDateTime = ($currenttime . ' | ' . $currentdate);
            assertNotEquals($fullDateTime, $displayTime);
        } else {
            throwException('Cannot find event in timeline');
        }
    }

    /**
     * @When /^I check the "([^"]*)" radio button$/
     */
    public function iCheckTheRadioButton($radioLabel)
    {
        $radioButton = $this->getSession()->getPage()->findField($radioLabel);
        if (null === $radioButton) {
            throw new Exception("Cannot find radio button " . $radioLabel);
        }
        $value = $radioButton->getAttribute('value');
        $this->getSession()->getDriver()->click($radioButton->getXPath());
        sleep(1);
    }

    /**
     * @Given /^the buttons "([^"]*)" should be disabled$/
     */
    public function theButtonsShouldBeDisabled($buttons)
    {
        $params = explode(',', $buttons);
        foreach ($params as $param) {
            $this->getSession()->getPage()->clickLink($param);
            sleep(4);
            $check = $this->getSession()->getPage()->findById('ExitToWidgetHome');
            if (is_bool($check) === 1) {
                throw new Exception("The button " . $param . " is enabled when it should not be");
            }
        }
    }

    /**
     * @Given /^I fill in "([^"]*)" with tomorrows date$/
     */
    public function iFillInWithTomorrowsDate($tasktitle)
    {
        $NewDate3 = date('d/m//Y', strtotime("+1 days"));
        //   $NewDate4 = date('d F Y', strtotime($NewDate3));
        $this->getSession()->getPage()->fillField('dueDate0', $NewDate3);
    }

    /**
     * @Then /^I should see values "([^"]*)"$/
     */
    public function iShouldSeeValues($values)
    {
        $params = explode(',', $values);
        foreach ($params as $param) {
            $this->assertSession()->responseContains($param);
        }
    }

    /**
     * @Given /^I switch to iframe "([^"]*)"$/
     */
    public function iSwitchToIframe($iframeName)
    {
        $this->getSession()->switchToIFrame($iframeName);

    }

    /**
     * Checks that a select dropdown has options
     *
     * @param $value
     * @return string
     */
    public function javascriptCheckThatASelectDropDownHasOptions($value)
    {
        $script = 'if ($("#' . $value . ' option").length > 1) { return true; } else { return false; }';
        $result = $this->getSession()->evaluateScript($script);
        return $result;
    }

    /**
     * @Given /^I want to load test api endpoint "([^"]*)" with "([^"]*)" concurrent users with maximum of "([^"]*)" parallel requests for duration of  "([^"]*)" seconds/
     */
    public function iWantToLoadTestApiEndpointWithConcurrentUsersWithMaximumOfRequestsInParallel($apiEndpoint, $numberUsers, $numberRequests, $testDuration)
    {
        shell_exec("ab -H \"X-USER-ID:admin@example.com\" -c " . $numberUsers . "1 -g gnuplot.tsv -k -n " . $numberRequests . " 1 -r -t " . $testDuration . " -v 4 " . $apiEndpoint);
        $testWait = ($testDuration + 10);
        sleep($testWait);
    }

    /**
     * @Given /^I set system date to today plus "([^"]*)" working days$/
     */
    public function iSetSystemDateToTodayPlusDays($days)
    {
        $t = date('Y-m-d');
        $initialDate = DateTime::createFromFormat('Y-m-d', $t);
        $dayCounter = 1;
        $currentDay = $initialDate->getTimestamp();
        $currentYear = $initialDate->format('Y');
        $bankHolsThisYear = calculateBankHolidays($currentYear);
        while ($dayCounter <= $days) {
            $date = date('Y-m-d', $currentDay);
            if (in_array($date, $bankHolsThisYear)) {
                $currentDay = strtotime($date . ' +2 days');
            } else {
                $currentDay = strtotime($date . ' +1 day');
            }
        }
        $date = date('Y-m-d', $currentDay);
        $weekday = date('N', $currentDay);
        if ($weekday < 6) {
            $dayCounter++;
        }
        $final = date('Y-m-d', $currentDay);
        echo $final;
        exec("sudo /bin/date -s " . $final);
    }

    /**
     * @Given /^I reset date to real current date$/
     */
    public function iResetDateToRealCurrentDate()
    {
        exec("sudo ntpdate ntp.ubuntu.com");

    }

    /**
     * @Given /^bandwidth speed is set to "([^"]*)" Kb$/
     */
    public function bandwidthSpeedIsSetToK($bandwidth)
    {
        exec("sudo trickled -d " . $bandwidth . " -u " . $bandwidth . " -v");
        sleep(5);
    }
}
