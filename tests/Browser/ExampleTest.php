<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use PHPUnit\Framework\Attributes\Test;

class ExampleTest extends DuskTestCase
{
    /**
     * A basic browser test example.
     */
    #[Test]
    public function test_halaman_login_bisa_diakses(): void
    {
        $this->browse(function (Browser $browser) {
            // 1. Kunjungi halaman login
            $browser->visit('/login');

            // 2. Tunggu elemen utama muncul (menangani masalah StaleElement)
            // Kita tunggu teks "SIMPRU" muncul maksimal 10 detik
            $browser->waitForText('SIMPRU', 10);

            // 3. Pastikan teks yang dicari memang ada
            $browser->assertSee('SIMPRU')
                    ->assertSee('NAMA PENGGUNA')
                    ->assertSee('KATA SANDI');
            
            // 4. (Opsional) Jika ingin tes login, uncomment baris di bawah ini
            // $browser->type('username', 'admin')
            //         ->type('password', 'password123')
            //         ->press('Masuk')
            //         ->waitForLocation('/dashboard'); // Sesuaikan dengan route tujuan setelah login
        });
    }
}