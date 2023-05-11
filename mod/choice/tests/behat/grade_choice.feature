@mod @mod_choice
Feature: Add choice activity with grading and test student response and removing the grading feature
  In order to ask questions as a choice of multiple responses and grade the student's answers
  As a teacher
  I need to add a choice activity with a valid grademax value and valid fraction values per option to course

  Background:
    Given the following "users" exist:
      | username | firstname | lastname | email                |
      | teacher1 | Teacher   | 1        | teacher1@example.com |
      | student1 | Student   | 1        | student1@example.com |
    And the following "courses" exist:
      | fullname | shortname | category |
      | Course 1 | C1        | 0        |
    And the following "course enrolments" exist:
      | user     | course | role           |
      | teacher1 | C1     | editingteacher |
      | student1 | C1     | student        |
    And the following "activities" exist:
      | activity | name        | intro              | course | idnumber | option             | grademax | fraction | section |
      | choice   | Choice name | Choice Description | C1     | choice1  | Option 1, Option 2 | 100      | 5        | 1       |

  @javascript
  Scenario: Check if grade item was created
    When I log in as "teacher1"
    And I am on "Course 1" course homepage
    And I navigate to "View > Grader report" in the course gradebook
    Then I should see "Choice name"

  @javascript
  Scenario: Complete the activity as a student and check student's grade value as a teacher
    When I log in as "student1"
    And I am on "Course 1" course homepage
    And I choose "Option 1" from "Choice name" choice activity
    Then I should see "Your selection: Option 1"
    And I should see "Your choice has been saved"
    When I log in as "teacher1"
    And I am on "Course 1" course homepage
    And I navigate to "View > User report" in the course gradebook
    And I set the field "Select all or one user" to "Student 1"
    Then the following should exist in the "user-grade" table:
      | Grade item          | Grade | Range | Percentage  |
      | Choice name         | 5.00  | 0–100 | 5.00 %      |

  @javascript
  Scenario: If value 0 is entered for grade max in choice instance settings the grading item will be removed
    When I am on the "Choice name" "choice activity editing" page logged in as teacher1
    And I expand all fieldsets
    And I set the following fields to these values:
      | Maximum grade (points)          | 0 |
    And I press "Save and return to course"
    And I navigate to "View > Grader report" in the course gradebook
    Then I should not see "Choice name" in the "//table[contains(@class, 'gradereport-grader-table')]" "xpath_element"

