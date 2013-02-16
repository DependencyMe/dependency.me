Feature: Registered user can log in with his Github account
  As registered user
  I should be able to login with my Github account
  In order to have a easy way to synchronize my repositories

  Background:
    Given the owner "Jeff" is registered with:
      | field                   |   value        |
      | permanentAccessToken    |   abcdef       |
    And the Github User "Jeff" allows the application to access to his public informations


  Scenario: login with my Github account
    When I want to login with my GithubAccount
    Then I should be access to my profile
    And I should be able to log out