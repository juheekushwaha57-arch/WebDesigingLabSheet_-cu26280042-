import csv
import mysql.connector

try:

    conn = mysql.connector.connect(
        host="localhost",
        user="root",
        password="",
        database="python_web_db"
    )

    cursor = conn.cursor()

    with open("users.csv", "r") as file:

        reader = csv.DictReader(file)

        data = []

        for row in reader:
            data.append((
                row["name"],
                row["email"],
                int(row["age"])
            ))

    sql = """
    INSERT INTO users (name, email, age)
    VALUES (%s, %s, %s)
    """

    cursor.executemany(sql, data)

    conn.commit()

    print("CSV Data Inserted Successfully!")

    cursor.close()
    conn.close()

except Exception as e:
    print("Error:", e)
