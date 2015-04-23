Feature: I would like to edit flowers

  Scenario Outline: Insert records
    Given I am on homepage
    And I follow "Login"
    And I fill in "Username" with "admin"
    And I fill in "Password" with "loremipsum"
    And I press "Login"
    And I go to "/admin/flowers/"
    Then I should not see "<flowers>"
    And I follow "Create a new entry"
    Then I should see "Fish creation"
    When I fill in "Name" with "<flowers>"
    And I fill in "Price" with "<price>"
    And I press "Create"
    Then I should see "<flowers>"
    And I should see "<price>"

  Examples:
    | flowers        | price |
    | rose           |  10   |
    | tulip          |  9    |
    | crocus         |  12   |



  Scenario Outline: Edit records
    Given I am on homepage
    And I follow "Login"
    And I fill in "Username" with "admin"
    And I fill in "Password" with "loremipsum"
    And I press "Login"
    And I go to "/admin/flowers/"
    Then I should not see "<new-flowers>"
    When I follow "<old-flowers>"
    Then I should see "<old-flowers>"
    When I follow "Edit"
    And I fill in "Name" with "<new-flowers>"
    And I fill in "Price" with "<new-price>"
    And I press "Update"
    And I follow "Back to the list"
    Then I should see "<new-flowers>"
    And I should see "<new-price>"
    And I should not see "<old-flowers>"

  Examples:
    | old-flowers     | new-flowers         | new-price  |
    | crocus          | daisy               |     6      |
    | tulip           | sage                |    13      |


  Scenario Outline: Delete records
    Given I am on homepage
    And I follow "Login"
    And I fill in "Username" with "admin"
    And I fill in "Password" with "loremipsum"
    And I press "Login"
    And I go to "/admin/flowers/"
    Then I should see "<flowers>"
    When I follow "<flowers>"
    Then I should see "<flowers>"
    When I press "Delete"
    Then I should not see "<flowers>"

  Examples:
    | flowers       |
    | rose          |
    | daisy         |
    | sage          |

