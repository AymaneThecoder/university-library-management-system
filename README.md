# Library Management System - Web Application

This web application is designed to serve as a Library Management System for a university library. It allows library members to perform various tasks online, such as borrowing books, accessing the catalog of available documents, and utilizing features like reservation and loan renewal. The application also provides a user-friendly interface for librarians to manage library members, loans, returns, and document inventory.

## Features

- User Registration: Library members can create an account by providing their personal details and login credentials.

- Document Catalog: Members can browse the catalog to search for books, view details, and check availability.

- Online Borrowing: Members can request to borrow books online by selecting the desired documents and specifying the loan duration.

- Reservation: If a book is currently unavailable, members can reserve it and receive a notification when it becomes available.

- Loan Renewal: Members can extend the loan period for borrowed books, subject to certain conditions.

- Loan History: Members can view their loan history, including details of borrowed and returned books.

- Notifications: Automated notifications are sent to members to remind them of upcoming due dates and overdue returns.

- Administrative Dashboard: Librarians have access to a dashboard to manage library members, loans, returns, and document inventory.

- Fine Calculation: The system automatically calculates fines for overdue returns and generates receipts for payment.

- Print Receipt: Members can print receipts for loan transactions and fine payments.

## Technology Stack

The application is developed using the following technologies:

- Front-end: HTML, CSS, JavaScript
- Back-end: PHP
- Database: MySQL

## Setup Instructions

1. Clone the repository: `git clone <repository-url>`
2. Create a MySQL database and import the provided database schema.
3. Configure the database connection settings in the `config.php` file.
4. Host the application on a PHP-enabled server.
5. Access the application through the browser.

## Future Enhancements

- Integration with an online payment gateway for fine payments.
- Integration with a barcode scanner for document management.
- Integration with a notification system for sending reminders and notifications.

Feel free to contribute to the project by submitting bug reports, feature requests, or pull requests.

## License

This project is licensed under the [MIT License](https://opensource.org/licenses/MIT).

