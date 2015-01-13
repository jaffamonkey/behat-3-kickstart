Feature: The Gherkin

  @phantomjs @api
  Scenario: The Gherkin Headless UI
    Given I am on "/"
    And I fill in "Behat" for "s"
    And I press "Search"
    Then I should see "Behat"
    And count of "27" instances of "Behat" exists on page

  @api
  Scenario: The Gherkin API test
    Given I request "http://jaffamonkey.com/wp-json/posts/11123"
    Then the response should be JSON
    And the response status code should be 200
    And the response has a "status" property
    And the "status" property equals "publish"

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
    Then I should see "Error"


  @javascript @phantomjs
  Scenario: The Gherkin Form Filling Eg2
    Given I am on "/form-test/"
    When I fill form with:
      | text				| some text			|
      | checkbox1			| YES					|
      | checkbox2			| YES					|
      | checkbox3		| YES					|
      | select			| Option 3				|
    Then the "text" field should contain "some text"
    And the "checkbox1" checkbox should be checked
    And the "checkbox2" checkbox should be checked
    And the "checkbox3" checkbox should be checked
    And the "select" field should contain "3"

