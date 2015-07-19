@web
Feature: Checkout
  In order to describe/test web part of the feature suite
  As features tester
  I need to be able to use make a order

  Scenario: Making a order
    Given I go to "/"
    When I follow "Shampoo"
    When I follow "Adicionar ao Carrinho"
    When I follow "Comprar"
    When I am on "/login"
    When I fill in the following:
      | username | joao   |
      | password | 123456 |
    And I press "login"
    Then I should be on "/order/checkout"
