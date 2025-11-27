<!DOCTYPE html>
<html>
<head>
    <title>Rekap Data Keuangan</title>
    <style>
        body { font-family: sans-serif; margin: 20px;}
        h1 { font-size: 18pt; text-align: center; margin-bottom: 5px; }
        p.subtitle { text-align: center; font-size: 11pt; color: #555; margin-top: 0; }
        table { width: 100%; border-collapse: collapse; font-size: 10pt; margin-top: 20px; }
        th, td { border: 1px solid #dddddd; text-align: left; padding: 8px; }
        thead tr { background-color: #0d6efd; color: white; }
        tbody tr:nth-child(even) { background-color: #f2f2f2; }
        .pemasukan { color: #198754; font-weight: bold; }
        .pengeluaran { color: #dc3545; font-weight: bold; }
        .total-row td { font-weight: bold; background-color: #efefef; }
    </style>
</head>
<body>
    <h1>Rekap Data Keuangan</h1>
    <p class="subtitle">
        <strong>Periode:</strong> {{ $tanggalAwal ?: 'Semua' }} s/d {{ $tanggalAkhir ?: 'Semua' }} | 
        <strong>Jenis:</strong> {{ $jenis ? ucfirst($jenis) : 'Semua' }}
    </p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Jenis</th>
                <th>Kategori</th>
                <th>Keterangan</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; @endphp
            @forelse ($data as $index => $item)
                @php $total += ($item->jenis == 'pemasukan' ? $item->jumlah : -$item->jumlah); @endphp
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
                    <td>
                        <span class="{{ $item->jenis == 'pemasukan' ? 'pemasukan' : 'pengeluaran' }}">
                            {{ ucfirst($item->jenis) }}
                        </span>
                    </td>
                    <td>{{ $item->kategori ? $item->kategori->nama_kategori : '-' }}</td>
                    <td>{{ $item->keterangan }}</td>
                    <td>Rp {{ number_format($item->jumlah, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center;">Tidak ada data untuk periode ini.</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="5" style="text-align: right;">Total :</td>
                <td>Rp {{ number_format($total, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>
</body>
</html>
