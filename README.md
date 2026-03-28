# NexCart 🛒

NexCart is a modern, scalable, and production-ready single-vendor eCommerce web application built with Laravel, Inertia.js, and Vue 3. It provides a complete solution for managing products, orders, customers, and permissions with a clean architecture and high performance.

---

## 🚀 Tech Stack

* **Backend:** Laravel (Latest)
* **Frontend:** Vue 3 (Composition API)
* **SPA Bridge:** Inertia.js
* **State Management:** Pinia
* **Database:** MySQL (InnoDB, utf8mb4)
* **Authentication:** Laravel Sanctum
* **UI Framework:** Tailwind CSS

---

## ✨ Features

### 🛍️ Customer Features

* User authentication (Register, Login, Logout)
* Product browsing with advanced filtering
* Product variants (size, color, etc.)
* Add to cart (Pinia-powered global state)
* Persistent cart system
* Coupon & discount system
* Secure checkout process
* Order tracking & history
* Wishlist functionality
* Product reviews & ratings

---

### 🛠️ Admin Features

* Admin dashboard with analytics
* Product & category management
* Attribute & variant management
* Order management with status tracking
* Coupon management system
* User management
* Role & permission management (RBAC)
* Review moderation

---

## 🔐 Role-Based Access Control (RBAC)

NexCart uses a **flexible permission-based RBAC system**:

### Structure:

* **Users → Roles → Permissions**

### Tables:

* `roles`
* `permissions`
* `role_permission`
* `user_role`

### Example Permissions:

* `product.create`
* `product.update`
* `product.delete`
* `order.manage`
* `user.manage`

### Usage:

```php
$user->can('product.create');
```

> ❗ Role checks are NOT hardcoded. Always use permission-based authorization.

---

## 🧠 Architecture

* MVC + Service Layer pattern
* Server-driven SPA using Inertia.js
* Modular and scalable structure
* Clean separation of concerns

---

## ⚠️ Important Notes

* ❌ Vue Router is NOT used
* ✅ Laravel routes + Inertia handle navigation
* ✅ Pinia manages global state (cart, auth, etc.)

---

## 📁 Project Structure

### Laravel

* `app/Models`
* `app/Http/Controllers`
* `app/Http/Requests`
* `app/Services`
* `routes/web.php`
* `database/migrations`

### Vue (Inertia)

* `resources/js/Pages`
* `resources/js/Components`
* `resources/js/Layouts`
* `resources/js/Stores`

---

## 📦 Installation

```bash
git clone https://github.com/your-username/nexcart.git
cd nexcart
composer install
npm install
cp .env.example .env
php artisan key:generate
```

### ⚙️ Configure Environment

Update your `.env` file with MySQL credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nexcart
DB_USERNAME=root
DB_PASSWORD=your_password
```

---

### ▶️ Run the Project

```bash
php artisan migrate --seed
npm run dev
php artisan serve
```

---

## 🧪 Testing (Optional)

```bash
php artisan test
```

---

## 🔐 Security

* CSRF protection via Sanctum
* Input validation using Form Requests
* Protection against XSS & SQL injection
* Secure password hashing

---

## 🚀 Performance

* Eager loading to avoid N+1 queries
* Optimized MySQL indexing
* Pagination for large datasets
* Optional caching (Redis)

---

## 📊 Future Improvements

* Multi-vendor marketplace support
* Payment gateway integration (Stripe, SSLCommerz, PayPal)
* Mobile app integration
* Real-time notifications
* Advanced analytics dashboard

---

## 🤝 Contribution

Contributions are welcome! Feel free to fork this repository and submit a pull request.

---

## 📄 License

This project is open-source and available under the MIT License.

---

## 👨‍💻 Author

Developed by **Rubel Mahmud**

---

## ⭐ Support

If you like this project, give it a ⭐ on GitHub!
