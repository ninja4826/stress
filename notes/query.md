q
  Model
    global 'all' field, only 'k' operator
    field
      operator
        value

# Operators
- k
  - keyword search
  - uses an SQL 'LIKE' statement, placing '%' on front and end
- =
  - exact value
  - finds exactly that value
- !
  - requires other operators to be present
- possible operators
  - ">"
  - "<"
  - ">="
  - "<="