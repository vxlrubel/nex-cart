# AGENTS.md

## 🧠 Important Instruction

Before generating any code, ALWAYS read:

👉 PROJECT_ARCHITECTURE.md

This file defines:

* Database structure
* RBAC system (roles & permissions)
* Application architecture

---

## ⚠️ Core Rules

❌ Do NOT use Vue Router
✅ Use Laravel + Inertia

---

## 🔐 Authorization Rule (CRITICAL)

The system uses **Role-Based Access Control (RBAC)**:

* Users → Roles → Permissions
* Permissions must be checked in:

  * Controllers
  * Middleware
  * Policies

### NEVER:

* Hardcode role checks like:

  ```php
  if ($user->role == 'admin')
  ```

### ALWAYS:

* Use permission-based checks:

  ```php
  $user->can('product.create')
  ```

---

## 🧩 Required Tables

Agents MUST ensure these exist:

* roles
* permissions
* role_permission
* user_role

---

## 🧠 Backend Rules

1. Use Inertia::render for pages
2. Use Service Layer for logic
3. Use FormRequest for validation
4. Apply permission middleware where needed

---

## 🔁 Routing

* Use routes/web.php
* Example:

```php
Route::get('/products', fn () => Inertia::render('Products/Index'));
```

---

## ⚡ Frontend Rules

* Use Inertia `<Link>`
* Use Pinia stores
* Add permission-based UI control:

  * Hide buttons if no permission

Example:

```js
if (!authStore.can('product.create')) return;
```

---

## 🗄️ Database Rules

Follow PROJECT_ARCHITECTURE.md strictly.

---

## 🚀 Performance

* Avoid N+1 queries
* Use eager loading
* Use indexes

---

## 🧭 Agent Workflow

When adding a feature:

1. Check PROJECT_ARCHITECTURE.md
2. Create migration
3. Create model + relations
4. Add permissions if needed
5. Create controller
6. Add middleware
7. Create Inertia page
8. Update Pinia store

---

## 📞 Summary

NexCart is a permission-driven, scalable eCommerce system.

Agents must:

* Follow RBAC strictly
* Never bypass permissions
* Maintain clean architecture
