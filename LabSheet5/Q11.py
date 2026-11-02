import mysql.connector

conn = mysql.connector.connect(
    host="localhost",
    user="root",
    password="",
    database="python_web_db"
)

cursor = conn.cursor()

search_name = "Rahul"

sql = "SELECT * FROM users WHERE name = %s"

cursor.execute(sql, (search_name,))

records = cursor.fetchall()

for row in records:
    print(row)

cursor.close()
conn.close()
