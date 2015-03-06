Feature: The Gherkin

  @phantomjs @api
  Scenario: The Gherkin Headless UI
    Given I am on "/"
    And I fill in "Behat" for "s"
    And I press "Search"
    Then I should see "Behat"
    And count of "22" instances of "Behat" exists on page

  @phantomjs
  Scenario: Login/Logout
    Given I am on "/wp-admin"
    And I am logged in as "test" with password "test"
    Then I should see "Howdy"
    When I follow "Log Out"
    Then I should see "You are now logged out"

  @api
  Scenario: The Gherkin API test
    Given I send a GET request to "http://jaffamonkey.com/wp-json/posts/11123"
    Then the response status code should be 200
    And response should contain "publish"

  @phantomjs
  Scenario: The Gherkin Browser UI
    Given I am on "/"
    And I fill in "Behat" for "s"
    And I press "Search"
    Then I should see "Behat"

  @phantomjs
  Scenario: The Gherkin Form Filling Eg2
    Given I am on "/form-test"
    When I fill form with:
      | title     | some text |
      | checkbox1 | YES       |
      | checkbox2 | YES       |
      | checkbox3 | YES       |
      | select    | Option 3  |
    Then I should see form with:
      | title     | some text |
      | checkbox1 | YES       |
      | checkbox2 | YES       |
      | checkbox3 | YES       |
      | select    | Option 3  |
    And I press "Save"
    And I should see "Error"