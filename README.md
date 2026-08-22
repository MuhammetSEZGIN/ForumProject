<p align="center"><a href="https://dikbiyikforum.com.tr" target="_blank"><img src="public/images/logo.png" width="400" alt="Logo"></a></p>
ForumProject is a comprehensive forum application developed as part of an internship project. It leverages the Laravel framework to provide a robust platform for online discussions and community engagement. The project includes essential features such as user authentication, post creation and management, commenting, search functionality, and an admin panel for overseeing users and content. Additionally, it includes a Todo app for taking notes and managing tasks. The published website is <a href="https://dikbiyikforum.com.tr" target="_blank">here</a>

## Docker ile çalıştırma

Docker kurulu bir sunucuda projeyi indirdikten sonra tek komut yeterlidir:

```bash
docker compose up -d --build
```

Uygulama `http://SUNUCU_IP:8090` adresinde açılır. `8090` portu, aynı sunucudaki Sesver projesinin kullandığı portlarla çakışmaması için varsayılan seçilmiştir. İlk çalıştırmada uygulama anahtarı oluşturulur, MySQL hazırlanır ve veritabanı migration'ları otomatik uygulanır. Veritabanı, yüklenen dosyalar ve uygulama anahtarı Docker volume'larında kalıcı olarak saklanır.

Servislerin durumunu ve logları kontrol etmek için:

```bash
docker compose ps
docker compose logs -f app web
```

Varsayılan olarak 8090 portu kullanılır. Gerekirse port veya alan adı komutun önüne değişken eklenerek değiştirilebilir:

```bash
APP_PORT=8091 APP_URL=http://forum.example.com:8091 docker compose up -d --build
```

Güncelleme sonrasında aynı `docker compose up -d --build` komutu güvenle tekrar çalıştırılabilir; mevcut veriler silinmez.

## Yerel kurulum

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
