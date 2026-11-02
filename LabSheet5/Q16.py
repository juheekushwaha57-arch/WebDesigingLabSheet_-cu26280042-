#!C:/Python/python.exe

import json
import mysql.connector

print("Content-Type: application/json")
print()

try:

    conn = mysql.connector.connect(
        host="localhost",
        user="root",
        password="",
        database="python_web_db"
    )

    cursor = conn.cursor(dictionary=True)

    cursor.execute("SELECT * FROM users")

    records = cursor.fetchall()

    print(json.dumps(records, default=str))

    cursor.close()
    conn.close()

except mysql.connector.Error:
    print(json.dumps({
        "error": "Database connection failed"
    }))
