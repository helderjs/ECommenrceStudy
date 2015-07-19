@web
Feature: Products list
  In order to describe/test web part of the feature suite
  As features tester
  I need to be able to use add and manage products on the cart page

  Scenario: Add item to cart
    When I go to "/"
    When I follow "Shampoo"
    When I follow "Adicionar ao Carrinho"
    Then I should see "Shampoo"
    And I should see "1"
    And I should see "9.99"