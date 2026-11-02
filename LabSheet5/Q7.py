#!C:/Python/python.exe

import cgi
import mysql.connector
import html

print("Content-Type: text/html\n")

form = cgi.FieldStorage()

name = form.getfirst("name", "")
email = form.getfirst("email", "")
age = form.getfirst("age", "")

if name and email and age.isdigit():

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

        print("<h2>User Inserted Successfully!</h2>")

        cursor.close()
        conn.close()

    except mysql.connector.Error:
        print("<h2>Database Error!</h2>")

else:
    print("<h2>Please Enter Valid Details!</h2>")
