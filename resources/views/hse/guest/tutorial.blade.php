<x-app-layout>
@push('css')
<style>

</style>
@endpush
<div class="mt-20">
@php
    $texts = [
        'Pilih Create New Form',
        'Pilih Buat form baru',
        'Isi data.',
        'Jika sudah diisi, tekan tombol lanjut',
        'Selanjutnya, centang pilihan yang diperlukan. Jika tidak ada dalam pilihan, isi di kolom terakhir dan centang kolomnya. Jika sudah, tekan tombol lanjut.',
        'Sama seperti sebelumnya, centang pilihan yang diperlukan. Jika sudah, tekan tombol lanjut.',
        'Centang pilihan yang diperlukan, jika memilih "Alat angkat & angkut", silahkan upload file SIO dan SILO nya.',
        'File yang diupload bisa lebih dari satu. Jika sudah, tekan tombol lanjut.',
        'Selanjutnya ijin kerja tambahan yang diperlukan.',
        'Jika salah satu dipilih, maka akan ada tahap tambahan untuk pengisian ijin kerja tambahan.',
        'Selanjutnya, pilih antara ya atau tidak jika memerlukan Sistem Proteksi Kebakaran.',
        'Jika ya, centang peralatan proteksi kebakaran yang diperlukan. Jika sudah, tekan tombol lanjut.',
        'Jika memilih ijin kerja tambahan, maka akan ada tahap tambahan dalam pengisian formulir.',
        'Baca ketentuan-ketentuan dibawah. Jika sudah, tekan tombol lanjut.',
        'Untuk ijin kerja di ketinggian, jika memerlukan scaffolding, silahkan centang pilihannya. Jika sudah, tekan tombol lanjut.',
        'Jika mencentang pilihan menggunakan scaffolding, maka akan muncul tahap tambahan.',
        'Baca dan centang ketentuan-ketentuan dibawah. Jika sudah, tekan tombol lanjut.',
        'Selanjutnya, masukan nama-nama pekerja.',
        'Ada tombol tambah untuk menambah kolom, dan ada tombol hapus baris terakhir untuk menghapus kolom paling terakhir. Jika sudah, tekan tombol lanjut.',
        'Selanjutnya isi kolom uraian langkah pekerjaan, bahaya, risiko yang timbul, dan tindakan pencegahan / pengendalian. Jika belum yakin dengan yang diisi, silahkan tekan tombol "Simpan sebagai Draft". Jika sudah yakin, silahkan tekan tombol "Selesai".',
        'Jika sudah yakin, silahkan tekan "Ya". Jika belum yakin, silahkan tekan "Tidak".',
        'Jika anda menekan "Simpan sebagai Draft", status form akan menjadi draft. Anda bisa melihat form yang sudah anda isi dengan menekan tombol "View Form".',
        'Jika anda menekan "Selesai", status anda akan menjadi in review. Silahkan tunggu sampai form anda di review dan di approve.',
        'Jika form anda sudah di approve, maka status form anda akan menjadi "Approved".',
        'Anda akan dikirimkan email jika form anda Approved atau Reject.',
    ];
@endphp
<h2 class="text-2xl font-medium mt-5">Panduan Pengisian Formulir HSE</h2>
<ol class="list-inside" style="list-style-type: number; margin-left:10px; margin-top: 10px;">
    @for ($i = 1; $i <= 25; $i++)
        @if(isset($texts[$i-1]))
            <li class="text-lg">{{ $texts[$i-1] }}</li>
        @endif
        <img src="{{asset('assets/images/hse/gambar'.$i.'.jpg')}}" alt="gambar" style="margin-top:5px; margin-bottom: 20px;">
    @endfor
</ol>
<a href="{{ route('hse.dashboard') }}" class="text-xl">Kembali ke dashboard</a>
</div>
</x-app-layout>