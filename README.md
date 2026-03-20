# Project Management System

A simple PHP-based project management system with role-based access control for admins and staff.

## Features
- **Admin Dashboard**: Create projects and assign staff members
- **Staff Dashboard**: View assigned projects and add tasks
- **Task Management**: Create, view, and track tasks with status updates
- **Role-Based Access Control**: Different interfaces for Admin and Staff roles
- **Responsive Design**: Clean and intuitive user interface

## Installation
1. Create a MySQL database named `project_management`
2. Import the `database.sql` file to set up the database schema
3. Update database credentials in `config.php` if needed
4. Place files in your web server directory
5. Access the application at `http://localhost/project-management`

## File Structure
- `config.php` - Database connection and configuration
- `database.sql` - MySQL database schema
- `register.php` - User registration page
- `login.php` - User login page
- `logout.php` - User session termination
- `admin_dashboard.php` - Admin interface for project management
- `create_project.php` - Create new projects
- `assign_staff.php` - Assign staff members to projects
- `staff_dashboard.php` - Staff interface showing assigned projects
- `add_task.php` - Add tasks to projects
- `view_project.php` - View project details and tasks
- `style.css` - CSS styling for the application

## Database Schema
### Users Table
- id (Primary Key)
- username (Unique)
- password
- email (Unique)
- role (admin or staff)
- created_at

### Projects Table
- id (Primary Key)
- name
- description
- created_by (Foreign Key to Users)
- created_at

### Project Assignments Table
- id (Primary Key)
- project_id (Foreign Key to Projects)
- user_id (Foreign Key to Users)
- assigned_at

### Tasks Table
- id (Primary Key)
- project_id (Foreign Key to Projects)
- assigned_to (Foreign Key to Users)
- title
- description
- status (pending, in_progress, completed)
- due_date
- created_at
- updated_at

## User Roles
### Admin
- Create new projects
- Assign staff members to projects
- View all projects they created
- Manage project workflows

### Staff
- View assigned projects
- Add tasks to assigned projects
- Update task status
- View project details

## Getting Started
1. Register an account as Admin
2. Create a new project
3. Assign staff members to the project
4. Staff can then add tasks and manage their workload

## Security Notes
- Implement proper password hashing (use password_hash in production)
- Validate and sanitize all user inputs
- Use prepared statements for database queries
- Implement CSRF protection
- Use HTTPS in production

## Future Enhancements
- Email notifications
- Task comments and collaboration features
- File upload support
- Reporting and analytics
- Advanced permission management