Feature: Customer API

    Background:
        Given I have migrated the database

    Scenario: Get a list of customers
        Given there are 5 customers in the database
        When I send a GET request to "/customers"
        Then the response status code should be 200
        And the response should have a JSON structure like:
      """
      {
        "customers": [
          {
            "id": 1,
            "firstname": "John",
            "lastname": "Doe",
            "date_of_birth": "1990-01-01",
            "phone_number": 123456789,
            "email": "john@example.com",
            "bank_account_number": "1234567890",
            "created_at": "2023-01-01 00:00:00",
            "updated_at": "2023-01-01 00:00:00"
          },
          ...
        ]
      }
      """
        And the response should have 5 customers

    Scenario: Create a customer
        When I send a POST request to "/customers" with the following data:
      """
      {
        "firstname": "Jane",
        "lastname": "Smith",
        "date_of_birth": "1995-01-01",
        "phone_number": 987654321,
        "email": "jane@example.com",
        "bank_account_number": "0987654321"
      }
      """
        Then the response status code should be 200
        And the response should have a JSON structure like:
      """
      {
        "customer": {
          "id": 6,
          "firstname": "Jane",
          "lastname": "Smith",
          "date_of_birth": "1995-01-01",
          "phone_number": 987654321,
          "email": "jane@example.com",
          "bank_account_number": "0987654321",
          "created_at": "2023-01-01 00:00:00",
          "updated_at": "2023-01-01 00:00:00"
        }
      }
      """
        And the "customers" table should have 6 records

    Scenario: Show a customer
        Given there is a customer with ID 1 in the database
        When I send a GET request to "/customers/1"
        Then the response status code should be 200
        And the response should have a JSON structure like:
      """
      {
        "customer": {
          "id": 1,
          "firstname": "John",
          "lastname": "Doe",
          "date_of_birth": "1990-01-01",
          "phone_number": 123456789,
          "email": "john@example.com",
          "bank_account_number": "1234567890",
          "created_at": "2023-01-01 00:00:00",
          "updated_at": "2023-01-01 00:00:00"
        }
      }
      """

    Scenario: Update a customer
        Given there is a customer with ID 1 in the database
        When I send a PUT request to "/customers/1" with the following data:
      """
      {
        "firstname": "Updated",
        "lastname": "Name",
        "date_of_birth": "1990-01-01",
        "phone_number": 987654321,
        "email": "updated@example.com",
        "bank_account_number": "0987654321"
      }
      """
        Then the response status code should be 200
        And the response should have a JSON structure like:
      """
      {
        "message": "Customer updated successfully."
      }
      """
        And the "customers" table should have the updated customer data for ID 1

    Scenario: Delete a customer
        Given there is a customer with ID 1 in the database
        When I send a DELETE request to "/customers/1"
        Then the response status code should be 200
        And the response should have a JSON structure like:
      """
      {
        "message": "Customer deleted successfully."
      }
      """
        And the "customers" table should not have any record with ID 1
