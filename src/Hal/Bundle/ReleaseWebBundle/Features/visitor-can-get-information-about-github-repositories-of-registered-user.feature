@repository
Feature: Get information about Github repositories of any user
  As visitor
  I should be able to list repositories of any registered user
  In order to know repositories created and managed by ths user on Github

  Background:
    Given I'm visitor
    And the owner "Jeff" is registerd
    And "Jeff" has the following repositories:
      | name             | branches                      | visible    |
      | Jeff/repo1       | master                        | public     |
      | Jeff/repo2       | master                        | private    |
      | Jeff/repo3       | master,branche1,branche2      | public     |

  Scenario: get the list of public repositories of any user
    When I want to obtain the list of the repositories of "Jeff"
    Then I should be informed that the following repositories exist:
      | name             |
      | Jeff/repo1       |
      | Jeff/repo3       |

  Scenario: get the list of public repositories only of any user
    When I want to obtain the list of the repositories of "Jeff"
    Then I should not be informed that the following repositories exist:
      | name             |
      | Jeff/repo2       |

  Scenario: get the list of branches used by a repository
    When I want to obtain the list of branches of the repository "Jeff/repo3"
    Then I should be informed that there are "3" branches:
      | name      |
      | master    |
      | branche1  |
      | branche2  |