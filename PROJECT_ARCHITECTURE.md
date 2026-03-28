# PROJECT_ARCHITECTURE.md

## 🧠 System Overview

NexCart is a scalable eCommerce system built with:

* Laravel (Backend + Routing)
* Inertia.js (SPA bridge)
* Vue 3 (Frontend)
* Pinia (State management)
* MySQL (Database)

---

## 🏗️ Architecture Pattern

* MVC + Service Layer
* Server-driven SPA (Inertia.js)
* Modular feature-based structure

---

## 🔐 Role-Based Access Control (RBAC)

The system implements a **flexible permission-based RBAC system**.

### 📊 Tables

#### 1. roles

* id
* name (admin, customer, manager)
* slug
* created_at

#### 2. permissions

* id
* name (e.g., "create_product", "edit_product")
* slug
* created_at

#### 3. role_permission (pivot)

* id
* role_id
* permission_id

#### 4. user_role (pivot)

* id
* user_id
* role_id

---

## 🧩 Permission Strategy

Permissions are **action-based**, for example:

* product.create
* product.update
* product.delete
* order.manage
* user.manage
* coupon.apply

---

## 🧠 Authorization Flow

1. User logs in
2. User has one or more roles
3. Roles have multiple permissions
4. Permissions are checked via:

   * Middleware
   * Policies
   * Gates

---

## 🔐 Middleware Example

```php
Route::middleware(['permission:product.create'])->group(function () {
    Route::post('/products', ...);
});
```

---

## 🧠 Laravel Implementation

### Use:

* Gates (`AuthServiceProvider`)
* Policies (for models)
* Custom middleware: `CheckPermission`

---

## 🗄️ Database Modules

### Core Tables

* users
* roles
* permissions
* role_permission
* user_role

### eCommerce Tables

* products
* categories
* product_variants
* attributes
* attribute_values
* carts
* cart_items
* orders
* order_items
* coupons
* wishlists
* reviews
* payments
* addresses

---

## 🛍️ Core Modules

### Products

* Supports variants
* SKU-based system
* Stock tracking

### Categories

* Hierarchical (parent_id)

### Cart

* Stored in DB + synced with Pinia

### Orders

* Full lifecycle management

---

## ⚡ Frontend Architecture

* Pages → Inertia pages
* Components → reusable UI
* Stores → Pinia global state

---

## 📦 Pinia Stores

* useAuthStore
* useCartStore
* useProductStore
* useOrderStore
* usePermissionStore (IMPORTANT)

---

## 🔁 Navigation System

* Laravel routes (web.php)
* Inertia renders Vue pages
* NO Vue Router

---

## 🔐 Security Layer

* Sanctum authentication
* Permission middleware
* Input validation
* Secure password hashing

---

## 🚀 Performance Strategy

* Eager loading
* Indexing
* Caching (optional Redis)

---

## 📊 Scalability

Future-ready for:

* Multi-vendor
* API versioning
* Mobile app

---

## 📞 Summary

This architecture ensures:

* Fine-grained permission control
* Scalable system design
* Clean separation of concerns
* Production-ready performance
