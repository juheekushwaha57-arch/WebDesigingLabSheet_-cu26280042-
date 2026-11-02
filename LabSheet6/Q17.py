import subprocess

try:

    command = [
        "mysqldump",
        "-h", "localhost",
        "-u", "root",
        "python_web_db"
    ]

    with open("backup.sql", "w") as file:

        subprocess.run(
            command,
            stdout=file,
            check=True
        )

    print("Database Backup Created Successfully!")

except Exception as e:

    print("Backup Error:", e)
