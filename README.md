# 🚀 Laravel Job Board

A modern, feature-rich job board application built with Laravel 10, featuring a beautiful UI design with deep blue and golden yellow color scheme. This platform connects job seekers with employers, providing a comprehensive solution for job posting, searching, and application management.

![Job Board Screenshot](https://images.unsplash.com/photo-1486312338219-ce68d2c6f44d?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80)

## ✨ Features

### 🎯 For Job Seekers
- **User Registration & Authentication** - Secure account creation and login
- **Advanced Job Search** - Filter by keywords, location, category, and job type
- **Job Applications** - Apply to jobs with cover letters and resume uploads
- **Bookmark Jobs** - Save interesting positions for later
- **Application Tracking** - Monitor application status and history
- **Profile Management** - Complete profile with skills and experience
- **Resume Management** - Upload and manage multiple resumes
- **Notifications** - Get updates on application status

### 🏢 For Employers
- **Company Profiles** - Showcase company information and culture
- **Job Posting** - Create detailed job listings with requirements
- **Application Management** - Review and manage job applications
- **Candidate Search** - Find suitable candidates for positions
- **Dashboard Analytics** - Track job performance and applications

### 👨‍💼 For Administrators
- **User Management** - Manage job seekers and employers
- **Job Moderation** - Review and approve job postings
- **Category Management** - Organize job categories
- **Platform Analytics** - Monitor platform usage and statistics

## 🎨 Design Features

- **Modern UI/UX** - Clean, professional design with consistent branding
- **Responsive Design** - Works perfectly on desktop, tablet, and mobile
- **Color Scheme** - Deep blue (#1E3A8A) and golden yellow (#FBBF24) theme
- **Interactive Elements** - Smooth animations and hover effects
- **Accessibility** - WCAG compliant with proper contrast ratios

## 🛠️ Technology Stack

- **Backend**: Laravel 10.x
- **Frontend**: Blade Templates, Bootstrap 5, Tailwind CSS
- **Database**: MySQL/PostgreSQL
- **Authentication**: Laravel Breeze
- **Icons**: Font Awesome 6
- **Fonts**: Inter (Google Fonts)
- **File Storage**: Laravel Storage
- **Email**: Laravel Mail

## 📋 Requirements

- PHP >= 8.1
- Composer
- Node.js & NPM
- MySQL >= 5.7 or PostgreSQL >= 10
- Web server (Apache/Nginx)

## 🚀 Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/Oladeji24/JobSearch.git
   cd JobSearch
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install Node.js dependencies**
   ```bash
   npm install
   ```

4. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Configure your database**
   Edit `.env` file with your database credentials:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=job_board
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

6. **Run database migrations and seeders**
   ```bash
   php artisan migrate --seed
   ```

7. **Create storage link**
   ```bash
   php artisan storage:link
   ```

8. **Build assets**
   ```bash
   npm run build
   ```

9. **Start the development server**
   ```bash
   php artisan serve
   ```

Visit `http://localhost:8000` to access the application.

## 👤 Default Admin Account

After running the seeders, you can login with:
- **Email**: admin@jobboard.com
- **Password**: password

## 📁 Project Structure

```
├── app/
│   ├── Http/Controllers/
│   │   ├── Admin/           # Admin panel controllers
│   │   ├── Employer/        # Employer dashboard controllers
│   │   └── JobSeeker/       # Job seeker controllers
│   ├── Models/              # Eloquent models
│   └── Middleware/          # Custom middleware
├── database/
│   ├── migrations/          # Database migrations
│   └── seeders/            # Database seeders
├── resources/
│   ├── views/
│   │   ├── auth/           # Authentication views
│   │   ├── job-seeker/     # Job seeker dashboard
│   │   ├── jobs/           # Job listings
│   │   └── layouts/        # Layout templates
│   └── css/                # Stylesheets
└── routes/
    └── web.php             # Web routes
```

## 🔧 Configuration

### Email Configuration
Configure your email settings in `.env`:
```env
MAIL_MAILER=smtp
MAIL_HOST=your-smtp-host
MAIL_PORT=587
MAIL_USERNAME=your-email
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls
```

### File Storage
For production, configure cloud storage:
```env
FILESYSTEM_DISK=s3
AWS_ACCESS_KEY_ID=your-key
AWS_SECRET_ACCESS_KEY=your-secret
AWS_DEFAULT_REGION=your-region
AWS_BUCKET=your-bucket
```

## 🎯 Key Features Implementation

### Role-Based Access Control
- **Job Seekers**: Can search and apply for jobs
- **Employers**: Can post jobs and manage applications
- **Admins**: Full platform management access

### Advanced Search & Filtering
- Keyword search across job titles and descriptions
- Location-based filtering
- Category and job type filters
- Salary range filtering
- Date posted filtering

### Application Management
- Resume upload and management
- Cover letter submission
- Application status tracking
- Email notifications

### Responsive Design
- Mobile-first approach
- Bootstrap 5 grid system
- Tailwind CSS utilities
- Custom responsive components

## 🚀 Deployment

### Production Setup
1. Set `APP_ENV=production` in `.env`
2. Configure production database
3. Set up proper web server configuration
4. Configure SSL certificate
5. Set up cron jobs for scheduled tasks:
   ```bash
   * * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
   ```

### Optimization Commands
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## 📝 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 🙏 Acknowledgments

- Laravel Framework for the robust backend
- Bootstrap & Tailwind CSS for the responsive design
- Font Awesome for the beautiful icons
- Unsplash for the stunning images

## 📞 Support

If you encounter any issues or have questions, please:
1. Check the [Issues](https://github.com/Oladeji24/JobSearch/issues) page
2. Create a new issue if your problem isn't already reported
3. Provide detailed information about the issue

## 🔄 Changelog

### Version 1.0.0
- Initial release with core job board functionality
- User authentication and role management
- Job posting and application system
- Modern responsive UI design
- Admin panel for platform management

---

**Made with ❤️ by [Oladeji24](https://github.com/Oladeji24)**