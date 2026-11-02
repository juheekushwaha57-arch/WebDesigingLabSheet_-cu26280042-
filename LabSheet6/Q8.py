import mysql.connector

conn = mysql.connector.connect(
    host="localhost",
    user="root",
    password="",
    database="python_web_db"
)

cursor = conn.cursor()

user_id = 1
new_name = "Rahul Sharma"
new_email = "rahul123@gmail.com"

sql = """
UPDATE users
SET name = %s, email = %s
WHERE id = %s
"""

cursor.execute(sql, (new_name, new_email, user_id))

conn.commit()

print("User Profile Updated Successfully!")

cursor.close()
conn.close()
