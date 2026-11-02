import mysql.connector

conn = mysql.connector.connect(
    host="localhost",
    user="root",
    password="",
    database="python_web_db"
)

cursor = conn.cursor()

users = [
    ("Rahul", "rahul@gmail.com"),
    ("Amit", "amit@gmail.com"),
    ("Priya", "priya@gmail.com")
]

sql = "INSERT INTO users (name, email) VALUES (%s, %s)"

cursor.executemany(sql, users)

conn.commit()

print(cursor.rowcount, "Records Inserted Successfully!")

cursor.close()
conn.close()
