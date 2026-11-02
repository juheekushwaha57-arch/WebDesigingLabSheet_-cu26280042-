import mysql.connector

try:
    conn = mysql.connector.connect(
        host="localhost",
        user="root",
        password=""
    )

    cursor = conn.cursor()

    cursor.execute("SELECT VERSION()")

    version = cursor.fetchone()

    print("MySQL Server Version:", version[0])

    cursor.close()
    conn.close()

except mysql.connector.Error as e:
    print("Database Error:", e)
