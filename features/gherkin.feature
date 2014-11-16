Feature: The Gherkin

  @phantomjs
  Scenario: The Gherkin Headless UI
    Given I am on "/"
    And I fill in "Behat" for "s"
    And I press "Search"
    Then count of "27" instances of "Behat" exists on page

  @api
  Scenario: The Gherkin API test
    Given I send a GET request to "/wp-json/posts"
    Then the response status code should be 200
    And the JSON node "status" should exist
    And the JSON node "title" should contain "Some basic CLI web performance tools"
    Then the JSON node "post" should have 4 elements

  @javascript @phantomjs
  Scenario: The Gherkin Browser UI
    Given I am on "/"
    And I fill in "Behat" for "s"
    And I press "Search"

  @javascript @phantomjs
  Scenario: The Gherkin Form Filling
    Given I am on "/form-test/"
    And I fill in "text" with "some text"
    And I check "checkbox"
    And I select "Option 3" from "select"
    And I fill in "textarea" with "some text in text area"
    And I check "checkbox1"
    And I check "checkbox2"
    And I check "checkbox3"
    When I press "Save"
    Then I should see "OOOPS!"