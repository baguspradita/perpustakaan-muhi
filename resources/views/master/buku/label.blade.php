<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Label Buku - {{ $buku->judul }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Courier New', monospace;
            background: #f5f5f5;
            padding: 20px;
        }

        .page {
            background: white;
            width: 210mm;
            height: 297mm;
            margin: 20px auto;
            padding: 20mm;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .label-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 30mm;
            height: 100%;
        }

        .label {
            width: 100%;
            height: 100mm;
            border: 2px solid #333;
            padding: 10mm;
            display: flex;
            flex-direction: column;
            justify-content: space-around;
            font-size: 16px;
            line-height: 1.6;
            background: white;
            position: relative;
        }

        .label-row {
            text-align: center;
            font-weight: bold;
            min-height: 20px;
        }

        .subject {
            font-size: 24px;
            font-weight: bold;
            letter-spacing: 2px;
        }

        .author {
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .title-letter {
            font-size: 18px;
            font-weight: bold;
        }

        .copy-number {
            font-size: 13px;
            font-weight: bold;
            letter-spacing: 1px;
        }

        .divider {
            border-top: 1px solid #333;
            margin: 3mm 0;
        }

        .metadata {
            position: absolute;
            bottom: 5mm;
            right: 5mm;
            font-size: 7px;
            color: #999;
        }

        @media print {
            body {
                background: white;
                padding: 0;
            }

            .page {
                margin: 0;
                padding: 20mm;
                box-shadow: none;
                page-break-after: always;
            }
        }

        .no-print {
            text-align: center;
            margin: 20px 0;
            padding: 15px;
            background: #e3f2fd;
            border-radius: 8px;
        }

        .no-print button {
            padding: 10px 20px;
            background: #1976d2;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }

        .no-print button:hover {
            background: #1565c0;
        }
    </style>
</head>
<body>
    <div class="no-print">
        <button onclick="window.print()">🖨️ Cetak Label</button>
        <button onclick="window.history.back()" style="margin-left: 10px; background: #666;">← Kembali</button>
    </div>

    <div class="page">
        <div class="label-grid">
            @forelse($copies as $copy)
                <div class="label">
                    <div class="label-row subject">
                        {{ $buku->subjek?->kode_ddc ?? '---' }}
                    </div>

                    <div class="divider"></div>

                    <div class="label-row author">
                        {{ strtoupper($copy->nama_depan_penulis ?? 'UNKNOWN') }}
                    </div>

                    <div class="divider"></div>

                    <div class="label-row title-letter">
                        {{ $copy->huruf_judul_awal ?? '?' }}
                    </div>

                    <div class="divider"></div>

                    <div class="label-row copy-number">
                        {{ $copy->nomor_salinan ?? 'c.?' }}
                    </div>

                    <div class="metadata">
                        {{ $buku->judul }}<br>
                        {{ now()->format('d/m/Y') }}
                    </div>
                </div>
            @empty
                <div style="padding: 20px; color: #999;">
                    ℹ️ Tidak ada salinan untuk dicetak
                </div>
            @endforelse
        </div>
    </div>

    <script>
        // Auto-open print dialog
        // window.onload = function() { window.print(); };
    </script>
</body>
</html>
