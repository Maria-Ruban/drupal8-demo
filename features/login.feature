Feature: Greeting
  In order to check if the user is able to login
  As an anonymous user
  I want to be able to login with the application with valid credentials

  Scenario: Login from the login screen
    Given I am on "/user"
    When I fill "username" with "admin"
    When I fill "password" with "drupal8"
    When I press "Log in"
    Then I should see "admin"
