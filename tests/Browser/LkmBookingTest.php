<?php
namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LkmBookingTest extends DuskTestCase {
    use DatabaseMigrations;

    public function test_TC005_ajukan_ruangan_berhasil() {
        $user = User::factory()->create();
        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                    ->visit('/user/ajukan-detail?roomName=Auditorium')
                    ->waitFor('input[name="nama_kegiatan"]', 5)
                    ->type('nama_kegiatan', 'Seminar')
                    // Tunggu form upload file siap
                    ->waitFor('input[type="file"][name="dokumen"]', 5) 
                    ->attach('dokumen', __DIR__.'/files/surat.pdf')
                    ->click('button[type="submit"]')
                    ->waitForText('pengajuan berhasil', 5)
                    ->assertSee('pengajuan berhasil');
        });
    }

    public function test_TC006_ajukan_ruangan_gagal() {
        $user = User::factory()->create();
        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                    ->visit('/user/ajukan-detail')
                    ->waitFor('button[type="submit"]', 5)
                    ->click('button[type="submit"]')
                    ->waitForText('Data pengajuan harus di isi', 5)
                    ->assertSee('Data pengajuan harus di isi');
        });
    }

    public function test_TC007_upload_pdf_berhasil() {
        $user = User::factory()->create();
        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                    ->visit('/user/ajukan-detail')
                    ->waitFor('input[type="file"][name="dokumen"]', 5)
                    ->attach('dokumen', __DIR__.'/files/surat.pdf')
                    ->click('button[type="submit"]')
                    ->waitForText('Dokumen berhasil diupload', 5)
                    ->assertSee('Dokumen berhasil diupload');
        });
    }

    public function test_TC008_upload_jpg_ditolak() {
        $user = User::factory()->create();
        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                    ->visit('/user/ajukan-detail')
                    ->waitFor('input[type="file"][name="dokumen"]', 5)
                    ->attach('dokumen', __DIR__.'/files/gambar.jpg')
                    ->click('button[type="submit"]')
                    ->waitForText('Dokumen tidak sesuai', 5)
                    ->assertSee('Dokumen tidak sesuai');
        });
    }
}