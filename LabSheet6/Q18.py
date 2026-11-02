from flask import Flask, session

app = Flask(__name__)

app.secret_key = "replace-with-a-random-secret"

@app.route("/login")

def login():

    session["username"] = "Rahul"

    return "Login Session Created Successfully!"

@app.route("/dashboard")

def dashboard():

    if "username" in session:

        return "Welcome " + session["username"]

    return "Please Login First!"

@app.route("/logout")

def logout():

    session.clear()

    return "Session Destroyed Successfully!"

if __name__ == "__main__":

    app.run()
