> [!WARNING]
> If you want to contribute, this main branch is a protected branch, so you can't commit directly to the main branch. Instead you must make a [**Pull request**](https://github.com/Khip01/MAGO/pulls) to this main branch.

# 🏢 MAGO 👷
Magang On The GO - Information Technology Student Internship Information System

## ℹ️ Project Info
- **Laravel v10.3**
- **Filament v3.3**
- **Spatie** v6

## 👷 Instruction
### 📚 Preparation
1. **Clone this repo**
2. **Set up the .env**
3. **Set up the MySQL database** _(*create database only, ex: mago_db)_
4. **Run** `php artisan key:generate`
5. **Run** `php artisan serve`
> [!CAUTION]
> If you encounter the error: <br>
> `Warning: require(...\MAGO/vendor/autoload.php): Failed to open stream: No such file or directory in ...\MAGO\artisan on line 18
> Fatal error: Uncaught Error: Failed to open required '...\MAGO/vendor/autoload.php' (include_path='.;C:/laragon/etc/php/pear') in ...\MAGO\artisan:18
> Stack trace:
> #0 {main}
>   thrown in ...\MAGO\artisan on line 18` <br><br>
> Just run `composer install`

### 👤 Auth - Login
1. **Don't forget to migrate and seed your db.** _(run: `php artisan migrate:fresh --seed` to run your fresh migration and seeded database)_ 
2. **Go to** `/login` ex: => `localhost:8000/login`
3. **In this project there are 3 roles:**
   - Admin
   - Mahasiswa
   - Dosen Pembimbing
5. **Input your credential. Some default credentials are already made in the seeder file, such as** `seeders/UserSeeder.php`, `seeders/MahasiswaSeeder.php`, `seeders/AdminSeeder.php`, `seeders/DosenPembimbingSeeder.php`
> [!NOTE]
> When you provide credentials on the login page, the web will immediately redirect you to the filament panel according to the role of the credentials of the user who is currently logged in.
