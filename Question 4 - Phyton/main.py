# Function that identifies the operation type and count the amount of it
def amount_on_password(password, operation_type):
    if operation_type == 'LEN':
        return len(password)
    elif operation_type == 'LETTERS':
        return sum(letters.isalpha() for letters in password)
    elif operation_type == 'NUMBERS':
        return sum(numbers.isnumeric() for numbers in password)
    elif operation_type == 'SPECIALS':
        return sum(not (specials.isalnum()) for specials in password)


# Function that identifies the operator and compares the required amount with the amount on the password
def operation_validator(operator, amount_intended, amount):
    if operator == '<':
        return amount < amount_intended
    elif operator == '>':
        return amount > amount_intended
    elif operator == '=':
        return amount == amount_intended


# Function that prints whether the password is valid or not according to each requirement
def password_validator(password, requirement):
    requirement_number = 0
    for operation_type, operator, amount_intended in requirement:
        requirement_number += 1
        amount = amount_on_password(password, operation_type)
        if amount is None:
            print(f"Please enter a valid operation type on the {requirement_number}º requirement.")
        else:
            operation = operation_validator(operator, amount_intended, amount)
            if operation is None:
                print(f"Please enter a valid operator on the {requirement_number}º requirement.")
            elif operation:
                print(f"Your password complies with the {requirement_number}º requirement.")
            else:
                print(f"Your password does not complies with the {requirement_number}º requirement.")


# Variable to set the password requirements
requirements = [('LEN', '=', 8), ('SPECIALS', '>', 1), ('NUMBERS', '<', 10)]
# Calls the password validator function passing the password and the requirements as parameters
password_validator('123456!!', requirements)
