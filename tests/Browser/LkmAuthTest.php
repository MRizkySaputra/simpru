<?php
namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LkmAuthTest extends DuskTestCase {
    use DatabaseMigrations;

    public function test_TC001_registrasi_berhasil() {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                    ->waitFor('input[name="name"]', 5) // Tunggu input nama muncul maksimal 5 detik
                    ->type('name', 'Mahasiswa Uji')
                    ->type('email', 'uji@mail.com')
                    ->type('nomor_induk', '123456')
                    ->select('role', 'mahasiswa')
                    ->click('button[onclick="nextStep()"]')
                    ->pause(1000) // WAJIB ADA: Jeda untuk animasi pergantian form (nextStep)
                    ->type('password', 'password123')
                    ->type('password_confirmation', 'password123')
                    ->click('button[type="submit"]') // Lebih kebal error dibanding press()
                    ->waitForText('registrasi berhasil', 5) // Tunggu notifikasi muncul
                    ->assertSee('registrasi berhasil');
        });
    }

    public function test_TC002_registrasi_gagal_nama_kosong() {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                    ->waitFor('input[name="name"]', 5)
                    ->clear('name') 
                    ->click('button[type="submit"]')
                    ->waitForText('inputan tidak boleh kosong', 5)
                    ->assertSee('inputan tidak boleh kosong');
        });
    }

    public function test_TC003_login_berhasil() {
        User::factory()->create(['email' => 'valid@mail.com', 'password' => bcrypt('benar123')]);
        
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->waitFor('input[name="email"]', 5)
                    ->type('email', 'valid@mail.com')
                    ->type('password', 'benar123')
                    ->click('button[type="submit"]')
                    ->waitForLocation('/user/dashboard', 5) // Tunggu sampai URL berubah
                    ->assertPathIs('/user/dashboard');
        });
    }

    public function test_TC004_login_gagal() {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->waitFor('input[name="email"]', 5)
                    ->type('email', 'valid@mail.com')
                    ->type('password', 'salah123')
                    ->click('button[type="submit"]')
                    ->waitForText('NIM/NIP atau kata sandi salah!', 5)
                    ->assertSee('NIM/NIP atau kata sandi salah!');
        });
    }
}