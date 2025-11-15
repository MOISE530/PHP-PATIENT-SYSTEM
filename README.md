# PHP-PATIENT-SYSTEM
### How sessions were used

In this CRUD system, sessions are used to manage user authentication and access control.

Starting a session:

At the top of every page that requires login (dashboard.php, insert.php, display.php etc), we call:

session_start(); 

### Creating a session on login:

When a user successfully logs in, we store their username in a session variable:

$_SESSION['username'] = $username;


This keeps the user “logged in” while browsing the protected pages.

### HOW COOKIES USED

How cookies were used

In this CRUD system, cookies are used to remember the user’s username for convenience when logging in.

Setting a cookie on login:

When a user logs in and selects the “Remember Me” checkbox, the system creates a cookie to store their username.

### Deleting the cookie:

If the user logs in without checking “Remember Me”, or if they log out, the cookie is deleted.

### Important notes:

Cookies do not replace sessions. They only remember the username for convenience.

The session ($_SESSION['username']) is still required to access protected pages.

If the session expires, the cookie can optionally be used to auto-create a session for seamless login (optional feature).

### How authentication is secured

In this CRUD system, authentication is secured using a combination of sessions, prepared statements, and input sanitization:

Sessions for access control:

After a successful login, the system creates a session variable:

$_SESSION['username'] = $username;


All protected pages check if the session exists before allowing access:

if(!isset($_SESSION['username'])){
    header("Location: login.php");
    exit;
}


This ensures only authenticated users can access sensitive pages like adding, editing, or deleting records.

Prepared statements for SQL queries:

When checking credentials or inserting data, the system uses prepared statements to prevent SQL injection attacks:

$stmt = mysqli_prepare($conn, "SELECT password FROM users WHERE username=?");
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);


User input is never directly concatenated into SQL queries, which protects the database from malicious input.

Input sanitization:

All user input is sanitized to prevent harmful data from being processed:

$username = htmlspecialchars(trim($_POST['username']));


This protects against XSS (Cross-Site Scripting) and ensures that form inputs are clean.