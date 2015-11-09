Feature: API testing
  As a user,
  I can test the API,
  so that tests are faster but still relevant

  @api @guzzle
  Scenario: The Gherkin API
    When I called "JaffamonkeySite"
    And I get a successful response
    Then the response contains the following values:
      | title  | Some basic CLI web performance tools |
      | status | ok                              |