Feature: UI testing
  As a user,
  I can specify what browser client to use for tests using tags,
  so I am not constricted to one.

  @phantomjs @javascript
  Scenario: The Gherkin Headless UI
    Given I am on "/?s=Behat"
    Then I should see "Behat"
    And count of "16" instances of "Behat" exists on page

  @phantomjs @javascript
  Scenario: The Gherkin Browser UI
    Given I am on "/?s=Behat"
    Then I should see "Behat"

  @phantomjs @javascript
  Scenario: I can publish a new blog post
    Given I am on "/?s=Behat"
    Then I should see "Behat 3 Skeleton Repo"
