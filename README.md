# Structify - Laravel MDSR Generator: Build Scalable Laravel Apps Faster 🚀
**Structify** is the ultimate Laravel package for developers who want to build scalable, maintainable, and clean applications. With just one command, Structify generates Model, DTO, Service, and Repository (MDSR) files for your entities, saving you hours of repetitive coding. Whether you're building a small project or a large enterprise application, Structify ensures your codebase follows best practices and is ready to scale.
<hr />

## Why Structify? 🤔
- **Speed Up Development:** Generate all necessary files for an entity in seconds.
- **Follow Best Practices:** Encourages separation of concerns, SOLID principles, and clean architecture.
- **Automate Repetitive Tasks:** No more manual creation of models, DTOs, services, or repositories.
- **Customizable:** Modify stubs to fit your coding standards.
<hr />

## Key Features ✨
- **One Command, Multiple Files:** Generate Model, DTO, Service, and Repository files with a single command.
- **Automatic Migration Creation:** Models come with their corresponding migration files.
- **Service Provider Bindings:** Automatically bind interfaces to their implementations in the MdsrServiceProvider.
- **Custom Stubs:** Easily customize the stubs to match your project's coding standards.
- **Scalable Architecture:** Designed to help you build applications that grow with your business.
<hr />

## Installation 📦
Install Structify via Composer:
```bash
composer require mrtolouei/structify
```
<hr />

## How to Use Structify 🛠️
### Generate MDSR Files
To generate files for a new entity, run the following command:
```bash
php artisan structify:make-mdsr {EntityName}
```
Replace `{EntityName}` with the name of your entity (e.g., User, Product, Order). Structify will create:
- **Model:** `App/Models/{EntityName}.php`
- **DTO:** `App/Dto/{EntityName}Dto.php`
- **Repository Interface:** `App/Repositories/Interfaces/{EntityName}RepositoryInterface.php`
- **Repository:** `App/Repositories/{EntityName}Repository.php`
- **Service Interface:** `App/Services/Interfaces/{EntityName}ServiceInterface.php`
- **Service:** `App/Services/{EntityName}Service.php`

It will also:
- Create a migration file for the model.
- Update the MdsrServiceProvider to bind interfaces to their implementations.
<hr />

## Example: Generate Files for a Product Entity
Run the following command:
```bash
php artisan structify:make-mdsr Product
```
This will generate:
- `App/Models/Product.php`
- `App/Dto/ProductDto.php`
- `App/Repositories/Interfaces/ProductRepositoryInterface.php`
- `App/Repositories/ProductRepository.php`
- `App/Services/Interfaces/ProductServiceInterface.php`
- `App/Services/ProductService.php`

It will also create a migration file for the Product model and update the MdsrServiceProvider with the necessary bindings.
<hr />

## Customize Stubs 🎨
Structify uses stubs to generate files. You can customize these stubs to match your project's coding standards. To publish the stubs, run:
```bash
php artisan vendor:publish --tag=structify-stubs
```
This will copy the stubs to the `stubs/mdsr` directory in your project. Modify them as needed to fit your coding style.
<hr />

## Service Provider Bindings 🔗
Structify automatically updates the `MdsrServiceProvider` to bind repository and service interfaces to their implementations. For example:
```php
$this->app->bind(\App\Repositories\Interfaces\ProductRepositoryInterface::class, \App\Repositories\ProductRepository::class);
$this->app->bind(\App\Services\Interfaces\ProductServiceInterface::class, \App\Services\ProductService::class);
```
<hr />

## Why Structify is SEO-Friendly 🌐
- **Clean Code:** Structify promotes clean, modular code, which improves your application's performance—a key factor for SEO.
- **Scalability:** Build applications that can handle growth without compromising performance.
- **Maintainability:** Well-structured code is easier to maintain and optimize for search engines.
<hr />

## Contributing 🤝
We love contributions! If you'd like to contribute to Structify, follow these steps:

1. Fork the repository.
2. Create a new branch for your feature or bugfix.
3. Submit a pull request.
<hr />

## License 📄
Structify is open-source software licensed under the [MIT license](https://opensource.org/licenses/MIT).
<hr />

## Ready to Supercharge Your Laravel Development? 🚀
Install Structify today and experience the power of automated, scalable, and clean code generation. Happy coding! 🎉







