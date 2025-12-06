<!DOCTYPE html>
<html>
<head>
    <title>Laporan Progress Magang</title>
    <style>
        body { font-family: 'Times New Roman', Times, serif; font-size: 12px; color: #000; line-height: 1.3; }
        
        /* KOP SURAT */
        .header-table { width: 100%; margin-bottom: 2px; border-bottom: 3px solid #000; padding-bottom: 10px; }
        .kop-program { font-size: 14px; font-weight: bold; margin: 0; letter-spacing: 0.5px; text-transform: uppercase; }
        .kop-perusahaan { font-size: 20px; font-weight: 900; margin: 8px 0; text-transform: uppercase; letter-spacing: 1px; }
        .kop-alamat { font-size: 11px; font-style: normal; margin: 0; }
        
        /* GARIS PEMISAH KOP */
        .line-thin { border-top: 1px solid #000; margin-top: 2px; margin-bottom: 30px; }

        /* JUDUL LAPORAN */
        .report-title { text-align: center; margin-bottom: 30px; }
        .report-title h2 { margin: 0; font-size: 16px; text-decoration: underline; text-transform: uppercase; letter-spacing: 1px; }
        .report-title p { margin: 5px 0 0; font-size: 12px; font-weight: bold; }
        
        .meta-table { width: 100%; margin-bottom: 20px; font-size: 12px; }
        .meta-table td { padding: 4px 2px; vertical-align: top; }
        .meta-label { font-weight: bold; width: 140px; }

        .content-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .content-table th, .content-table td { border: 1px solid #000; padding: 8px; text-align: left; vertical-align: top; }
        .content-table th { background-color: #e0e0e0; font-weight: bold; text-align: center; vertical-align: middle; }
        
        .status-badge { font-weight: bold; text-transform: uppercase; font-size: 10px; }
        
        /* Helper untuk tulisan output */
        .output-text { color: #444; font-size: 11px; font-style: italic; margin-top: 2px; display: block; }

        /* FORMAT TANDA TANGAN BARU (3 ORANG) */
        .signature-section { margin-top: 40px; page-break-inside: avoid; }
        .signature-table { width: 100%; border: none; text-align: center; }
        .signature-table td { border: none; vertical-align: top; padding: 0; }
        .signature-name { margin-top: 60px; font-weight: bold; text-decoration: underline; }
        .signature-role { margin-top: 2px; font-size: 11px; }
    </style>
</head>
<body>

    <!-- HITUNG ULANG JAM KERJA SECARA PRESISI (MATCHING DASHBOARD) -->
    @php
        $recalculatedTotalSeconds = 0;
        foreach($attendances as $att) {
            if($att->status == 'hadir' && $att->check_in && $att->check_out) {
                $start = \Carbon\Carbon::parse($att->check_in);
                $end = \Carbon\Carbon::parse($att->check_out);
                $recalculatedTotalSeconds += $end->diffInSeconds($start);
            }
        }
        $totalHoursPrecise = $recalculatedTotalSeconds > 0 ? round($recalculatedTotalSeconds / 3600, 1) : 0;
    @endphp

    <!-- KOP SURAT FORMAL -->
    <table class="header-table">
        <tr>
            <!-- LOGO PERUSAHAAN (KIRI) -->
            <td width="20%" align="center" style="vertical-align: middle; border: none; padding-right: 10px;">
                <img src="{{ public_path('images/logo.png') }}" width="100px" style="display: block;">
            </td>
            
            <!-- TEKS KOP (TENGAH) -->
            <td align="center" style="vertical-align: middle; border: none;">
                <p class="kop-program">PROGRAM MAGANG LULUSAN S1 KEMNAKER</p>
                <h1 class="kop-perusahaan">PT. PRIMA SEJATI SEJAHTERA</h1>
                <p class="kop-alamat">
                    Desa Butuh, RT.01 / RW.02, Mojosongo, Dukuh, Butuh,<br>
                    Kec. Mojosongo, Kabupaten Boyolali, Jawa Tengah 57482<br>
                    Telp: (0276) 322399
                </p>
            </td>
            
            <!-- PENYEIMBANG KANAN (KOSONG) -->
            <td width="20%" style="border: none;"></td>
        </tr>
    </table>
    
    <!-- Garis Tipis Tambahan -->
    <div class="line-thin"></div>

    <!-- JUDUL LAPORAN -->
    <div class="report-title">
        <h2>LAPORAN PROGRESS MAGANG KEMNAKER BATCH II</h2>
        <p>Periode: {{ $startDate->translatedFormat('d F Y') }} - {{ $endDate->translatedFormat('d F Y') }}</p>
    </div>

    <!-- INFORMASI BIODATA -->
    <table class="meta-table">
        <tr>
            <td class="meta-label">Nama Peserta</td>
            <td width="10px">:</td>
            <td>{{ $user->name }}</td>
            
            <td class="meta-label" width="120px">Total Kehadiran</td>
            <td width="10px">:</td>
            <td>{{ $summary['hadir'] }} Hari</td>
        </tr>
        <tr>
            <td class="meta-label">Email</td>
            <td>:</td>
            <td>{{ $user->email }}</td>
            
            <td class="meta-label">Total Jam Kerja</td>
            <td>:</td>
            <td>{{ $totalHoursPrecise }} Jam</td>
        </tr>
        <tr>
            <td class="meta-label">Divisi / Posisi</td>
            <td>:</td>
            <td>Adm. Warehouse</td> 
            
            <td class="meta-label">Sakit / Izin / Alpa</td>
            <td>:</td>
            <td>{{ $summary['sakit'] }} / {{ $summary['izin'] }} / {{ $summary['alpa'] }}</td>
        </tr>
    </table>

    <!-- TABEL UTAMA -->
    <table class="content-table">
        <thead>
            <tr>
                <th style="width: 30px;">No</th>
                <th style="width: 90px;">Hari/Tanggal</th>
                <th style="width: 80px;">Jam Kerja</th>
                <th style="width: 60px;">Status</th>
                <th>Uraian Kegiatan & Hasil Pembelajaran</th>
            </tr>
        </thead>
        <tbody>
            @forelse($attendances as $index => $row)
                <tr>
                    <td style="text-align: center;">{{ $index + 1 }}</td>
                    <td>
                        {{ \Carbon\Carbon::parse($row->date)->translatedFormat('l,') }}<br>
                        {{ \Carbon\Carbon::parse($row->date)->translatedFormat('d M Y') }}
                    </td>
                    <td style="text-align: center;">
                        @if($row->status == 'hadir')
                            <div style="font-weight: bold;">
                                {{ \Carbon\Carbon::parse($row->check_in)->format('H:i') }} - {{ \Carbon\Carbon::parse($row->check_out)->format('H:i') }}
                            </div>
                            
                            @php
                                $harianStart = \Carbon\Carbon::parse($row->check_in);
                                $harianEnd = \Carbon\Carbon::parse($row->check_out);
                                $harianDurasi = round($harianEnd->diffInMinutes($harianStart) / 60, 1);
                            @endphp
                            <span style="font-size: 10px; color: #555;">({{ $harianDurasi }} Jam)</span>
                        @else
                            -
                        @endif
                    </td>
                    <td style="text-align: center;">
                        <span class="status-badge">{{ $row->status }}</span>
                    </td>
                    <td>
                        @if($row->status == 'hadir')
                            @if($row->daily_activities->count() > 0)
                                <ul style="margin: 0; padding-left: 15px;">
                                    @foreach($row->daily_activities as $activity)
                                        <li style="margin-bottom: 8px;">
                                            <strong>[{{ $activity->type == 'learning' ? 'Materi' : 'Praktek' }}]</strong> {{ $activity->title }}
                                            @if($activity->description)
                                                <span class="output-text">Output: {{ $activity->description }}</span>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <span style="font-style: italic; color: #888;">- Tidak ada catatan aktivitas -</span>
                            @endif
                        @else
                            <strong>Keterangan:</strong> {{ $row->notes ?? '-' }}
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center; padding: 30px; font-style: italic; color: #666;">
                        Tidak ada data presensi yang terekam pada periode tanggal ini.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- TANDA TANGAN (FORMAT 3 ORANG) -->
    <div class="signature-section">
        <!-- Baris 1: Peserta & Mentor -->
        <table class="signature-table">
            <tr>
                <td style="width: 40%; text-align: center;">
                    <p>Mengetahui,</p>
                    <p><strong>Peserta Magang</strong></p>
                    
                    <p class="signature-name">{{ $user->name }}</p>
                    <p class="signature-role"></p>
                </td>
                
                <td style="width: 20%;"></td> <!-- Spacer Tengah -->
                
                <td style="width: 40%; text-align: center;">
                    <p>Boyolali, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
                    <p><strong>Mentor / Chief Warehouse</strong></p>
                    
                    <p class="signature-name">( ........................................ )</p>
                    <p class="signature-role"></p>
                </td>
            </tr>
        </table>

        <!-- Baris 2: HRD (Tengah Bawah) -->
        <table class="signature-table" style="margin-top: 30px;">
            <tr>
                <td align="center">
                    <p>Menyetujui,</p>
                    <p><strong>HRD / Factory Manager</strong></p>
                    
                    <p class="signature-name" style="margin-top: 70px;">( ........................................ )</p>
                    <p class="signature-role"></p>
                </td>
            </tr>
        </table>
    </div>

</body>
</html>