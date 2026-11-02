import mysql.connector
import re

def validate_and_insert():
    # 1. Take User Input
    print("--- User Registration ---")
    name = input("Enter Name: ").strip()
    email = input("Enter Email: ").strip()
    age_input = input("Enter Age: ").strip()

    # 2. Input Validation
    if not name:
        print("Validation Error: Name cannot be empty.")
        return
        
    # Email Validation using Regular Expression
    email_pattern = r"^[\w\.-]+@[\w\.-]+\.\w+$"
    if not re.match(email_pattern, email):
        print("Validation Error: Invalid email format.")
        return

    # Age Validation
    if not age_input.isdigit():
        print("Validation Error: Age must be a positive number.")
        return
    age = int(age_input)

    # 3. Database Connection and Parameterized Insertion
    connection = None
    try:
        connection = mysql.connector.connect(
            host='localhost',
            database='college_db',  # Ensure this database exists
            user='root',
            password=''
        )
        
        if connection.is_connected():
            cursor = connection.cursor()
            
            # Parameterized Query (using %s placeholders prevents SQL injection)
            sql_query = "INSERT INTO users (name, email, age) VALUES (%s, %s, %s)"
            user_data = (name, email, age)
            
            cursor.execute(sql_query, user_data)
            connection.commit()  # Save changes to database
            
            print(f"Success: User '{name}' successfully inserted with parameterized query!")

    except mysql.connector.Error as error:
        print(f"Database Error: {error}")
        
    finally:
        if connection and connection.is_connected():
            cursor.close()
            connection.close()

if __name__ == "__main__":
    validate_and_insert()
