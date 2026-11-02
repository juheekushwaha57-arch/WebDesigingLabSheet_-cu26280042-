import mysql.connector
import logging
from datetime import datetime

logging.basicConfig(
    filename="database.log",
    level=logging.INFO,
    format="%(asctime)s - %(levelname)s - %(message)s"
)

try:

    logging.info("Database access started")

    conn = mysql.connector.connect(
        host="localhost",
        user="root",
        password="",
        database="python_web_db"
    )

    cursor = conn.cursor()

    cursor.execute("SELECT * FROM users")

    records = cursor.fetchall()

    print("Records Retrieved:", len(records))

    logging.info("Database access successful")

    cursor.close()
    conn.close()

except mysql.connector.Error as e:

    logging.error("Database Error: %s", e)

    print("Database Error Occurred!")

print("Timestamp:", datetime.now())
