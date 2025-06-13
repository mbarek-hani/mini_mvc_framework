# Mini MVC Framework Structure
A mini MVC framework school project

```
mini_mvc_framework/
├── public/
│   ├── index.php                   # Entry point
│   ├── .htaccess                   # URL rewriting
│   ├── css/
│   │   └── style.css
│   └── js/
│       └── app.js
├── app/
│   ├── controllers/
│   │   ├── HomeController.php
│   │   └── UserController.php
│   ├── models/
│   │   └── User.php
│   └── views/
│       ├── home/
│       │   └── index.php
│       ├── users/
│       │   ├── index.php
│       │   └── profile.php
│       └── layout/                 # Here is all the common layouts like header.php footer.php
├── core/
│   ├── Router.php                  # Routes requests to controllers
│   ├── Request.php                 # HTTP request wrapper
│   ├── Response.php                # HTTP response wrapper
│   ├── View.php                    # Simple view renderer
│   ├── Database.php                # PDO wrapper
│   ├── Session.php                 # Session management
│   └── Security.php                # CSRF protection
├── config/
│   ├── database.php                # DB config
│   └── app.php                     # Basic app config
└── routes.php                      # Route definitions
```

## What each component will do:

### Core Classes:
- **Router**: Match URLs to controller methods
- **Request**: Get POST, GET, headers, etc.
- **Response**: Send JSON, redirects, set headers
- **View**: Load and render PHP templates
- **Database**: Simple PDO wrapper for SQL queries
- **Session**: Handle login/logout, flash messages
- **Security**: Generate/validate CSRF tokens

### Simple workflow:
1. **index.php** → loads router and routes
2. **Router** → matches URL to controller method
3. **Controller** → gets data from model, loads view
4. **Model** → runs SQL queries with PDO
5. **View** → renders HTML template

### Example routing:
```php
// routes.php
$router->get('/', 'HomeController@index');
$router->get('/users', 'UserController@index');
$router->post('/users', 'UserController@store');
```

### Example controller:
```php
class UserController {
    public function index() {
        $users = User::all();
        return view('users/index', ['users' => $users]);
    }
}
```

### Example model
```php
class User {
    public static function all() {
        $db = Database::connect();
        return $db->query("SELECT * FROM users")->fetchAll();
    }

    public static function find($id) {
        $db = Database::connect();
        $stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
}
```