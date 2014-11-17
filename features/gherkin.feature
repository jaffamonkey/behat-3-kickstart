Feature: The Gherkin

  @phantomjs
  Scenario: The Gherkin Headless UI
    Given I am on "/"
    And I fill in "Behat" for "s"
    And I press "Search"
    Then I should see "Behat"
    And count of "27" instances of "Behat" exists on page

  @api
  Scenario: The Gherkin API test
    Given I send a GET request to "/wp-json/posts"
    And the JSON node "[0].status" should exist
    Then the response status code should be 200
    Then the response should be in JSON
    And the JSON node "[0].status" should contain "publish"
    And the response should expire in the future

  @javascript @phantomjs
  Scenario: The Gherkin Browser UI
    Given I am on "/"
    And I fill in "Behat" for "s"
    And I press "Search"
    Then I should see "Behat"

  @javascript @phantomjs
  Scenario: The Gherkin Form Filling
    Given I am on "/form-test/"
    And I fill in "text" with "some text"
    And I check "checkbox"
    And I select "Option 3" from "select"
    And I check the "radio2" radio button
    And I fill in "textarea" with "some text in text area"
    And I check "checkbox1"
    And I check "checkbox2"
    And I check "checkbox3"
    When I press "Save"
    Then I should see "OOOPS!"