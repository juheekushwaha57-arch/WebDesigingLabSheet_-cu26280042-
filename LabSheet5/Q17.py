import subprocess
import os

database = "python_web_db"

try:

    result = subprocess.run(
        [
            "C:/xampp/mysql/bin/mysqldump.exe",
            "-h", "localhost",
            "-u", "root",
            database
        ],
        capture_output=True,
        text=True,
        check=True
    )

    with open("python_web_db_backup.sql", "w") as file:
        file.write(result.stdout)

    print("Database Backup Created Successfully!")

except subprocess.CalledProcessError as e:

    print("Backup Failed:", e.stderr)

except Exception as e:

    print("Error:", e)
