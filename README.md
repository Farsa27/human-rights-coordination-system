# Human Rights Coordination System

A PHP and MySQL web application that helps people in Dhaka find institutions related to the five fundamental rights in Bangladesh's constitution: **food, clothing, education, shelter and health care**. Users can filter institutions by price range and city corporation, donate money, or request financial help, and administrators manage the institution list and review help requests.

This was a two-person group project for **CSE370: Database Systems** at BRAC University (Spring 2025). I built the institution browsing and filtering, profile editing and donation features, frontend and backend.

![User home page](docs/screenshots/02-home.png)

## Features

**Users**
- Sign up, log in and log out.
- Browse institutions for each of the five rights, filtered by price range (low to high) and by city corporation (Dhaka North, Dhaka South or both).
- Update their name, password and phone number.
- Donate any amount as a donator.
- Request up to ৳1,000 of financial help, with an explanation and a supporting document. A new request can only be made once the previous one has been approved or denied.

**Administrators**
- Add, edit and delete institutions in every category.
- Review help requests, open the supporting documents, and approve or deny each one.
- View every donation with the donor's name.

## Screenshots

| | |
|---|---|
| ![Welcome page](docs/screenshots/01-welcome.png) | ![Food institutions](docs/screenshots/03-food.png) |
| Welcome page | Browsing food institutions |
| ![Help request](docs/screenshots/06-help-request.png) | ![Edit profile](docs/screenshots/04-edit-profile.png) |
| A pending help request | Editing a profile |
| ![Admin dashboard](docs/screenshots/07-admin-home.png) | ![Managing requests](docs/screenshots/08-manage-requests.png) |
| Admin dashboard | Reviewing help requests |
| ![Managing institutions](docs/screenshots/09-manage-institutions.png) | ![Donation records](docs/screenshots/10-donations.png) |
| Managing institutions | Donation records |

## Database design

**ER diagram**

![ER diagram](docs/er-diagram.png)

**Relational schema**

![Schema diagram](docs/schema-diagram.png)

- A **user** can be a donator, an underprivileged user or an admin. Admins are marked with an `is_admin` flag, and donators and underprivileged users are stored in their own tables, keyed by the user ID.
- **Institutions** are a disjoint specialisation into food, clothes, health care, education and shelter, each with its own details such as a hotline or agent numbers. The first letter of an institution's ID gives its category (`F`, `C`, `M`, `E` or `S`), which is how each page selects its institutions.
- The full schema, with sample data, is in [`database/schema.sql`](database/schema.sql).

## Tech stack

- **Frontend:** HTML and CSS
- **Backend:** PHP with MySQLi
- **Database:** MySQL / MariaDB
- **Local server:** XAMPP (Apache and MySQL)

## Running it locally

1. Install [XAMPP](https://www.apachefriends.org/) and start **Apache** and **MySQL**.
2. Copy this folder into `xampp/htdocs/` and name it `Human_Rights_Coordination_System`.
3. Open phpMyAdmin (`http://localhost/phpmyadmin`), go to **Import** and import `database/schema.sql`. It creates the database, the tables and some sample institutions.
4. Visit `http://localhost/Human_Rights_Coordination_System/`.

Demo accounts from the sample data:

| Role | Username | Password |
|---|---|---|
| Admin | `admin` | `admin123` |
| User | `demo_user` | `demo123` |

The connection settings (XAMPP's default `root` user with no password) are in `db_connect.php`.

## Project structure

```text
.
├── index.php                     # welcome page
├── signup.php, login.php, logout.php
├── home.php                      # user menu
├── food.php, clothes.php, health_care.php, education.php, shelter.php
├── edit_user.php                 # update profile
├── donator.php                   # make or update a donation
├── underprivileged_request.php   # request financial help
├── admin_home.php                # admin menu
├── admin_manage_requests.php     # approve or deny requests
├── admin_donations.php           # donation records
├── manage_institution.php        # add, edit and delete institutions
├── db_connect.php                # database connection
├── uploads/                      # supporting documents uploaded by users
├── database/schema.sql
└── docs/                         # diagrams and screenshots
```

## Known limitations

This was my first web application, built for learning on a local server. Before it could be used in production it would need:

- **Prepared statements** for every query. User input is currently inserted directly into SQL, which allows SQL injection.
- **Hashed passwords** using `password_hash()` and `password_verify()`, instead of storing them as plain text.
- **Safer file uploads**: checking file types and sizes, and giving uploaded files random names.
- **CSRF protection** on forms, and POST requests instead of links for approving, denying and deleting.
- **Donation history**: a new donation currently replaces the user's previous amount rather than adding a new record.

## Author

Repository maintained by **Fahrim Arabin Farsa** · [Portfolio](https://farsa27.github.io) · [GitHub](https://github.com/Farsa27) · [LinkedIn](https://www.linkedin.com/in/fahrim-farsa-a80b21266/)
