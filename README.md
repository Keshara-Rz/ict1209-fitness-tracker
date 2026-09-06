# 🏋️ FitPulse – Fitness Tracker

FitPulse is an interactive **Fitness Tracker Web Application** developed as a mini project for **ICT 1209 – Web Technologies**.

The system helps users manage their fitness activities through a simple and modern web interface. It includes user authentication, a personal dashboard, fitness information, and database connectivity.

## 📌 Project Information

* **Project Name:** FitPulse – Fitness Tracker
* **Module:** ICT 1209 – Web Technologies
* **Batch:** 23/24
* **Project Type:** Mini Project
* **Developed By:** Index Numbers 2772 & 2773

## ✨ Features

* 🔐 User Registration and Login
* 🚪 Secure Logout
* 📊 User Dashboard
* 🏃 Fitness Tracking
* 📈 Dynamic Fitness Statistics
* 📩 Contact Form
* ℹ️ About Page
* 🗄️ MySQL Database Integration
* 📱 Responsive User Interface
* 🎨 Modern Glassmorphism Design
* 🔒 Session-Based User Authentication

## 🛠️ Technologies Used

### Frontend

* HTML5
* CSS3
* JavaScript

### Backend

* PHP

### Database

* MySQL
* PDO

### Development Environment

* XAMPP
* Visual Studio Code
* Git & GitHub

## 📂 Project Structure

```text
fitpulse/
│
├── auth/
│   ├── login.php
│   ├── register.php
│   └── logout.php
│
├── css/
│   └── style.css
│
├── images/
│
├── includes/
│   └── db.php
│
├── js/
│   └── script.js
│
├── about.php
├── contact.php
├── dashboard.php
├── index.php
├── database.sql
└── README.md
```

## ⚙️ Installation

### 1. Install XAMPP

Download and install XAMPP with:

* Apache
* MySQL
* PHP

### 2. Clone the Repository

```bash
git clone https://github.com/Keshara-Rz/ict1209-fitness-tracker.git
```

### 3. Move the Project

Copy the project folder into:

```text
C:\xampp\htdocs\
```

### 4. Start XAMPP

Open XAMPP Control Panel and start:

```text
Apache
MySQL
```

### 5. Create the Database

Open:

```text
http://localhost/phpmyadmin
```

Create a new database and import:

```text
database.sql
```

### 6. Configure the Database

Open:

```text
includes/db.php
```

Update the database connection details if necessary.

Example:

```php
$host = "localhost";
$dbname = "fitpulse";
$username = "root";
$password = "";
```

### 7. Run the Project

Open your browser and go to:

```text
http://localhost/ict1209-fitness-tracker/
```

## 🔑 User Authentication

Users can:

1. Create a new account.
2. Log in using their account.
3. Access the protected dashboard.
4. Manage their fitness information.
5. Log out securely.

## 🗄️ Database

The project uses **MySQL** to store application data.

The database structure is included in:

```text
database.sql
```

Database communication is handled through **PDO** for PHP.

## 👥 Development Methodology

The backend was developed using an **Agile Pair Programming** approach. Team members worked collaboratively on the backend and database integration to maintain consistent development and reduce version-control conflicts.

## 🎯 Project Objectives

The main objectives of FitPulse are:

* To develop a practical fitness tracking website.
* To apply HTML, CSS, JavaScript, PHP, and MySQL knowledge.
* To implement user authentication.
* To connect a web application with a relational database.
* To create a simple and user-friendly fitness platform.

## 🚀 Future Improvements

Future versions could include:

* Fitness progress charts
* Daily workout plans
* BMI calculator
* Calorie tracking
* Exercise recommendations
* User profile customization
* Mobile-friendly improvements
* More detailed fitness reports

## 📄 License

This project was developed for **educational purposes** as part of the ICT 1209 Web Technologies mini project.

## 👨‍💻 Contributors

* **Index No. 2772**
* **Index No. 2773**

---

⭐ **FitPulse – Track Your Fitness, Improve Your Life.**
