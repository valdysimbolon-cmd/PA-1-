<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        h1 { text-align: center; color: #1A4D2E; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { background: #1A4D2E; color: white; padding: 8px; text-align: left; }
        td { border: 1px solid #ddd; padding: 6px; }
        .text-center { text-align: center; }
        .status-badge { padding: 2px 8px; border-radius: 4px; font-size: 10px; }
        .status-pending { background: #f59e0b; color: #fff; }
        .status-approved { background: #10b981; color: #fff; }
        .status-returned { background: #3b82f6; color: #fff; }
        .status-rejected { background: #ef4444; color: #fff; }
        .status-cancelled { background: #6b7280; color: #fff; }
        .footer { margin-top: 30px; text-align: center; color: #6b7280; font-size: 10px; }
    </style>
</head>
<body>
    <h1>{{ $title }}</h1>
    <p>Periode: {{ $period }}</p>
    <table>
        <thead>
            <tr>
                <th>No. Resi</th>
                <th>Peminjam</th>
                <th>NIM</th>
                <th>Judul Penelitian</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Kembali</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($loans as $loan)
            <tr>
                <td>{{ $loan->receipt_number }}</td>
                <td>{{ $loan->borrower_name }}</td>
                <td>{{ $loan->nim }}</td>
                <td>{{ $loan->research_title }}</td>
                <td>{{ \Carbon\Carbon::parse($loan->planned_borrow_date)->format('d/m/Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($loan->planned_return_date)->format('d/m/Y') }}</td>
                <td>
                    <span class="status-badge status-{{ $loan->status }}">
                        {{ ucfirst($loan->status) }}
                    </span>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center">Tidak ada data peminjaman.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="footer">
        Dicetak pada: {{ now()->format('d/m/Y H:i') }}
    </div>
</body>
</html>