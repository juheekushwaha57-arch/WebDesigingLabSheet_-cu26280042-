import mysql.connector
import re

def validate_email(email):
    pattern = r'^[\w.-]+@[\w.-]+\.[A-Za-z]{2,}$'
    return re.match(pattern, email) is not None

name = input("Enter Name: ").strip()

email = input("Enter Email: ").strip()

age = input("Enter Age: ").strip()

if not name:
    print("Name cannot be empty!")

elif not validate_email(email):
    print("Invalid Email Address!")

elif not age.isdigit() or not 1 <= int(age) <= 120:
    print("Invalid Age!")

else:

    try:

        conn = mysql.connector.connect(
            host="localhost",
            user="root",
            password="",
            database="python_web_db"
        )

        cursor = conn.cursor()

        sql = """
        INSERT INTO users (name, email, age)
        VALUES (%s, %s, %s)
        """

        cursor.execute(sql, (name, email, int(age)))

        conn.commit()

        print("User Added Successfully!")

        cursor.close()
        conn.close()

    except mysql.connector.Error as e:
        print("Database Error:", e)
