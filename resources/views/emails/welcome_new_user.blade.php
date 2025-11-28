<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Welcome</title>
  </head>
  <body>
    <p>Hai {{ $user->name ?? 'Pengguna' }},</p>
    <p>Selamat datang! Akun Anda telah dibuat. Anda sekarang dapat masuk dan mulai menggunakan layanan kami.</p>
    <p>Jika Anda membutuhkan bantuan, balas email ini atau kunjungi situs kami.</p>
    <p>Salam,<br>Tim Admin</p>
  </body>
</html>
