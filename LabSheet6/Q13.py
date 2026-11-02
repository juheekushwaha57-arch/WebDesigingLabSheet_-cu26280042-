import mysql.connector
import logging
from datetime import datetime

logging.basicConfig(
    filename="database.log",
    level=logging.INFO,
    format="%(asctime)s - %(levelname)s - %(message)s"
)

try:

    conn = mysql.connector.connect(
        host="localhost",
        user="root",
        password="",
        database="python_web_db"
    )

    cursor = conn.cursor()

    cursor.execute("SELECT * FROM users")

    print("Database Access Successful!")

    logging.info("Database accessed successfully")

    cursor.close()
    conn.close()

except mysql.connector.Error as e:

    logging.error("Database Error: %s", e)

    print("Database Error Occurred!")
