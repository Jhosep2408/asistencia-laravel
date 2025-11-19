<!DOCTYPE html>
<html>
<head>
    <title>Fotocheck - {{ $student->full_name }}</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .photocheck { 
            width: 85mm; 
            height: 54mm; 
            border: 1px solid #000; 
            padding: 5mm;
            margin: 0 auto;
            position: relative;
        }
        .header { 
            text-align: center; 
            font-weight: bold; 
            margin-bottom: 3mm;
            font-size: 14pt;
        }
        .photo-container {
            width: 25mm;
            height: 30mm;
            border: 1px solid #ddd;
            float: left;
            margin-right: 3mm;
            text-align: center;
            overflow: hidden;
        }
        .photo {
            max-width: 100%;
            max-height: 100%;
        }
        .info { 
            float: left; 
            width: 50mm;
        }
        .info-item { 
            margin-bottom: 2mm; 
            font-size: 10pt;
        }
        .barcode { 
            clear: both; 
            text-align: center; 
            margin-top: 3mm;
        }
        .barcode-img { 
            height: 15mm; 
        }
        .footer {
            position: absolute;
            bottom: 2mm;
            right: 5mm;
            font-size: 8pt;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="photocheck">
        <div class="header">COLEGIO EJEMPLO</div>
        
        <div class="photo-container">
            @if($student->photo)
                <img src="{{ public_path('uploads/'.$student->photo) }}" class="photo">
            @else
                <div style="padding-top: 10mm;">SIN FOTO</div>
            @endif
        </div>
        
        <div class="info">
            <div class="info-item"><strong>DNI:</strong> {{ $student->dni }}</div>
            <div class="info-item"><strong>Nombre:</strong> {{ $student->full_name }}</div>
            <div class="info-item"><strong>Grado:</strong> {{ $student->grade->name }}</div>
            <div class="info-item"><strong>Sección:</strong> {{ $student->classroom->name }}</div>
        </div>
        
        <div class="barcode">
            <img src="{{ public_path('uploads/'.$student->barcode) }}" class="barcode-img">
        </div>
        
        <div class="footer">Válido año escolar {{ date('Y') }}</div>
    </div>
</body>
</html>