from flask import Flask, render_template, request, jsonify, session, redirect, url_for
import sqlite3
import os

app = Flask(__name__)

app.secret_key = 'your_secret_key'

# Database setup
DATABASE = 'users.db'

def create_table():
    conn = sqlite3.connect(DATABASE)
    c = conn.cursor()
    c.execute('''
        CREATE TABLE IF NOT EXISTS users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            username TEXT UNIQUE NOT NULL,
            password TEXT NOT NULL
        )
    ''')
    c.execute('''
        CREATE TABLE IF NOT EXISTS scores (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            user_id INTEGER,
            player_score INTEGER,
            ai_score INTEGER,
            tie_score INTEGER,
            FOREIGN KEY (user_id) REFERENCES users(id)
        )
    ''')
    conn.commit()
    conn.close()

create_table()

# Routes

@app.route('/')
def index():
    return render_template('index.html')

@app.route('/signup', methods=['POST'])
def signup():
    username = request.form.get('username')
    password = request.form.get('password')

    conn = sqlite3.connect(DATABASE)
    c = conn.cursor()

    try:
        c.execute("INSERT INTO users (username, password) VALUES (?, ?)", (username, password))
        conn.commit()
        message = "Sign up successful! Please log in."
    except sqlite3.IntegrityError:
        message = "Username already exists. Please choose another."

    conn.close()
    return render_template('index.html', message=message)

@app.route('/login', methods=['POST'])
def login():
    username = request.form.get('username')
    password = request.form.get('password')

    conn = sqlite3.connect(DATABASE)
    c = conn.cursor()
    c.execute("SELECT * FROM users WHERE username=? AND password=?", (username, password))
    user = c.fetchone()
    conn.close()

    if user:
        session['user_id'] = user[0]
        return redirect(url_for('game'))
    else:
        return render_template('index.html', message="Invalid username or password")

@app.route('/game')
def game():
    if 'user_id' in session:
        return render_template('game.html')
    else:
        return redirect(url_for('index'))

@app.route('/logout')
def logout():
    session.pop('user_id', None)
    return redirect(url_for('index'))

@app.route('/get_scores')
def get_scores():
    if 'user_id' in session:
        user_id = session['user_id']
        conn = sqlite3.connect(DATABASE)
        c = conn.cursor()
        c.execute("SELECT * FROM scores WHERE user_id=?", (user_id,))
        scores = c.fetchone()
        conn.close()

        if scores:
            return jsonify({'player_score': scores[1], 'ai_score': scores[2], 'tie_score': scores[3]})
        else:
            return jsonify({'player_score': 0, 'ai_score': 0, 'tie_score': 0})
    else:
        return jsonify({'player_score': 0, 'ai_score': 0, 'tie_score': 0})

if __name__ == '__main__':
    app.run(debug=True)
