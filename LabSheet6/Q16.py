from flask import Flask, jsonify
import mysql.connector

app = Flask(__name__)

@app.route("/users")

def get_users():

    conn = mysql.connector.connect(
        host="localhost",
        user="root",
        password="",
        database="python_web_db"
    )

    cursor = conn.cursor(dictionary=True)

    cursor.execute("SELECT * FROM users")

    users = cursor.fetchall()

    cursor.close()
    conn.close()

    return jsonify(users)

if __name__ == "__main__":

    app.run(debug=False)
