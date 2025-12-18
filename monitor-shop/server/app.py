from flask import Flask, jsonify, request, send_from_directory
from flask_cors import CORS
import sqlite3
import os
import time

app = Flask(__name__, static_folder='client/dist')
CORS(app)

DB_PATH = 'database.db'

def init_db():
    with sqlite3.connect(DB_PATH) as conn:
        cursor = conn.cursor()
        cursor.execute('''
            CREATE TABLE IF NOT EXISTS goods (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                name TEXT NOT NULL,
                price REAL NOT NULL,
                releaseDate TEXT,
                matrix TEXT,
                resolution TEXT,
                refreshRate TEXT,
                description TEXT
            )
        ''')

        cursor.execute('SELECT COUNT(*) FROM goods')
        if cursor.fetchone()[0] == 0:
            print("Loading initial data...")
            initial_data = [
                {
                    "name": f"Monitor {brand} {i}",
                    "price": 15000 + (i * 1000),
                    "releaseDate": "2024-01-01",
                    "matrix": "IPS",
                    "resolution": "4K",
                    "refreshRate": "144Hz",
                    "description": "Professional display"
                } for i, brand in enumerate(['Samsung', 'LG', 'ASUS', 'Dell'] * 5)
            ]
            for item in initial_data:
                cursor.execute('''
                    INSERT INTO goods (name, price, releaseDate, matrix, resolution, refreshRate, description)
                    VALUES (?, ?, ?, ?, ?, ?, ?)
                ''', (
                    item['name'], item['price'], item['releaseDate'],
                    item['matrix'], item['resolution'], item['refreshRate'], item['description']
                ))
        conn.commit()

@app.route('/api/goods', methods=['GET'])
def get_goods():
    time.sleep(0.3)
    page = int(request.args.get('page', 1))
    limit = int(request.args.get('limit', 10))
    offset = (page - 1) * limit

    with sqlite3.connect(DB_PATH) as conn:
        conn.row_factory = sqlite3.Row
        cursor = conn.cursor()
        cursor.execute('SELECT * FROM goods LIMIT ? OFFSET ?', (limit, offset))
        rows = cursor.fetchall()
        cursor.execute('SELECT COUNT(*) FROM goods')
        total = cursor.fetchone()[0]

        data = []
        for row in rows:
            d = dict(row)
            d['specs'] = {
                'matrix': d.pop('matrix'),
                'resolution': d.pop('resolution'),
                'refreshRate': d.pop('refreshRate')
            }
            data.append(d)

    return jsonify({
        "data": data,
        "total": total,
        "page": page,
        "hasMore": offset + limit < total
    })

@app.route('/api/goods/<int:item_id>', methods=['GET'])
def get_item(item_id):
    with sqlite3.connect(DB_PATH) as conn:
        conn.row_factory = sqlite3.Row
        cursor = conn.cursor()
        cursor.execute('SELECT * FROM goods WHERE id = ?', (item_id,))
        row = cursor.fetchone()
        if row:
            d = dict(row)
            d['specs'] = {
                'matrix': d.pop('matrix'),
                'resolution': d.pop('resolution'),
                'refreshRate': d.pop('refreshRate')
            }
            return jsonify(d)
        return jsonify({"error": "Not found"}), 404

@app.route('/', defaults={'path': ''})
@app.route('/<path:path>')
def serve(path):
    if path != "" and os.path.exists(os.path.join(app.static_folder, path)):
        return send_from_directory(app.static_folder, path)
    return send_from_directory(app.static_folder, 'index.html')

if __name__ == '__main__':
    init_db()
    app.run(host='0.0.0.0', port=5000)