import mysql.connector

conn = mysql.connector.connect(
    host="localhost",
    user="root",
    password="",
    database="python_web_db"
)

cursor = conn.cursor()

cursor.execute("SELECT * FROM users")

records = cursor.fetchall()

html = """
<html>
<head>
<title>User Records</title>
</head>
<body>
<h2>User Details</h2>
<table border='1' cellpadding='10'>
<tr>
<th>ID</th>
<th>Name</th>
<th>Email</th>
</tr>
"""

for row in records:
    html += "<tr>"
    for value in row:
        html += "<td>" + str(value) + "</td>"
    html += "</tr>"

html += "</table></body></html>"

print(html)

cursor.close()
conn.close()
