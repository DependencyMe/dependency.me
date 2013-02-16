Feature: Registered user can synchronize his repositories
  As registered user
  I should be able to synchronize my repositories from Github
  In order to start to get information about my public repositories

  Background:
    Given I'm the registerd user "Jeff"
    And "Jeff" has the following repositories on Github:
      | name        | branches                      |
      | repo1       | master                        |



  Scenario: synchronize my repositories from Github
    When i want to synchronise my Github repositories
    Then I should be informed that "3" repositories was found on Github



  Scenario Outline: expose my repository
    When I want to change the visibility of my repository "<repository>" to "<visible>"
    Then the repository "<repository>" is now "<visible>" to visitors

    Examples:
      | repository      | visible   |
      | repo1           | public    |
      | repo1           | private   |