# Teklif Yönetim Paneli

Laravel ve MySQL ile geliştirilmiş, müşteri ve teklif süreçlerini kolaylaştırmak için tasarlanmış web tabanlı bir yönetim paneli.

Uygulama; müşteri kayıtlarının yönetilmesini, dinamik teklifler oluşturulmasını ve tekliflerin PDF veya Excel formatında dışa aktarılmasını sağlar. **Progressive Web App (PWA)** desteği sayesinde mobil cihazlarda uygulama benzeri bir kullanım deneyimi sunar.

## ✨ Özellikler

- 🔐 **Kimlik Doğrulama:** Güvenli giriş, çıkış ve hesap bilgilerini güncelleme.
- 👥 **Müşteri Yönetimi:** Müşteri ekleme, görüntüleme, düzenleme ve silme.
- 📄 **Teklif Yönetimi:** Müşterilere özel teklif oluşturma ve teklif kalemlerini yönetme.
- 🧮 **Otomatik Hesaplama:** Ara toplam, KDV ve genel toplamın otomatik hesaplanması.
- 📑 **PDF Dışa Aktarma:** DomPDF ile düzenli ve markalı teklif belgeleri oluşturma.
- 📊 **Excel Dışa Aktarma:** Teklif bilgilerini Excel uyumlu formatta dışa aktarma.
- 📱 **PWA Desteği:** Manifest ve service worker ile uygulama benzeri mobil deneyim.
- 📱 **Responsive Arayüz:** Farklı ekran boyutlarına uyum sağlayan tasarım.
- ⚙️ **Hesap Ayarları:** Ad, e-posta ve şifre güncelleme.

## 🛠️ Teknolojiler

- **Backend:** PHP, Laravel
- **Veritabanı:** MySQL
- **Frontend:** Blade, JavaScript, Tailwind CSS
- **Derleme:** Vite
- **Kimlik Doğrulama:** Laravel Fortify
- **PDF:** DomPDF
- **PWA:** Web App Manifest, Service Worker

## 🚀 Kurulum

### Gereksinimler

- PHP ve Composer
- Node.js ve npm
- MySQL
- Laravel sürümüne uygun PHP eklentileri

### 1. Projeyi klonlayın

```bash
git clone https://github.com/xkayasena/teklif-yonetim-paneli.git
cd teklif-yonetim-paneli
```

### 2. Bağımlılıkları yükleyin

```bash
composer install
npm install
```

### 3. Ortam dosyasını oluşturun

```bash
cp .env.example .env
php artisan key:generate
```

Windows PowerShell kullanıyorsanız `.env.example` dosyasını `.env` olarak kopyalayabilirsiniz.

### 4. Veritabanını yapılandırın

`.env` dosyasındaki veritabanı ayarlarını kendi MySQL bilgilerinizle güncelleyin:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=teklif_yonetim
DB_USERNAME=root
DB_PASSWORD=
```

Veritabanını oluşturduktan sonra migration'ları çalıştırın:

```bash
php artisan migrate --seed
```

### 5. Frontend dosyalarını derleyin

```bash
npm run build
```

### 6. Uygulamayı başlatın

```bash
php artisan serve
```

Uygulamaya `http://127.0.0.1:8000` adresinden erişebilirsiniz.

## 🔒 Güvenlik

- Gerçek ortam bilgilerinizi `.env` dosyasında tutun.
- `.env` dosyasını GitHub'a yüklemeyin.
- Üretim ortamında güçlü veritabanı parolaları kullanın.
- Yönetici hesabı ve ilk giriş bilgilerini güvenli şekilde yapılandırın.

## 📌 Proje Hakkında

Bu proje; Laravel ile backend geliştirme, ilişkisel veritabanı tasarımı, kimlik doğrulama, belge oluşturma ve PWA entegrasyonu konularında uygulamalı deneyim kazanmak amacıyla geliştirilmiştir.

---

**Geliştirici:** Sena

**Repository:** [teklif-yonetim-paneli](https://github.com/xkayasena/teklif-yonetim-paneli)
