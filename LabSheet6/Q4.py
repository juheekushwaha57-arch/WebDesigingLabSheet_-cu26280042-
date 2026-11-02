
import mysql.connector

conn = mysql.connector.connect(
    host="localhost",
    user="root",
    password=""
)

cursor = conn.cursor()

cursor.execute(
    "CREATE DATABASE IF NOT EXISTS python_web_db"
)

cursor.execute("USE python_web_db")

cursor.execute("""
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100)
)
""")

print("Database and Users Table Created Successfully!")

conn.commit()

cursor.close()
conn.close()