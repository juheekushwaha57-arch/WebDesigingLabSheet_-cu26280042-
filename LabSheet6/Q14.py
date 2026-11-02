import csv
import mysql.connector

conn = mysql.connector.connect(
    host="localhost",
    user="root",
    password="",
    database="python_web_db"
)

cursor = conn.cursor()

with open("users.csv", "r") as file:

    reader = csv.DictReader(file)

    users = [
        (row["name"], row["email"])
        for row in reader
    ]

sql = "INSERT INTO users (name, email) VALUES (%s, %s)"

cursor.executemany(sql, users)

conn.commit()

print("CSV Data Inserted Successfully!")

cursor.close()
conn.close()
