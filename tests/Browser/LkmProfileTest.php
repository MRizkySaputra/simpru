<?php
namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LkmProfileTest extends DuskTestCase {
    use DatabaseMigrations;

    public function test_TC009_ubah_profil_berhasil() {
        $user = User::factory()->create(['name' => 'Nama Lama']);
        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                    ->visit('/user/profil')
                    ->waitFor('input[name="name"]', 5) // Pastikan form sudah ter-load
                    ->clear('name') // Hapus nama lama dulu sebelum ketik nama baru
                    ->type('name', 'Nama Baru')
                    ->click('button[type="submit"]')
                    ->waitForText('data berhasil di ubah', 5) // Tunggu alert/notif muncul
                    ->assertSee('data berhasil di ubah');
        });
    }
}