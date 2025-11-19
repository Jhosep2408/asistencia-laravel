<!DOCTYPE html>
<html>
<head>
    <title>Fotocheck - {{ $student->full_name }}</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            margin: 0; 
            padding: 0; 
            background: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .photocheck-card {
            width: 85mm;
            height: 48mm;
            border: 1.5px solid #007bff;
            border-radius: 6px;
            padding: 3mm;
            margin: 0 auto;
            position: relative;
            overflow: hidden;
            background: white;
            box-shadow: 0 3px 10px rgba(0, 123, 255, 0.15);
            /* Imagen de fondo MÁS CLARA */
            background-image: url("data:image/jpeg;base64,{{ base64_encode(file_get_contents(storage_path('app/public/Gaston.jpg'))) }}");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
        
        /* Capa semitransparente MÁS CLARA */
        .photocheck-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.50); /* Cambiado de 0.75 a 0.65 para más claridad */
            z-index: 0;
        }
        
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
            height: 9mm;
        }
        
        .logo-container {
            width: 10.5mm;
            height: 10.5mm;
            display: flex;
            align-items: flex-start; /* flex-start en vez de 'left' */
            justify-content: flex-start; /* flex-start en vez de 'left' */
            margin-left: 270px;
            margin-top: -5px;
            position: relative; /* aseguramos posición para z-index */
            z-index: 2; /* poner por encima de la capa ::before (z-index:0) */
        }

        .logo {
            width: 100%;
            height: 100%;
            display: block;
            object-fit: contain;
        }
                
        .header-text {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            text-align: center;
            margin-top: -35px;
        }

        .institution-name {
            font-size: 9.5pt;
            font-weight: bold;
            color: #0056b3;
            line-height: 1;
            margin: 0;
            display: block;
        }
        .institution-location {
            font-size: 8pt;
            color: #000000ff;
            line-height: 1;
            margin-top: 0.1mm;
            display: block;
            font-weight: 500;
        }
        .photo-container {
            width: 18mm;
            height: 20mm;
            border: 0.8px solid #007bff;
            border-radius: 5px;
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
            width: 75mm;
            font-size: 6.5pt;
            position: relative;
            z-index: 1;
            margin-left: 20px;
            margin-top: 1px;
        }
        .info-row {
            display: flex;
            align-items: center; /* Alinea verticalmente */
            margin-bottom: 0.8mm;
        }
        .info-row2 {
            display: inline-block;
            margin-left: 6mm;
            margin-bottom: -1mm;
        }
        .info-label {
            font-weight: bold;
            color: #002fffff;
            width: 16mm; /* Ajusta el ancho fijo para alinear */
            font-size: 6.5pt;
            flex-shrink: 0;
        }

        .info-value {
            color: #000000ff;
            font-weight: 500;
            font-size: 6.5pt;
            flex: 1; /* Ocupa el espacio restante */
        }
        .barcode {
            clear: both;
            text-align: center;
            margin-top: 0.5mm;
            padding-top: 1mm;
            position: relative;
            z-index: 1;
        }
        .barcode-img {
            height: 12mm;
        }
        .footer {
            position: absolute;
            bottom: 2mm;
            right: 4mm;
            font-size: 6pt;
            color: #666;
            z-index: 1;
        }
        .student-code {
            font-size: 5.5pt;
            font-weight: bold;
            margin-top: 0.5mm;
            color: #007bff;
        }

        .accent-decoration {
            position: absolute;
            top: 0;
            right: 0;
            width: 12mm;
            height: 12mm;
            background: #007bff;
            border-bottom-left-radius: 100%;
            opacity: 0.1;
            z-index: 1;
        }
    </style>
</head>
<body>
    <div class="photocheck-card">
        <div class="accent-decoration"></div>
        
        <div class="logo-container">
            @if(file_exists(storage_path('app/public/logo.jpg')))
            <img src="{{ storage_path('app/public/logo.jpg') }}" class="logo" alt="Logo del Colegio">
            @elseif(file_exists(storage_path('app/public/logo.png')))
            <img src="{{ storage_path('app/public/logo.png') }}" class="logo" alt="Logo del Colegio">
            @else
            <div class="logo-placeholder">LOGO<br>IE</div>
            @endif
        </div>

        <div class="header">
            <div class="header-text">
                <span class="institution-name">INSTITUCIÓN EDUCATIVA</span>
                <span class="institution-location">GASTÓN VIDAL PORTURAS</span>
            </div>
        </div>
        
        @if($student->photo)
        <div class="photo-container">
            <img src="{{ storage_path('app/public/' . $student->photo) }}" class="photo">
        </div>
        @else
        <div class="photo-container" style="color: #6c757d; font-size: 7pt;">
            SIN FOTO
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
                <span class="info-value">{{ $student->grade->name }}</span>
                <div class="info-row2">
                    <span class="info-label">Sección:</span> 
                    <span class="info-value">{{ $student->classroom->name }}</span>
                </div>
            </div>
            <div class="info-row">
                <span class="info-label">Apoderado:</span> 
                <span class="info-value">{{ $student->guardian_phone }}</span>
            </div>
        </div>
        
        <div class="barcode">
            <img src="{{ storage_path('app/public/' . $student->barcode) }}" class="barcode-img">
            <div class="student-code">ESTU{{ $student->dni }}</div>
        </div>
        
        <div class="footer">Válido año escolar {{ date('Y') }}</div>
    </div>
</body>
</html>