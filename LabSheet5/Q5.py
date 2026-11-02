import mysql.connector

try:
    conn = mysql.connector.connect(
        host="localhost",
        user="root",
        password="",
        database="python_web_db"
    )

    cursor = conn.cursor()

    sql = """
    INSERT INTO users (name, email, age)
    VALUES (%s, %s, %s)
    """

    users = [
        ("Rahul", "rahul@gmail.com", 21),
        ("Amit", "amit@gmail.com", 22),
        ("Priya", "priya@gmail.com", 20)
    ]

    cursor.executemany(sql, users)

    conn.commit()

    print("Multiple Records Inserted Successfully!")

    cursor.close()
    conn.close()

except mysql.connector.Error as e:
    print("Error:", e)
