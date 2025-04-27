<p align="center"><a href="https://dikbiyikforum.com.tr" target="_blank"><img src="public/images/logo.png" width="400" alt="Logo"></a></p>
ForumProject is a comprehensive forum application developed as part of an internship project. It leverages the Laravel framework to provide a robust platform for online discussions and community engagement. The project includes essential features such as user authentication, post creation and management, commenting, search functionality, and an admin panel for overseeing users and content. Additionally, it includes a Todo app for taking notes and managing tasks. The published website is <a href="https://dikbiyikforum.com.tr" target="_blank">here</a>

## Notice
This project is currently not hosted online because the AWS server is not in use. To run the application locally, follow the instructions below.

## Installation
Clone the repository:
```
git clone https://github.com/MuhammetSEZGIN/ForumProject.git
```
Navigate to the project directory:
```
cd ForumProject
```
Install dependencies:
```
composer install
```
Set up environment variables:
(Edit .env file for your application)
```
cp .env.example .env
php artisan key:generate
```
Run migrations:
```
php artisan migrate:refresh --seed
```
Start the devolopment server:
```
php artisan serve
```
