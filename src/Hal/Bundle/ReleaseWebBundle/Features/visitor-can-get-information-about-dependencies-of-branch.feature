@branch
Feature: Get information about dependencies of branch
  As visitor
  I should be able to get the list of dependencies of any branche
  In order to know packages (and their state) used by a branche

  Background:
    Given I'm visitor
    And the owner "Jeff" is registerd
    And "Jeff" has the following repositories:
      | name             | branches        | public    |
      | Jeff/repo1       | master          | yes       |

  Scenario Outline: get information about state of branche's dependencies
    Given the branche "master" of "Jeff/repo1" requires the package "<reqPackage>" with the version "<reqVersion>"
    And the package "<reqPackage>" has for current version "<currentVersion>"
    When I want to know the state of the dependency "<reqPackage>" of branche "master" of "Jeff/repo1"
    Then I should be informed that the branche depends to "<reqPackage>"
    And I should be informed that the dependency for "<reqPackage>" is "<state>"

    Examples:
      | reqPackage        | reqVersion    | currentVersion | status        |
      | symfony/console1   | =1.2          | 1.2            | latest       |
      | symfony/console2   | >1.2          | 2              | latest       |
      | symfony/console3   | =1.2          | 2              | outofdate    |
      | symfony/console4   | =1.2          | 1.3            | recent       |
    