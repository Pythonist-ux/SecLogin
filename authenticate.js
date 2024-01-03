const express = require('express');
const app = express();
const mysql = require('mysql');
const https = require('https');
const fs = require('fs');
const bodyParser = require('body-parser');
const session = require('express-session');
const bcrypt = require('bcrypt');

// Initialize Express
app.use(express.json());
app.use(bodyParser.urlencoded({ extended: true }));
app.use(session({ secret: 'keyboard cat', resave: true, saveUninitialized: true }));

// Database connection
const db = mysql.createConnection({
  host: 'localhost',
  user: 'root',
  password: '1234',
  database: 'seclogin_db'
});

// Login route
app.post('/login', (req, res) => {
  const username = req.body.username;
  const password = req.body.password;

  // Query database
  db.query('SELECT * FROM users WHERE username = ?', [username], (error, results) => {
    if (error) throw error;

    if (results.length > 0) {
      const user = results[0];

      // Compare hashed password
      bcrypt.compare(password, user.password, (err, result) => {
        if (err) throw err;

        if (result) {
          req.session.user = user;
          res.redirect('/dashboard');
        } else {
          res.send('Invalid username or password');
        }
      });
    } else {
      res.send('Invalid username or password');
    }
  });
});

// Dashboard route
app.get('/dashboard', (req, res) => {
  if (req.session.user) {
    res.send(`Welcome ${req.session.user.username}!`);
  } else {
    res.redirect('/login');
  }
});

// Logout route
app.get('/logout', (req, res) => {
  req.session.destroy();
  res.redirect('/login');
});

// Create HTTPS server
https.createServer(
  {
    key: fs.readFileSync('server.key'),
    cert: fs.readFileSync('server.cert')
  },
  app
).listen(3000, () => {
  console.log('Server running on port 3000');
});
