<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Keluhan Ditolak</title>
</head>
<body style="font-family: Arial, sans-serif; color: #333;">
  <h2>Keluhan Anda Ditolak</h2>

  <p>Hai {{ $complaint->user?->name ?? 'Pengguna' }},</p>

  <p>Kami ingin memberitahu bahwa keluhan Anda terkait pesanan <strong>{{ $complaint->order?->order_number ?? $complaint->order_id }}</strong> telah ditolak oleh tim admin.</p>

  @php
    $adminNote = null;
    if (!empty($complaint->metadata) && is_array($complaint->metadata)) {
        $adminNote = $complaint->metadata['admin_note'] ?? $complaint->metadata['note'] ?? null;
    }
  @endphp

  @if($adminNote)
    <p><strong>Alasan:</strong> {{ $adminNote }}</p>
  @else
    <p>Tidak ada keterangan tambahan dari admin.</p>
  @endif

  <p>Jika Anda ingin mengajukan banding, silakan buka halaman detail pesanan dan gunakan tombol "Ajukan Komplain" atau hubungi layanan pelanggan kami.</p>

  <p>Salam,<br>Tim Admin</p>
</body>
</html>
