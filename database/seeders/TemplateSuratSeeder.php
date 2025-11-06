<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TemplateSuratSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('template_surats')->insert([
            [
                'judul' => 'Surat Permohonan Kegiatan',
                'tipe' => 'Permohonan',
                'deskripsi' => 'Digunakan untuk mengajukan permohonan kegiatan atau bantuan kepada pihak terkait.',
                'isi' => "Kepada Yth. {{kepada}}\n\nKami dari {{organisasi}} bermaksud mengajukan permohonan untuk {{keperluan}} yang akan dilaksanakan pada {{tanggal}} di {{lokasi}}.\n\nDemikian surat ini kami sampaikan. Atas perhatian dan kerja samanya kami ucapkan terima kasih.\n\nHormat kami,\n{{penanggung_jawab}}"
            ],
            [
                'judul' => 'Surat Undangan Kegiatan',
                'tipe' => 'Undangan',
                'deskripsi' => 'Digunakan untuk mengundang pihak terkait pada kegiatan resmi organisasi.',
                'isi' => "Dengan hormat,\n\nKami mengundang {{kepada}} untuk menghadiri kegiatan {{nama_kegiatan}} yang akan dilaksanakan pada {{tanggal}} pukul {{waktu}} di {{tempat}}.\n\nAtas kehadirannya kami ucapkan terima kasih.\n\nHormat kami,\n{{penanggung_jawab}}"
            ],
            [
                'judul' => 'Surat Peminjaman Tempat',
                'tipe' => 'Peminjaman',
                'deskripsi' => 'Digunakan untuk meminjam tempat, barang, atau fasilitas tertentu dari pihak terkait.',
                'isi' => "Kepada Yth. {{kepada}}\n\nSehubungan dengan kegiatan {{nama_kegiatan}} yang akan diadakan pada {{tanggal}}, kami bermaksud untuk meminjam {{fasilitas}} di {{lokasi}}.\n\nDemikian surat permohonan ini kami buat. Atas perhatian dan bantuannya kami ucapkan terima kasih.\n\nHormat kami,\n{{penanggung_jawab}}"
            ],
        ]);
    }
}
