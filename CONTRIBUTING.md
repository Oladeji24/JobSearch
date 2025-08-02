# Contributing to Laravel Job Board

Thank you for considering contributing to the Laravel Job Board project! We welcome contributions from the community.

## How to Contribute

### Reporting Bugs

1. **Check existing issues** - Before creating a new issue, please check if the bug has already been reported.
2. **Create a detailed issue** - Include:
   - Clear description of the bug
   - Steps to reproduce
   - Expected vs actual behavior
   - Screenshots if applicable
   - Environment details (PHP version, Laravel version, etc.)

### Suggesting Features

1. **Check existing feature requests** - Look through existing issues and discussions.
2. **Create a feature request** - Include:
   - Clear description of the feature
   - Use case and benefits
   - Possible implementation approach

### Code Contributions

1. **Fork the repository**
2. **Create a feature branch**
   ```bash
   git checkout -b feature/your-feature-name
   ```
3. **Make your changes**
   - Follow PSR-12 coding standards
   - Write tests for new functionality
   - Update documentation if needed
4. **Test your changes**
   ```bash
   php artisan test
   ```
5. **Commit your changes**
   ```bash
   git commit -m "Add: your feature description"
   ```
6. **Push to your fork**
   ```bash
   git push origin feature/your-feature-name
   ```
7. **Create a Pull Request**

## Development Setup

1. **Clone your fork**
   ```bash
   git clone https://github.com/your-username/JobSearch.git
   cd JobSearch
   ```

2. **Install dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Set up environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Set up database**
   ```bash
   php artisan migrate --seed
   ```

5. **Build assets**
   ```bash
   npm run dev
   ```

## Coding Standards

- Follow PSR-12 coding standards
- Use meaningful variable and function names
- Write clear comments for complex logic
- Keep functions small and focused
- Write tests for new features

## Pull Request Guidelines

- **One feature per PR** - Keep pull requests focused on a single feature or bug fix
- **Clear description** - Explain what your PR does and why
- **Update tests** - Add or update tests as needed
- **Update documentation** - Update README or other docs if needed
- **Follow the template** - Use the PR template when creating your request

## Code Review Process

1. All PRs require at least one review
2. Address feedback promptly
3. Keep discussions respectful and constructive
4. Be open to suggestions and improvements

## Questions?

If you have questions about contributing, feel free to:
- Open an issue for discussion
- Contact the maintainers
- Join our community discussions

Thank you for contributing! 🚀