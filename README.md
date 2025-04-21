Project Title:
- containerized event management system

Project Idea:
- A simple system for managing and recording attendance at events. It allows users to view and register for available events, and allows the admin to add, edit, and delete events, as well as monitor registrations.

Project Significance:
- A practical example of applying Backend Development concepts using PHP and MySQL.
- It uses Docker to simplify setup and deployment, making it easily installable on any device without complicated steps.
- This is a great project to include in your portfolio as proof of your skills in database handling, authentication, and containerization.

Requirements:
- Docker
- Docker Compose
- Git (optinal)

Technologies Used:
- Native PHP 
- MySQL 5.7
- Docker & Docker Compose
- Composer
- HTML
- CSS
- Bash scripts
- Dotenv for environment variable management
- mysqldump for database backups

Installation and Running Steps:
Open the terminal and clone the project:

- git clone https://github.com/Ahmedlebshten/containerized_event_management_system.git
- cd containerized_event_management_system

Run the entire project:

- bash scripts/start.sh

Database Backup (Optional):
At any time, you can create a backup of the database with:

- bash scripts/backup_db.sh

