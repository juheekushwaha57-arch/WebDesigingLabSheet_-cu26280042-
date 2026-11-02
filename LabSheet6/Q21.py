import mysql.connector

conn = mysql.connector.connect(
    host="localhost",
    user="root",
    password="",
    database="python_web_db"
)

cursor = conn.cursor()

# Total users

cursor.execute("SELECT COUNT(*) FROM users")

total = cursor.fetchone()[0]

# Average user ID

cursor.execute("SELECT AVG(id) FROM users")

average = cursor.fetchone()[0]

# Display report

print("ADMIN DASHBOARD REPORT")

print("----------------------")

print("Total Users:", total)

print("Average User ID:", average)

cursor.close()
conn.close()
