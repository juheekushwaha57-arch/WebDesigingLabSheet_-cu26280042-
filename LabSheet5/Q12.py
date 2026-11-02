import mysql.connector
from mysql.connector import pooling

dbconfig = {
    "host": "localhost",
    "user": "root",
    "password": "",
    "database": "python_web_db"
}

try:

    pool = mysql.connector.pooling.MySQLConnectionPool(
        pool_name="mypool",
        pool_size=5,
        **dbconfig
    )

    conn = pool.get_connection()

    cursor = conn.cursor()

    cursor.execute("SELECT * FROM users")

    records = cursor.fetchall()

    for row in records:
        print(row)

    cursor.close()
    conn.close()

    print("Connection Pool Working Successfully!")

except mysql.connector.Error as e:
    print("Error:", e)
