# NEXUS SHOP — Laravel E-Commerce Project Structure

```
nexus-shop/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/
│   │   │   │   ├── DashboardController.php
│   │   │   │   ├── ProductController.php
│   │   │   │   ├── CategoryController.php
│   │   │   │   └── OrderController.php
│   │   │   ├── Auth/
│   │   │   │   └── AuthController.php
│   │   │   └── Shop/
│   │   │       ├── HomeController.php
│   │   │       ├── ProductController.php
│   │   │       ├── CartController.php
│   │   │       └── CheckoutController.php
│   │   └── Middleware/
│   │       └── AdminMiddleware.php
│   └── Models/
│       ├── User.php
│       ├── Product.php
│       ├── Category.php
│       ├── Cart.php
│       ├── CartItem.php
│       ├── Order.php
│       └── OrderItem.php
├── database/
│   ├── migrations/
│   │   ├── 2024_01_01_000001_create_users_table.php
│   │   ├── 2024_01_01_000002_create_categories_table.php
│   │   ├── 2024_01_01_000003_create_products_table.php
│   │   ├── 2024_01_01_000004_create_carts_table.php
│   │   ├── 2024_01_01_000005_create_cart_items_table.php
│   │   ├── 2024_01_01_000006_create_orders_table.php
│   │   └── 2024_01_01_000007_create_order_items_table.php
│   └── seeders/
│       ├── DatabaseSeeder.php
│       ├── UserSeeder.php
│       ├── CategorySeeder.php
│       └── ProductSeeder.php
├── routes/
│   └── web.php
└── resources/
    └── views/
        ├── layouts/
        │   ├── app.blade.php          (storefront layout)
        │   └── admin.blade.php        (admin layout)
        ├── components/
        │   ├── product-card.blade.php
        │   ├── cart-sidebar.blade.php
        │   └── flash-message.blade.php
        ├── shop/
        │   ├── home.blade.php
        │   ├── catalog.blade.php
        │   ├── product.blade.php
        │   ├── cart.blade.php
        │   └── checkout.blade.php
        ├── admin/
        │   ├── dashboard.blade.php
        │   ├── products/
        │   │   ├── index.blade.php
        │   │   ├── create.blade.php
        │   │   └── edit.blade.php
        │   ├── categories/
        │   │   └── index.blade.php
        │   └── orders/
        │       ├── index.blade.php
        │       └── show.blade.php
        └── auth/
            ├── login.blade.php
            └── register.blade.php
```
