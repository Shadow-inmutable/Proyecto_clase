<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Producto: {{$product->name}}</title>
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --accent-color: #e74c3c;
            --light-bg: #f8f9fa;
            --border-color: #dee2e6;
            --text-color: #212529;
            --success-color: #27ae60;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 30px;
            color: var(--text-color);
            line-height: 1.6;
            background-color: #fff;
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid var(--secondary-color);
        }
        
        .company-info {
            flex: 1;
        }
        
        .company-name {
            font-size: 24px;
            font-weight: 700;
            color: var(--primary-color);
            margin: 0;
        }
        
        .company-tagline {
            font-size: 14px;
            color: #7f8c8d;
            margin-top: 5px;
        }
        
        .report-title {
            text-align: right;
            flex: 1;
        }
        
        .report-title h1 {
            color: var(--primary-color);
            margin: 0;
            font-size: 28px;
        }
        
        .report-subtitle {
            color: var(--secondary-color);
            font-size: 16px;
            margin-top: 5px;
        }
        
        .intro-section {
            background-color: var(--light-bg);
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }
        
        .intro-title {
            color: var(--primary-color);
            font-size: 18px;
            margin-top: 0;
            margin-bottom: 10px;
        }
        
        .intro-text {
            margin: 0;
            color: #555;
        }
        
        .product-highlights {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }
        
        .highlight-card {
            flex: 1;
            min-width: 150px;
            background: white;
            border-radius: 8px;
            padding: 15px;
            margin: 0 10px 15px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.08);
            text-align: center;
            border-top: 4px solid var(--secondary-color);
        }
        
        .highlight-card:nth-child(2) {
            border-top-color: var(--success-color);
        }
        
        .highlight-card:nth-child(3) {
            border-top-color: var(--accent-color);
        }
        
        .highlight-value {
            font-size: 24px;
            font-weight: 700;
            color: var(--primary-color);
            margin: 10px 0 5px;
        }
        
        .highlight-label {
            font-size: 14px;
            color: #7f8c8d;
        }
        
        .section-title {
            color: var(--primary-color);
            font-size: 20px;
            margin: 30px 0 15px;
            padding-bottom: 8px;
            border-bottom: 1px solid var(--border-color);
        }
        
        .product-details {
            width: 100%;
            border-collapse: collapse;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
            margin-bottom: 30px;
        }
        
        .product-details th {
            background-color: var(--primary-color);
            color: white;
            padding: 12px 15px;
            text-align: left;
            font-weight: 600;
        }
        
        .product-details td {
            padding: 12px 15px;
            border-bottom: 1px solid var(--border-color);
        }
        
        .product-details tr:nth-child(even) {
            background-color: var(--light-bg);
        }
        
        .product-details tr:hover {
            background-color: #e8f4fc;
        }
        
        .price-cell {
            font-weight: 700;
            color: var(--success-color);
        }
        
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            color: #7f8c8d;
        }
        
        .footer-left {
            text-align: left;
        }
        
        .footer-right {
            text-align: right;
        }
        
        .badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 600;
        }
        
        .badge-success {
            background-color: #d5f4e6;
            color: var(--success-color);
        }
        
        .badge-primary {
            background-color: #d6eaf8;
            color: var(--secondary-color);
        }
        
        @media print {
            body {
                padding: 20px;
            }
            
            .highlight-card {
                box-shadow: none;
                border: 1px solid var(--border-color);
            }
            
            .product-details {
                box-shadow: none;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="company-info">
            <h1 class="company-name">Mi Empresa</h1>
            <p class="company-tagline">Soluciones de calidad para sus necesidades</p>
        </div>
        <div class="report-title">
            <h1>Reporte de Producto</h1>
            <p class="report-subtitle">Análisis detallado del inventario</p>
        </div>
    </div>
    
    <div class="intro-section">
        <h2 class="intro-title">(u^o^)-|Resumen Ejecutivo</h2>
        
        <p class="intro-text">
            Este documento presenta un análisis detallado del producto <strong>{{ $product->name }}</strong> 
            en nuestro inventario. A continuación encontrará información completa sobre las características, 
            disponibilidad y datos relevantes de este artículo para facilitar la toma de decisiones 
            comerciales y la gestión de inventario.
        </p>
    </div>
    
    <div class="product-highlights">
        <div class="highlight-card">
            <div class="highlight-label">Disponibilidad</div>
            <div class="highlight-value">{{ $product->ammount }}</div>
            <div class="highlight-label">{{ $product->unit }}</div>
        </div>
        <div class="highlight-card">
            <div class="highlight-label">Precio Unitario</div>
            <div class="highlight-value">${{ number_format($product->price, 0, ',', '.') }}</div>
            <div class="highlight-label">Valor de stock</div>
        </div>
        <div class="highlight-card">
            <div class="highlight-label">Estado</div>
            <div class="highlight-value">
                @if($product->ammount > 10)
                    <span class="badge badge-success">En Stock</span>
                @elseif($product->ammount > 0)
                    <span class="badge badge-primary">Stock Bajo</span>
                @else
                    <span class="badge badge-warning">Agotado</span>
                @endif
            </div>
            <div class="highlight-label">Inventario</div>
        </div>
    </div>
    <br>
    <h2 class="section-title">(\^o^/) |Detalles del Producto</h2>
    
    <table class="product-details">
        <thead>
            <tr>
                <th>ID</th>
                <th>Código</th>
                <th>Nombre</th>
                <th>Cantidad</th>
                <th>Unidad</th>
                <th>Precio</th>
                <th>Fecha de creación</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $product->id }}</td>
                <td>{{ $product->code }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->ammount }}</td>
                <td>{{ $product->unit }}</td>
                <td class="price-cell">${{ number_format($product->price, 0, ',', '.') }}</td>
                <td>{{ $product->created_at->format('d-m-Y') }}</td>
            </tr>
        </tbody>
    </table>
    
    <div class="footer">
        <div class="footer-left">
            <p>Documento generado automáticamente por el Sistema de Gestión</p>
        </div>
        <div class="footer-right">
            <p>Generado el {{ \Carbon\Carbon::now()->format('d-m-Y H:i') }}</p>
            <p>Página 1 de 1</p>
        </div>
    </div>
</body>
</html>