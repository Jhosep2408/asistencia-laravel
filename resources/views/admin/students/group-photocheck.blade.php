<!DOCTYPE html>
<html>
<head>
    <title>Fotochecks - {{ $students->first()->grade->name }} {{ $students->first()->classroom->name }}</title>
    <style>
        @page {
            margin: 0;
            size: A4 portrait;
        }
        
        body { 
            margin: 0; 
            padding: 0; 
            background: white;
            font-family: Arial, sans-serif;
            width: 210mm;
            height: 297mm;
        }
        
        .page {
            page-break-after: always;
            position: relative;
            width: 210mm;
            height: 297mm;
            padding: 1.5mm;
            box-sizing: border-box;
        }
        
        /* POSICIONAMIENTO PERFECTO - 8 FOTOHECKS POR PÁGINA */
        .photocheck-card {
            position: absolute;
            width: 85.6mm;
            height: 53.98mm;
            border: 1px solid #007bff;
            border-radius: 4px;
            padding: 3mm;
            overflow: hidden;
            background: white;
            box-shadow: 0 2px 4px rgba(0, 123, 255, 0.1);
            /* Imagen de fondo MÁS CLARA */
            @if(file_exists(storage_path('app/public/Gaston.jpg')))
            background-image: url("data:image/jpeg;base64,{{ base64_encode(file_get_contents(storage_path('app/public/Gaston.jpg'))) }}");
            @endif
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            box-sizing: border-box;
        }
        
        /* POSICIONES EXACTAS */
        .photocheck-card:nth-child(1) { top: 10mm; left: 10mm; }
        .photocheck-card:nth-child(3) { top: 73.98mm; left: 10mm; }
        .photocheck-card:nth-child(5) { top: 137.96mm; left: 10mm; }
        .photocheck-card:nth-child(7) { top: 201.94mm; left: 10mm; }
        
        .photocheck-card:nth-child(2) { top: 10mm; left: 105.6mm; }
        .photocheck-card:nth-child(4) { top: 73.98mm; left: 105.6mm; }
        .photocheck-card:nth-child(6) { top: 137.96mm; left: 105.6mm; }
        .photocheck-card:nth-child(8) { top: 201.94mm; left: 105.6mm; }

        
        /* Capa semitransparente MÁS CLARA */
        .photocheck-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.50);
            z-index: 0;
        }
        
        /* ESTILOS ADAPTADOS DEL FOTOCHECK INDIVIDUAL */
        .header {
            display: flex;
            align-items: flex-start;
            justify-content: flex-start;
            gap: 1.5mm;
            margin-bottom: 2mm;
            border-bottom: 0.8px solid #007bff;
            padding-bottom: 1.5mm;
            position: relative;
            z-index: 1;
            height: 8mm;
        }
        
        .logo-container {
            width: 8mm;
            height: 8mm;
            border: 0.8px solid #007bff;
            border-radius: 50%;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            box-shadow: 0 1px 2px rgba(0, 123, 255, 0.2);
            flex-shrink: 0;
            margin-left: 70mm; /* Ajustado para el tamaño reducido */
        }
        
        .logo {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .logo-placeholder {
            font-size: 2.8pt;
            color: #007bff;
            font-weight: bold;
            text-align: center;
            line-height: 1.1;
        }
        
        .header-text {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            text-align: center;
            margin-top: -30px;
        }

        .institution-name {
            font-size: 10pt;
            font-weight: bold;
            color: #0056b3;
            line-height: 1.1;
            margin: 0;
            display: block;
        }
        
        .institution-location {
            font-size: 9pt;
            color: #000000;
            line-height: 1.1;
            margin-top: 0.3mm;
            display: block;
            font-weight: 500;
        }
        
        .photo-container {
            width: 22mm;
            height: 26mm;
            border: 0.8px solid #007bff;
            border-radius: 4px;
            float: left;
            margin-right: 2mm;
            background: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            z-index: 1;
        }
        
        .photo {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 4px;
        }
        
        .info {
            float: left;
            width: 80mm;
            font-size: 8pt;
            position: relative;
            z-index: 1;
            margin-left: 24px;
            margin-top: 7px;
        }
        
        .info-row {
            display: flex;
            align-items: center;
            margin-bottom: 2mm;
        }
        
        .info-row2 {
            display: inline-block;
            margin-left: 6mm;
            margin-bottom: -1mm;
        }
        
        .info-label {
            font-weight: bold;
            color: #002fff;
            width: 18mm;
            font-size: 8.5pt;
            flex-shrink: 0;
        }

        .info-value {
            color: #000000;
            font-weight: 500;
            font-size: 8.5pt;
            flex: 1;
        }
        
        .barcode {
            clear: both;
            text-align: center;
            margin-top: 0.6mm;
            padding-top: 2mm;
            position: relative;
            z-index: 1;
        }
        
        .barcode-img {
            height: 9mm;
            max-width: 90%;
        }
        
        .footer {
            position: absolute;
            bottom: 1.2mm;
            right: 2.5mm;
            font-size: 4pt;
            color: #666;
            z-index: 1;
        }
        
        .student-code {
            font-size: 4.5pt;
            font-weight: bold;
            margin-top: 0.4mm;
            color: #007bff;
        }
        
        .accent-decoration {
            position: absolute;
            top: 0;
            right: 0;
            width: 7mm;
            height: 7mm;
            background: #007bff;
            border-bottom-left-radius: 100%;
            opacity: 0.1;
            z-index: 1;
        }
        
        /* Estilos para cuando no hay foto */
        .no-photo {
            color: #6c757d;
            font-size: 4pt;
            text-align: center;
            padding: 3px;
        }
        
        /* Ajustes para impresión */
        @media print {
            body {
                margin: 0;
                padding: 0;
                width: 210mm;
                height: 297mm;
            }
            
            .page {
                width: 210mm;
                height: 297mm;
                margin: 0;
                padding: 10mm;
            }
            
            .photocheck-card {
                break-inside: avoid;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>
</head>
<body>
    @foreach($students->chunk(9) as $pageIndex => $chunk)
        <div class="page">
            @foreach($chunk as $index => $student)
                <div class="photocheck-card">
                    <div class="accent-decoration"></div>
                    
                    <div class="header">
                        <div class="logo-container">
                            @if(file_exists(storage_path('app/public/logo.jpg')))
                                <img src="{{ storage_path('app/public/logo.jpg') }}" class="logo" alt="Logo">
                            @elseif(file_exists(storage_path('app/public/logo.png')))
                                <img src="{{ storage_path('app/public/logo.png') }}" class="logo" alt="Logo">
                            @else
                                <div class="logo-placeholder">LOGO<br>IE</div>
                            @endif
                        </div>
                        <div class="header-text">
                            <span class="institution-name">INSTITUCIÓN EDUCATIVA</span>
                            <span class="institution-location">GASTÓN VIDAL PORTURAS</span>
                        </div>
                    </div>
                    
                    @if($student->photo && file_exists(storage_path('app/public/' . $student->photo)))
                        <div class="photo-container">
                            <img src="{{ storage_path('app/public/' . $student->photo) }}" class="photo">
                        </div>
                    @else
                        <div class="photo-container">
                            <div class="no-photo">SIN FOTO</div>
                        </div>
                    @endif
                    
                    <div class="info">
                        <div class="info-row">
                            <span class="info-label">DNI:</span> 
                            <span class="info-value">{{ $student->dni }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Nombres:</span> 
                            <span class="info-value">{{ $student->first_name }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Apellidos:</span> 
                            <span class="info-value">{{ $student->last_name }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Grado:</span> 
                            <span class="info-value">{{ $student->grade->name ?? 'N/A' }}</span>
                            <div class="info-row2">
                                <span class="info-label">Sección:</span> 
                                <span class="info-value">{{ $student->classroom->name ?? 'N/A' }}</span>
                            </div>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Apoderado:</span> 
                            <span class="info-value">{{ $student->guardian_phone ?? 'No registrado' }}</span>
                        </div>
                    </div>
                    
                    <div class="barcode">
                        @if($student->barcode && file_exists(storage_path('app/public/' . $student->barcode)))
                            <img src="{{ storage_path('app/public/' . $student->barcode) }}" class="barcode-img">
                        @else
                            <div style="height: 7mm; display: flex; align-items: center; justify-content: center; color: #666; font-size: 4.5pt;">
                                CÓDIGO: ESTU{{ $student->dni }}
                            </div>
                        @endif
                        <div class="student-code">ESTU{{ $student->dni }}</div>
                    </div>
                    
                    <div class="footer">Válido año escolar {{ date('Y') }}</div>
                </div>
            @endforeach
        </div>
    @endforeach
</body>
</html>
