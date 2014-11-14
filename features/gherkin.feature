Feature: The Gherkin

  @phantomjs
  Scenario: The Gherkin Headless UI
    Given I am on "/"
    And I fill in "Behat" for "s"
    And I press "Search"
    Then count of "27" instances of "Behat" exists on page

  @api
  Scenario: The Gherkin API test
    Given I GET request "/api/get_recent_posts"
    Then the response status is 200
    And the status property equals "ok"

  @javascript @phantomjs
  Scenario: The Gherkin Browser UI
    Given I am on "/"
    And I fill in "Behat" for "s"
    And I press "Search"
    Then count of "27" instances of "Behat" exists on page

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
    And I wait for page to update
    Then I should see "OOOPS!"