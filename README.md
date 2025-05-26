# Scoring System app

## Overview
This project implements a scoring system using the LAMP stack (Linux, Apache, MySQL, PHP). It includes an admin panel for judge management, a judge portal to assign scores to users, and a public scoreboard to display user rankings.

## Setup Instructions
1. **Install XAMPP**:
   - Download and install XAMPP from [apachefriends.org](https://www.apachefriends.org/).
   - Start Apache and MySQL services.
   **Start Apache and MySQL Services**:
   - Open a terminal and navigate to the XAMPP directory:
     ```bash
     cd /opt/lampp
     sudo ./lampp start
     ```

2. **Database Setup**:
   - Open phpMyAdmin (`http://localhost/phpmyadmin`).
   - Create a database named `scoreapp`.
   - Import the `db.sql` file or run the SQL commands to create tables and insert sample data.

3. **Project Files**:
   - Copy the project folder to `htdocs/scoreapp`.
   - Access the project via `http://localhost/score-app`.

4. **Access Interfaces**:
   - Public Scoreboard: `http://localhost/ctfroom/public`
   - Admin Panel: `http://localhost/ctfroom/admin`
   - Judge Portal: `http://localhost/ctfroom/judge`

## Database Schema
- **users**: Stores event participants (`id`, `username`, `display_name`).
- **judges**: Stores judges (`id`, `username`, `display_name`).
- **scores**: Stores scores (`id`, `user_id`, `judge_id`, `score`).

## Assumptions
- No login is required for admin or judge interfaces.
- Sample users are pre-inserted.
- The scoreboard auto-refreshes every 10 seconds using a meta tag.

## Design Choices
- **Database**: Used a normalized schema with foreign keys to maintain data integrity.
- **PHP**: Used PDO for secure database interactions and prepared statements to prevent SQL injection.
- **Frontend**: Kept the UI simple with basic HTML/CSS for usability. Added auto-refresh to the scoreboard.
- **Error Handling**: Basic validation for scores (1-100) and form inputs.


## Publicly Accessible Link
- Since this is a local project, deploy it to a hosting service (e.g., GitHub Pages for static files or a PHP hosting service) to get a public URL.
- Alternatively, use a tool like ngrok to expose your local server: `ngrok http 80`.