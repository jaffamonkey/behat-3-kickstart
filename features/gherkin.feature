Feature: UI testing
  As a user,
  I can specify what browser client to use for tests using tags,
  so I am not constricted to one.

  @phantomjs @javascript
  Scenario: The Gherkin Headless UI
    Given I am on "/"
    And I fill in "Behat" for "s"
    And I press "Search"
    Then I should see "Behat"
    And count of "24" instances of "Behat" exists on page

  @phantomjs @javascript
  Scenario: The Gherkin Browser UI
    Given I am on "/"
    And I fill in "Behat" for "s"
    And I press "Search"
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
    And I should see "Oops! That page can’t be found"


  @phantomjs @javascript
  Scenario: I can publish a new blog post
#    Given I am logged in as "" with password ""
#    When I am on "/wp-admin/post-new.php"
#    And I fill in "post_title" with "A blog post"
#    And I fill in "content" with "The post content"
#    And I press "Publish"
    Given I am on the homepage
    And I fill in "s" with "A blog post"
    And I press "Search"
    Then I should see "A blog post"
    When I follow "A blog post"
    Then the current post display date is today plus "0" working days
    