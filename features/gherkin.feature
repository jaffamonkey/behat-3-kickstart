Feature: UI testing
  As a user,
  I can specify what browser client to use for tests using tags,
  so I am not constricted to one.

  @phantomjs @javascript
  Scenario: The Gherkin Headless UI
    Given I am on "/"
    And I fill in "Behat" for "s"
    And I am on "/?s=Behat"
    Then I should see "Behat"
    And count of "16" instances of "Behat" exists on page

  @phantomjs @javascript
  Scenario: The Gherkin Browser UI
    Given I am on "/"
    And I fill in "Behat" for "s"
    And I am on "/?s=Behat"
    Then I should see "Behat"

  @phantomjs @javascript
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
    Then I should see "Your request was not found"
    And I should see "Perhaps try a search?"


  @phantomjs @javascript
  Scenario: I can publish a new blog post
    Given I am on the homepage
    And I fill in "s" with "Behat"
    And I am on "/?s=Behat"
    Then I should see "Behat 3 Skeleton Repo"
    
