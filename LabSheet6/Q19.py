import mysql.connector
import re

name = input("Enter Name: ").strip()

email = input("Enter Email: ").strip()

if not re.fullmatch(r"[A-Za-z ]{2,100}", name):

    print("Invalid Name!")

elif not re.fullmatch(
    r"[^@\s]+@[^@\s]+\.[^@\s]+",
    email
):

    print("Invalid Email!")

else:

    try:

        conn = mysql.connector.connect(
            host="localhost",
            user="root",
            password="",
            database="python_web_db"
        )

        cursor = conn.cursor()

        sql = "INSERT INTO users (name, email) VALUES (%s, %s)"

        cursor.execute(sql, (name, email))

        conn.commit()

        print("User Added Successfully!")

        cursor.close()
        conn.close()

    except mysql.connector.Error as e:

        print("Database Error:", e)
