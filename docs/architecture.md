# Architecture

A browser request hits a page in `public/` or `admin/`. That page loads `app/bootstrap.php`, which starts the session, checks the CSRF token on POST, and registers an error handler that writes to `storage/app.log`.

The page calls a model. The model is the only place that runs SQL. `App\Database` opens one PDO connection from `app/config/config.php`. The page then includes `app/views/partials/header.php` and `footer.php` (admin pages use `admin_header.php` and `admin_footer.php`).

```mermaid
flowchart LR
  browser[Browser] --> page[public_or_admin_page]
  page --> bootstrap[bootstrap.php]
  bootstrap --> model[Model]
  model --> db[Database_PDO]
  db --> mysql[(shop_db)]
  page --> partials[header_footer]
```

`app/`, `database/`, `docs/`, and `storage/` each contain an Apache `Require all denied` rule so those directories are not served when the project sits in `htdocs`. Uploaded product images live in `public/uploads/` and PHP files cannot be executed from that folder.

Checkout reads the cart in the database and copies each line into `order_items` with the price at purchase time. The total is calculated on the server.

`admins` has no foreign key to shoppers or their carts. A message can be sent without an account, so `messages.user_id` is nullable.

```mermaid
erDiagram
    users ||--o{ orders : places
    users ||--o{ cart : keeps
    users ||--o{ wishlist : saves
    users |o--o{ messages : sends
    orders ||--|{ order_items : contains
    products |o--o{ order_items : "price snapshot"
    products ||--o{ cart : "added to"
    products ||--o{ wishlist : "saved in"

    users {
        int id PK
        string name
        string email UK
        string password
        datetime created_at
    }
    admins {
        int id PK
        string name UK
        string password
        datetime created_at
    }
    products {
        int id PK
        string name
        string details
        int price
        string category
        string image_01
        string image_02
        string image_03
        datetime created_at
    }
    cart {
        int id PK
        int user_id FK
        int pid FK
        string name
        int price
        int quantity
        string image
        datetime created_at
    }
    wishlist {
        int id PK
        int user_id FK
        int pid FK
        string name
        int price
        string image
        datetime created_at
    }
    orders {
        int id PK
        int user_id FK
        string name
        string number
        string email
        string method
        string address
        int total_price
        string payment_status
        date placed_on
        datetime created_at
    }
    order_items {
        int id PK
        int order_id FK
        int product_id FK
        string name
        int quantity
        int unit_price
    }
    messages {
        int id PK
        int user_id FK
        string name
        string email
        string number
        string message
        datetime created_at
    }
```
