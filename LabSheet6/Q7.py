#!C:/Python312/python.exe

import cgi
import mysql.connector
import html

print("Content-Type: text/html\n")

form = cgi.FieldStorage()

name = form.getfirst("name", "")
email = form.getfirst("email", "")

if name and email:

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

        print("<h2>User Inserted Successfully!</h2>")

        cursor.close()
        conn.close()

    except mysql.connector.Error:
        print("<h2>Database Error!</h2>")

else:

    print("""
    <form method="POST">
        Name: <input type="text" name="name" required><br><br>
        Email: <input type="email" name="email" required><br><br>
        <input type="submit" value="Submit">
    </form>
    """)
