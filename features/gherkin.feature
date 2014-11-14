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

  @javascript
  Scenario: The Gherkin Form Filling
    Given I am on "/form-test"
    When I select "MOption 1" from "Multiple Select"
    And I additionally select "MOption 3" from "Multiple Select"