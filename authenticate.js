

const mysql = require('mysql');
const https = require('https'); 
const crypto = require('crypto');

// Database connection
const db = mysql.createConnection({
  host: 'localhost',
  user: 'root',
  password: '1234',
  database: 'SecLogin_db'
});

// Session management
const session = require('express-session');
const sess = {
  secret: 'keyboard cat',
  cookie: {}
};

// Login route
app.post('/login', (req, res) => {

  // Get username and password from request
  const username = req.body.username;
  const password = req.body.password;
  
  // Query database
  db.query('SELECT * FROM users WHERE username = ? AND password = ?', [username, password], (error, results) => {
    if (error) throw error;
    
    // If user exists, set session and redirect
    if (results.length > 0) {
      req.session.user = results[0];
      res.redirect('/dashboard');
    } else {
      res.send('Invalid username or password');
    }
  });

});

// Dashboard route
app.get('/dashboard', (req, res) => {
  if (req.session.user) {
    res.send(`Welcome ${req.session.user.name}!`);
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
https.createServer({
  key: fs.readFileSync('server.key'),
  cert: fs.readFileSync('server.cert')
}, app).listen(3000, () => {
  console.log('Server running on port 3000');  
});