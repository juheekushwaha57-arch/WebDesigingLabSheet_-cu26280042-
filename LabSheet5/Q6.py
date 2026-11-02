import mysql.connector

conn = mysql.connector.connect(
    host="localhost",
    user="root",
    password="",
    database="python_web_db"
)

cursor = conn.cursor()

cursor.execute("SELECT * FROM users")

rows = cursor.fetchall()

html = """
<html>
<head>
<title>User Records</title>
</head>
<body>

<h2>User Records</h2>

<table border="1" cellpadding="10">
<tr>
<th>ID</th>
<th>Name</th>
<th>Email</th>
<th>Age</th>
</tr>
"""

from html import escape

for row in rows:
    html += "<tr>"
    for value in row:
        html += "<td>" + escape(str(value)) + "</td>"
    html += "</tr>"

html += """
</table>
</body>
</html>
"""

print(html)

cursor.close()
conn.close()
