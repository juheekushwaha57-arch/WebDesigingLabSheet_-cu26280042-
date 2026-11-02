from flask import Flask, session
import mysql.connector
import secrets

app = Flask(__name__)

app.secret_key = secrets.token_hex(32)

def get_connection():
    return mysql.connector.connect(
        host="localhost",
        user="root",
        password="",
        database="python_web_db"
    )

@app.route("/")
def home():

    if "username" not in session:
        session["username"] = "Rahul"

        conn = get_connection()
        cursor = conn.cursor()

        cursor.execute(
            """
            INSERT INTO user_sessions
            (session_id, username)
            VALUES (%s, %s)
            """,
            (session.sid if hasattr(session, "sid")
             else secrets.token_hex(16),
             session["username"])
        )

        conn.commit()
        cursor.close()
        conn.close()

    return "Welcome " + session["username"]

if __name__ == "__main__":
    app.run(debug=False)
