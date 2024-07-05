


Installation
step1.Clone the repo

git clone https://github.com/sreenath009/Laravelcp360.git
Navigate into the project directory

step2.composer install
Run composer install command

step3:Generate application key

php artisan key:generate

step4: Edit .env file and configure database settings


DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=interview
DB_USERNAME=root
DB_PASSWORD=

step5:Run database migrations

php artisan migrate

step6: Seed the database 

php artisan db:seed

step7: Install npm dependencies

npm install

step8:Compile assets

npm run dev

step9: Setting Up Authentication

step9.1:Install Laravel UI package

 composer require laravel/ui

step9.2:Generate frontend scaffolding (Vue.js)

php artisan ui vue --auth

step9.3:Running Queues

php artisan queue:work

step9.4:Open your .env file and configure the following SMTP settings:

MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=username
MAIL_PASSWORD=password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=example_email@example.com
MAIL_FROM_NAME="${APP_NAME}"

step 9.5: Open the newly created job file (app/Jobs/FormCreatedJob.php) and add the following logic inside the handle method:
 Mail::to('sreenathsastha009@gmail.com')->send(new FormCreated($this->form));
 Replace 'sreenathsastha009@gmail.com' with the email address where you want to send the notification.

step10: Run php artisan serve

http://localhost:8000