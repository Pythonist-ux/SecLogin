# SecLogin System
# Introduction

SecLogin is a simple PHP-based authentication system that provides secure user authentication, login, and signup functionalities. This system uses a MySQL database to store user information securely.

# Installation

1. Clone the repository to your local machine:

       git clone https://github.com/Pythonist-ux/SecLogin.git

2. Set up a MySQL database and update the database connection details in LoginPage.php and Signup.php:

        $servername = "localhost";
        $username = "your_username";
        $password = "your_password";
        $database = "your_database";
    
3. Import the seclogin_db.sql file into your MySQL database to create the necessary tables.

4. Ensure your PHP environment is set up and running.

   # Functionalities
1. User Authentication

    Users can authenticate themselves by providing their username and password.
    Passwords are securely hashed using the password_hash function before being stored in the database.
    The system uses password_verify to validate user-entered passwords during login.

   ![image](https://github.com/Pythonist-ux/SecLogin/assets/83156291/8b48e7d3-4acb-45d5-a606-8571ab8e56ae)


3. Login Page (LoginPage.php)

    The login page allows users to enter their credentials.
    Minimalist design with a dark theme for an enhanced user experience.
    Invalid username or password displays appropriate error messages.
    Upon successful login, users are redirected to the dashboard (Dashboard.php).
   
   ![image](https://github.com/Pythonist-ux/SecLogin/assets/83156291/80f1c378-a4e9-4060-ae75-47bbb4f65541)

   ![image](https://github.com/Pythonist-ux/SecLogin/assets/83156291/db7fedea-bf83-4fd5-88e7-9cbbcbba8532)



5. Dashboard (Dashboard.php)

    Authenticated users are greeted with a welcome message.
    Provides a logout button for users to securely log out of their accounts.
    Sessions are used to track user authentication status.

   ![image](https://github.com/Pythonist-ux/SecLogin/assets/83156291/6a769c28-d8c1-4a68-9d72-a0277d6dc5a7)

7. Signup Page (Signup.php)

    Users can create a new account by providing a unique username, email, and password.
    Passwords are securely hashed before being stored in the database.
    Checks for existing usernames and emails to ensure uniqueness.
    Simulates a two-factor authentication (2FA) process via email (simulated with a random verification code).

   ![image](https://github.com/Pythonist-ux/SecLogin/assets/83156291/b7f50222-b032-4d84-8e8c-7cd776f5afcd)


9. Database Connection

    The system establishes a secure connection to a MySQL database.
    Database connection details (server, username, password, database name) are configurable.

10. Security Measures

    Passwords are hashed using bcrypt to enhance security.
    Input validation is implemented to prevent SQL injection and other common security vulnerabilities.
    The system recommends using HTTPS to encrypt data in transit.

    

                     
