Feature: Greeting
In order to see a greeting message
As a website user
I need to be able to view the homepage

  Scenario: Greeting on the home page
    Given I am on "/hello"
    Then I should see "Hello Siddu!"
