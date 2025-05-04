# Support Ticket System

## Introduction

Support Ticket System enables users to submit issues via a simple web form and allows administrators to manage, track, and resolve those tickets through a feature-rich admin dashboard. It demonstrates clean PHP backend code, AJAX-driven interactions, and modern frontend styling with Tailwind CSS.

---

## Features

* **User Interface**

  * Responsive ticket submission form with client-side validation.
  * AJAX form submission for seamless user experience.

* **Admin Dashboard**

  * **Filter** tickets by status (Open/Closed) and keyword (ID, name, email, message).
  * **Search** tickets by any keywords from ID, name, email, message.
  * **Details Modal** to view full ticket details without leaving the page.
  * **Toggle Status** of individual tickets via AJAX.
  * **Delete** individual tickets via AJAX.
  * **Bulk Actions**: Select multiple tickets to close or delete in one operation.
  * **Pagination**: Navigate large ticket sets in pages of 10.

* **Security Basics**

  * Prepared statements (PDO) for SQL queries.
  * Input sanitization and output escaping across the application.

---

## Prerequisites

* **PHP** 7.4 or higher with PDO MySQL extension enabled.
* **MySQL** 5.7 or higher.
* **Tailwind CSS** (loaded via CDN).
* Web server or PHP built-in server.

---

## Environment Setup

### 1. MySQL Database Setup

Open a Command Prompt or PowerShell and run: [user: root, password: admin]

```bash
cd "C:\Program Files\MySQL\MySQL Server 8.4\bin"

# 1. Create the database
mysql.exe -u root -padmin -e "CREATE DATABASE IF NOT EXISTS support CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# 2. Import the schema
mysql.exe -u root -padmin support < "C:\Users\Engr. Ahmed\Desktop\support_ticket_system\database.sql"

# 3. Verify data
mysql.exe -u root -padmin -e "SELECT * FROM support.tickets;"
```

### 2. PDO Extension Configuration

If you see a "could not find driver" error, enable pdo\_mysql:

```bash
cd C:\php
# Copy a template to create php.ini
copy php.ini-development php.ini
```

Open `php.ini` in a text editor and uncomment:

```ini
extension_dir = "ext"
extension=pdo_mysql
```

Restart your server:

```bash
php -c C:\php\php.ini -S localhost:8000
```

Visit [http://localhost:8000/public/phpinfo.php](http://localhost:8000/public/phpinfo.php) and confirm **PDO** → **mysql** is enabled.

---
### 3. PHP Server Setup

From your project root (`support_ticket_system`):

```bash
# Launch PHP's built-in server
php -S localhost:8000
```

* **User form:**  [http://localhost:8000/public/index.php](http://localhost:8000/public/index.php)
* **Admin panel:** [http://localhost:8000/admin/index.php](http://localhost:8000/admin/index.php)



## Directory Structure

```
support_ticket_system/
├─ admin/
│  ├─ index.php           # Admin dashboard UI
│  ├─ toggle_status.php   # AJAX status toggle endpoint
│  ├─ delete_ticket.php   # AJAX delete endpoint
│  └─ bulk_action.php     # AJAX bulk close/delete endpoint
├─ js/
│  ├─ validation.js       # Client-side form validation
│  ├─ ajax.js             # AJAX logic for public form
│  └─ admin.js            # AJAX logic for admin actions
├─ public/
│  ├─ index.php           # User ticket submission form
│  ├─ submit_ticket.php   # AJAX ticket creation endpoint
│  └─ phpinfo.php         # Debugging PHP configuration
├─ config.php             # PDO database connection
├─ database.sql           # MySQL schema
└─ README.md              # This file
```

---

## How to Use

### A. Submitting a Ticket (Public)

1. Open the user form: `public/index.php`.
2. Fill in **Name**, **Email**, and **Issue Description**.
3. Click **Submit**.
4. You’ll see a success message in bold green, and the form resets automatically.

### B. Managing Tickets (Admin)

1. Open the admin panel: `admin/index.php`.
2. **Filter** by status or **Search** by keyword/ID.
3. **Select All** to toggle row checkboxes for bulk actions.
4. **Close Selected** or **Delete Selected** to apply actions via AJAX (in-place).
5. Click **Details** to view full ticket data in a modal popup.
6. Use **Toggle** or **Delete** buttons on each row for individual actions.
7. Navigate pages with **Prev/Next** links.

---

## Assumptions

* No user authentication: Admin access is by obscurity.
* No email notifications: Ticket actions do not trigger emails.
* Basic validation and sanitization: Adequate for a demo-level system.

---

## Future Enhancements

* Role-based access control (login/logout).
* Attachment support (file uploads).
* Dashboard metrics (graphs, charts).
* Email notifications on ticket updates.
* Improved UI/UX with custom themes.


## UI Screenshots
![image](https://github.com/user-attachments/assets/5ecd00fc-3ab3-4e05-935a-e4e07dd1e991)
![image](https://github.com/user-attachments/assets/0728e6b8-430f-4185-8770-ef1d69e1e5b5)
![image](https://github.com/user-attachments/assets/6772e77a-da36-417c-8750-a1e9b8138ee0)
![image](https://github.com/user-attachments/assets/cfa0dc27-95b2-43d6-bf34-0cf83a9f57ee)
![image](https://github.com/user-attachments/assets/19a1ebae-8b3f-49af-aeba-c47fb55e3935)
![image](https://github.com/user-attachments/assets/cbef71c3-b75f-4c5a-8f3a-5cb7cce61bcf)

---

**Thank you for using the Support Ticket System!**
