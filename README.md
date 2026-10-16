# LegendaryStore

LegendaryStore is a small PHP and MySQL shop for games, movies, music, and gift cards. It runs locally with XAMPP. Shoppers browse the catalog, keep a cart and a wishlist, and place orders. An admin account manages products, orders, messages, and accounts.

Topics: php, pdo, mysql, xampp, crud, ecommerce

## Screenshots

![Storefront](docs/screenshots/LSsnap_1.png)
![Catalog](docs/screenshots/LSsnap_2.png)
![Cart](docs/screenshots/LSsnap_3.png)
![Admin dashboard](docs/screenshots/LSadmin_1.png)
![Admin products](docs/screenshots/LSadmin_2.png)

## Features

- Product catalog with category pages and search
- Cart and wishlist stored per user
- Checkout that saves each line item and its price at purchase time
- Customer registration, login, and profile update
- Contact form
- Admin dashboard for products, orders, messages, users, and admin accounts

## Tech stack

- PHP 8.1+ with PDO
- MySQL or MariaDB
- Apache via XAMPP
- Composer PSR-4 autoloading for the `App\` namespace

## Architecture

A request lands on a page in `public/` or `admin/`. The page loads `app/bootstrap.php`, calls a model, and renders a shared header and footer. Models are the only files that run SQL. `App\Database` is the only PDO connection.

See [docs/architecture.md](docs/architecture.md).

```mermaid
flowchart LR
  browser[Browser] --> page[public_or_admin_page]
  page --> bootstrap[bootstrap.php]
  bootstrap --> model[Model]
  model --> db[Database_PDO]
  db --> mysql[(shop_db)]
  page --> partials[header_footer]
```

## Data model

`admins` is a separate account table. It has no foreign key to shoppers, carts, or messages.

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

`orders` keeps the buyer and the total. `order_items.unit_price` stores the price that was charged, so later product edits do not change old orders. Users have a unique email. Cart, wishlist, and message rows are removed with the user. Deleting a product clears cart and wishlist rows and leaves the order line in place with a null product id.

## Setup

Install [XAMPP](https://www.apachefriends.org/index.html) and [Composer](https://getcomposer.org/), then start Apache and MySQL.

Run these from the directory where you want the project, then run the last three inside the cloned folder:

```bash
git clone <repository-url> C:/xampp/htdocs/LegendaryStore
composer install
copy app/config/config.example.php app/config/config.php
mysql -u root -e "CREATE DATABASE IF NOT EXISTS shop_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;" && mysql -u root shop_db < database/schema.sql && mysql -u root shop_db < database/seed.sql
```

On Windows PowerShell, run the MySQL imports as three statements if `&&` is not available:

```powershell
mysql -u root -e "CREATE DATABASE IF NOT EXISTS shop_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
mysql -u root shop_db -e "source database/schema.sql"
mysql -u root shop_db -e "source database/seed.sql"
```

`source` paths are relative to the shell's current directory, so run them from the project folder. If the MySQL client is not on `PATH`, call `C:\xampp\mysql\bin\mysql.exe`.

Edit `app/config/config.php` when the database user or password is not `root` with an empty password. That file is gitignored.

Open the shop at <http://localhost/LegendaryStore/public>.

Open the admin login at <http://localhost/LegendaryStore/admin/login.php>. The seeded admin username is `admin`. The password is recorded only in a comment at the top of `database/seed.sql`.

## Setup with Docker

Install [Docker Desktop](https://www.docker.com/products/docker-desktop/). PHP, Composer, and MySQL do not need to be installed on the machine. From the project folder:

```bash
docker compose -f infra/docker-compose.yml up --build -d
```

The first start builds the PHP image, creates `shop_db`, and loads `database/schema.sql` and `database/seed.sql`. If `app/config/config.php` is missing, the web container copies `infra/config.php` into place. That file points at the Compose service `mysql` with user `root` and password `shop`. If `config.php` already exists from an XAMPP setup, change `host` to `mysql` and `pass` to `shop` before opening the site. Composer autoload is installed inside the container when `vendor/autoload.php` is missing.

Open the shop at <http://localhost:8080/public>.

Open the admin login at <http://localhost:8080/admin/login.php>. The admin account is the same seeded account described above.

Stop the containers with:

```bash
docker compose -f infra/docker-compose.yml down
```

`down` keeps the database volume. Add `-v` only when you want the next start to import the schema and seed again.

## Known limitations / future work

- Payment method is stored as a label. The shop does not charge a card or call a payment provider.
- There is no email verification and no password-reset flow.
- The Apache document root is the project folder under `htdocs`. `app/`, `database/`, `docs/`, and `storage/` are blocked with `.htaccess`. A vhost whose document root is `public/`, with an alias for `admin/`, would match a production layout more closely.
- New files saved to `public/uploads/` stay out of git. The seeded catalog images are already tracked.
- Category `offer` is available in the admin form and has no seeded products yet.
