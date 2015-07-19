@web
Feature: Products list
  In order to describe/test web part of the feature suite
  As features tester
  I need to be able to use list products on the homepage

  Scenario: Accessing Homepage controller
    When I go to "/"
    Then I should see "Calça Jeans"
    And I should see "Shampoo"

  Scenario: Clicking on links
    Given I am on "/"
    When I follow "Shampoo"
    Then I should see "Shampoo"
    And I should see "Shampoo anti-caspa para cabelos secos."
    And I should see "9.99"
    And I should see "Categorias: Beleza"