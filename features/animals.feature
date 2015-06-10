Feature: I would like to edit animals

  Scenario Outline: Insert records
    Given I am on homepage
    And I follow "Login"
    And I fill in "Username" with "admin"
    And I fill in "Password" with "loremipsum"
    And I press "Login"
    And I go to "/admin/animals/"
    Then I should not see "<animals>"
    And I follow "Create a new entry"
    Then I should see "animals creation"
    When I fill in "Name" with "<animals>"
    And I fill in "Weight" with "<weight>"
    And I press "Create"
    Then I should see "<animals>"
    And I should see "<weight>"

  Examples:
    | animals      | weight |
    | crow         | 270    |
    | horse        | 235    |
    



  Scenario Outline: Edit records
    Given I am on homepage
    And I follow "Login"
    And I fill in "Username" with "admin"
    And I fill in "Password" with "loremipsum"
    And I press "Login"
    And I go to "/admin/animals/"
    Then I should not see "<new-animals>"
    When I follow "<old-animals>"
    Then I should see "<old-animals>"
    When I follow "Edit"
    And I fill in "Name" with "<new-animals>"
    And I fill in "Weight" with "<new-weight>"
    And I press "Update"
    And I follow "Back to the list"
    Then I should see "<new-animals>"
    And I should see "<new-weight>"
    And I should not see "<old-animals>"

  Examples:
    | old-animals    | new-animals           | new-weight    |
    | crow           | panda                 | 135           |
    | horse          | elephant              | 800           |


  Scenario Outline: Delete records
    Given I am on homepage
    And I follow "Login"
    And I fill in "Username" with "admin"
    And I fill in "Password" with "loremipsum"
    And I press "Login"
    And I go to "/admin/animals/"
    Then I should see "<animals>"
    When I follow "<animals>"
    Then I should see "<animals>"
    When I press "Delete"
    Then I should not see "<animals>"

  Examples:
    | animals     |
    | panda       |
    | elephant    |

