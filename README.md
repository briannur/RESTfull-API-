<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# RESTfull-API-
Repository ini digunakan untuk menyelesaikan tugas Restful API (PHP dan Database) mata kuliah Desain dan Pemrograman WEB 

## Tools:
1. Xampp
2. Composer
3. Laravel
4. Kode editor
5. Postman ataupun aplikasi SOAP dan REST lainnya
## Membuat project baru menggunakan laravel
Untuk membuat project baru, buka command prompt lalu arahkan ke direktori xampp/htdocs/[namafolder]. Setelah itu, ketikan kode berikut:

```composer create-project –prefer-dist Laravel/Laravel [nama_direktori_project]```

atau

```composer create-project --prefer-dist laravel/laravel:^7.0 [namaproject]```

## Membuat database baru
Aktifkan xampp terlebih dahulu, kemudian buat database baru anda.

## Atur database
Buka folder projek Laravel anda, lalu terdapat file dengan nama .env, buka file .env menggunakan kode editor kemudian edit sesuai database yang sudah dibuat:

```DB_DATABASE = 'db_akademik'```

## Membuat file migrasi
Buka command prompt, lalu ketikkan kode berikut:

php artisan make:migration create_mahasiswa

Jika sudah, buka project anda lalu buka folder database -> migration -> buka file yang baru saja dibuat. Lalu edit seperti berikut:

```
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMahasiswaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mahasiswa', function (Blueprint $table) {
            $table->bigIncrements('NIM');
            $table->string('nama');
            $table->char('gender');
            $table->string('ttl');
            $table->string('prodi');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mahasiswa');
    }
}
```

Kemudian kembali ke command prompt dan ketik kode berikut:

```php artisan migrate```

Jika berhasil maka database mahasiswa akan terupdate sesuai dengan yang sudah dibuat.
## Membuat Controller
Sebagai contoh, untuk membuat controller ketik kode berikut pada command prompt:

```php artisan make:controller apicontroller```

File controller dapat di akses dengan membuka folder app -> Http -> Controllers
## Membuat model
Contoh pembuatan model, ketik kode berikut pada command prompt:


```php artisan make:model MahasiswaModel```

File controller dapat di akses dengan membuka folder app.
Jika sudah, buka file model yang baru dibuat lalu edit seperti berikut:

```
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MahasiswaModel extends Model
{
    protected $table = 'mahasiswa';

    protected $primaryKey = 'NIM';
}

```

## Membuat Restfull API
### 1. GET
Buka file apicontroller, kemudian tambahkan kode berikut agar dapat mengakses model:

```
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MahasiswaModel;
```

Selanjutnya, buat method function untuk mengambil data dari database. Ketik kode berikut:

```
public function get_data(){
  return response()->json(MahasiswaModel::all(),200);
}
```

Kemudian buat url. Buka folder routes -> api.php lalu tambahkan kode berikut:

```Route::get('mahasiswa', 'App\Http\Controllers\apicontroller@get_all_mahasiswa');```

Jalankan local server Laravel dengan mengetikkan kode berikut:

```php artisan serve```

Jika sudah buka browser dan arahkan menuju url localserver tersebut ditambah dengan url dari route yaitu /api dan tambahkan route yang kalian buat. Contohnya seperti ini:

```127.0.0.1:8000/api/mahasiswa```

Jika berhasil maka akan muncul data array yang berhasil diakses dari database.
### 2. POST
Buat function pada apicontroller untuk melakukan action post. Berikut kodenya:

```
public function insert_new_mahasiswa(Request $request){
        $insert_mahasiswa = new MahasiswaModel;
        $insert_mahasiswa->nama = $request->Nama_Mahasiswa;
        $insert_mahasiswa->gender = $request->Jenis_Kelamin;
        $insert_mahasiswa->ttl = $request->Tempat_Tanggal_Lahir;
        $insert_mahasiswa->prodi = $request->Program_Studi;
        $insert_mahasiswa->save();
        return response([
            'status' => 'SUCCESS',
            'message' => 'Data mahasiswa ditambahkan',
            'data' => $insert_mahasiswa
        ], 200);
    }
 ```

Kemudian tambahkan url. Buka folder routes -> api.php dan tambahkan kode berikut:

```Route::post('mahasiswa/new_mahasiswa', 'App\Http\Controllers\apicontroller@insert_new_mahasiswa');```

Terakhir, untuk menguji fungsi tersebut, kita perlu menggunakan Postman.
Buka postman, lalu pilih method POST dan masukkan url anda, seperti berikut:

http://127.0.0.1:8000/api/mahasiswa/new_mahasiswa

### 3. PUT
Buat function pada apicontroller untuk melakukan action put. Berikut kodenya:

```
public function update_data_mahasiswa(Request $request, $id){
        $checktb = MahasiswaModel::firstWhere('NIM', $nim);
        if($checktb){
            $data_mahasiswa = MahasiswaModel::find($nim);
            $data_mahasiswa->nama = $request->Nama_Mahasiswa;
            $data_mahasiswa->gender = $request->Jenis_Kelamin;
            $data_mahasiswa->ttl = $request->Tempat_Tanggal_Lahir;
            $data_mahasiswa->prodi = $request->Program_Studi;
            $data_mahasiswa->save();
            return response([
                'status' => 'SUCCESS',
                'message' => 'Data mahasiswa diperbaharui',
                'update-data' => $data_mahasiswa
            ], 200);
        } else {
            return response([
                'status' => 'ERROR',
                'message' => 'Data mahasiswa tidak ditemukan'
            ], 404);
        }
    }
```
  
Kemudian tambahkan url. Buka folder routes -> api.php dan tambahkan kode berikut:

```Route::put('mahasiswa/update/{NIM}', 'App\Http\Controllers\apicontroller@update_data_mahasiswa');```

Terakhir, untuk menguji fungsi tersebut, kita perlu menggunakan Postman.
Buka postman, lalu pilih method PUT dan masukkan url anda, seperti contoh berikut akan mengupdate kode nim nomor 8:

http://127.0.0.1:8000/api/mahasiswa/update/8

### 4. DELETE
Buat function pada apicontroller untuk melakukan action put. Berikut kodenya:

```
public function delete_data_mahasiswa($nim){
        $checktb = MahasiswaModel::firstWhere('NIM', $nim);
        if($checktb){
            MahasiswaModel::destroy($nim);
            return response([
                'status' => 'SUCCESS',
                'message' => 'Data mahasiswa dihapus'
            ], 200);
        } else {
            return response([
                'status' => 'ERROR',
                'message' => 'Data mahasiswa tidak ditemukan'
            ], 404);
        }
    }
```
  
Kemudian tambahkan url. Buka folder routes -> api.php dan tambahkan kode berikut:

```Route::delete('mahasiswa/delete/{NIM}', 'App\Http\Controllers\apicontroller@delete_data_mahasiswa');```

Terakhir, untuk menguji fungsi tersebut, kita perlu menggunakan Postman.
Buka postman, lalu pilih method DELETE dan masukkan url anda, seperti contoh berikut akan menghapusb kode nim nomor 8:

http://127.0.0.1:8000/api/mahasiswa/delete/8
