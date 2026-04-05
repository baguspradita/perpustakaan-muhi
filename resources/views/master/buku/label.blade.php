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
            width: 297mm;
            height: 210mm;
            margin: 20px auto;
            padding: 15mm;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .label-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12mm;
            height: 100%;
        }

        .label {
            width: 100%;
            height: 75mm;
            border: 2px solid #333;
            padding: 8mm;
            display: flex;
            flex-direction: column;
            justify-content: space-around;
            font-size: 14px;
            line-height: 1.5;
            background: white;
            position: relative;
        }

        .label-row {
            text-align: center;
            font-weight: bold;
            min-height: 18px;
        }

        .subject {
            font-size: 22px;
            font-weight: bold;
            letter-spacing: 1px;
        }

        .author {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .title-letter {
            font-size: 16px;
            font-weight: bold;
        }

        .copy-number {
            font-size: 11px;
            font-weight: bold;
            letter-spacing: 0.5px;
        }

        .divider {
            border-top: 1px solid #333;
            margin: 2mm 0;
        }

        .metadata {
            position: absolute;
            bottom: 3mm;
            right: 3mm;
            font-size: 6px;
            color: #999;
        }

        .library-header {
            text-align: center;
            font-size: 9px;
            font-weight: bold;
            margin-bottom: 3mm;
            padding: 2mm 0;
            background: linear-gradient(to right, #e8e8e8, #ffffff, #e8e8e8);
            border-top: 2px solid #333;
            border-bottom: 2px solid #333;
            letter-spacing: 0.8px;
            text-transform: uppercase;
        }

        @media print {
            body {
                background: white;
                padding: 0;
            }

            .page {
                margin: 0;
                padding: 15mm;
                box-shadow: none;
                page-break-after: always;
                width: 297mm;
                height: 210mm;
            }

            @page {
                size: A4 landscape;
                margin: 0;
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
                    <div class="library-header">
                         Perpustakaan SMK Muhammadiyah 1 
                    </div>

                    <div class="label-row subject">
                        {{ $buku->subjek?->kode_ddc ?? '---' }}
                    </div>

                    <div class="divider"></div>

                    <div class="label-row author">
                        {{ strtoupper(substr($copy->nama_penulis ?? 'UNKNOWN', 0, 3)) }}
                    </div>

                    <div class="divider"></div>

                    <div class="label-row title-letter">
                        {{ strtolower($copy->huruf_judul_awal ?? '?') }}
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
