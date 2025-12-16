# Ruang Jurnal: Journal Management System 📚

This project is a web-based journal management system designed to facilitate the sharing and appreciation of academic journals within a specific community (e.g., a university). It provides user authentication, faculty-based journal filtering, like functionality, and profile management features. The system allows users to register, log in, view journals, filter journals by faculty, like journals, and manage their profiles (including profile picture and bio).

## 🚀 Key Features

- **User Authentication:** Secure login and registration system to manage user access.
- **Faculty Filtering:** Allows users to filter journals based on faculty.
- **Journal Display:** Displays journals with details and like counts.
- **Like Functionality:** Users can like journals, and the system tracks the number of likes.
- **Profile Management:** Users can update their profile picture and bio.
- **Session Management:** Maintains user sessions for a seamless experience.
- **Email Validation:** Ensures that users register with a valid academic email address.

## 🛠️ Tech Stack

- **Frontend:**
    - HTML
    - CSS
    - Bootstrap CSS
- **Backend:**
    - PHP
- **Database:**
    - MySQL
- **Security:**
    - OpenSSL (for encryption - **Note: AES-128-ECB is used, which is highly discouraged. See security notes below.**)
- **Other:**
    - PHP session management

## 📦 Getting Started

Follow these instructions to set up the project locally.

### Prerequisites

- PHP 7.0 or higher
- MySQL
- Web server (e.g., Apache, Nginx)
- OpenSSL extension for PHP

### Installation

1.  **Clone the repository:**
    ```bash
    git clone <repository_url>
    cd <project_directory>
    ```

2.  **Import the database:**
    - Create a new database in MySQL.
    - Import the provided SQL dump file (if available) into the database.  If not, create `users` and `journals` tables with appropriate columns.  The `likes` table is also required.

3.  **Configure the database connection:**
    - Edit `config.php` with your database credentials:
    ```php
    <?php
    $servername = "localhost";
    $username = "your_username";
    $password = "your_password";
    $dbname = "your_database_name";

    $conn = mysqli_connect($servername, $username, $password, $dbname);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $encryption_key = "YourSecretEncryptionKey"; // Change this!
    ?>
    ```
    **Important:** Change `YourSecretEncryptionKey` to a strong, randomly generated key.

4.  **Set up the `profile_pictures` directory:**
    - Create a directory named `profile_pictures` in the root of the project to store user profile pictures. Ensure the web server has write permissions to this directory.

### Running Locally

1.  **Start your web server (e.g., Apache, Nginx).**
2.  **Place the project files in the web server's document root (e.g., `/var/www/html/`).**
3.  **Access the application through your web browser (e.g., `http://localhost/<project_directory>/home.php`).**

## 💻 Usage

1.  **Registration:** Navigate to `register.php` to create a new account.
2.  **Login:** Navigate to `login.php` to log in with your credentials.
3.  **Homepage:** After logging in, you will be redirected to `index.php`, where you can view and filter journals.
4.  **Profile:** Access `profile.php` to manage your profile picture and bio.
5.  **Liking Journals:** Click the like button on a journal to register your appreciation.

## 📂 Project Structure

```
📂 journal-management-system
├── 📄 index.php          # Main page: displays journals, handles authentication and faculty filtering
├── 📄 config.php         # Database connection and encryption functions
├── 📄 functions.php      # Contains reusable functions like countLikes()
├── 📄 login.php          # Handles user login functionality
├── 📄 register.php       # Handles user registration functionality
├── 📄 profile.php        # Displays and manages user profile information
├── 📄 home.php           # Homepage with navigation links
├── 📂 profile_pictures/  # Directory to store user profile pictures
├── 📄 style.css          # Custom CSS file for additional styling
└── 📄 asetfoto/         # Directory containing images
    └── 📄 homepage.png   # Background image for homepage
```
## 🤝 Contributing

Contributions are welcome! Please follow these steps:

1.  Fork the repository.
2.  Create a new branch for your feature or bug fix.
3.  Make your changes and commit them with descriptive messages.
4.  Submit a pull request.

## 📬 Contact

If you have any questions or suggestions, feel free to contact me at [amaliyahamel0304@gmail.com](mailto:amaliyahamel0304@gmail.com).

## 💖 Thanks

Thank you for using and contributing to the Journal Management System!

