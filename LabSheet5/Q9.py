import mysql.connector

try:

    conn = mysql.connector.connect(
        host="localhost",
        user="root",
        password="",
        database="python_web_db"
    )

    cursor = conn.cursor()

    user_id = 1

    sql = "DELETE FROM users WHERE id = %s"

    cursor.execute(sql, (user_id,))

    conn.commit()

    if cursor.rowcount > 0:
        print("User Deleted Successfully!")
    else:
        print("User Not Found!")

    cursor.close()
    conn.close()

except mysql.connector.Error as e:

    print("Database Error:", e)
