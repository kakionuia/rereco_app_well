<?php

namespace App\Models;

use Illuminate\Support\Arr;
// Kalo di image_url gausah pakai routing folder /image karena langsung akses ke public folder
class Post {
    public static function all()
    {
    return [
        [
            'slug' => 'inovasi-terbaru-mengubah-sampah-plastik-menjadi-energi-terbarukan',
            'title' => 'Inovasi Terbaru: Mengubah Sampah Plastik Menjadi Energi Terbarukan',
            'author' => 'Tim Peneliti RRCO',
            'body' => 'Dalam upaya mengatasi masalah lingkungan dan perubahan iklim, tim peneliti di Renewable Resource Conversion Organization (RRCO) telah mengembangkan teknologi inovatif yang dapat mengubah sampah plastik menjadi energi terbarukan. Teknologi ini tidak hanya membantu mengurangi limbah plastik yang mencemari lingkungan, tetapi juga menyediakan sumber energi alternatif yang ramah lingkungan.',
            'image_url' => 'tas-tangan.jpg',
            'label' => 'Daur ulang',
            'created_at' => '9 November 2025',
            'tag1' => 'DaurUlang',
            'tag2' => 'TeknologiHijau',
        ],
        [
            'slug' => 'kampanye-bersih-bersih-pantai-ribuan-relawan-beraksi-melawan-sampah-plastik',
            'title' => 'Kampanye Bersih-Bersih Pantai: Ribuan Relawan Beraksi Melawan Sampah Plastik',
            'author' => 'Lina Susanti',
            'body' => 'Inisiatif lokal berhasil mengumpulkan ton sampah dari pesisir, menyoroti urgensi pengurangan limbah plastik di laut kita.',
            'image_url' => 'tas.jpg',
            'label' => 'Konservasi',
            'created_at' => '11 November 2025',
            'tag1' => 'Konservasi',
            'tag2' => 'Lingkungan',
        ],
        [
            'slug' => 'teknologi-daur-ulang-plastik-canggih-bantu-pulihkan-ekosistem-laut',
            'title' => 'Teknologi Daur Ulang Plastik Canggih Bantu Pulihkan Ekosistem Laut',
            'author' => 'Andi Wijaya',
            'body' => 'Perusahaan teknologi lingkungan meluncurkan sistem daur ulang plastik mutakhir yang mampu mengubah limbah plastik laut menjadi bahan bakar bersih, mendukung upaya pelestarian ekosistem laut yang terancam.',
            'image_url' => 'botol.png',
            'label' => 'Teknologi',
            'created_at' => '13 November 2025',
            'tag1' => 'Teknologi',
            'tag2' => 'Inovasi',
        ],
        
    ];
    }

    public static function find($slug): array
    {
        $post = Arr::first(static::all(), fn($post) => $post['slug'] == $slug);
        if(!$post){
            abort(404);
        } 
        return $post;
    }
}