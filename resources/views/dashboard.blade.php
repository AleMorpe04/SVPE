<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>SVPE - Validación Estadística</title>

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 40px;
        }

        .container {
            width: 90%;
            margin: auto;
        }

        .card {
            background: white;
            padding: 25px;
            margin-bottom: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 40px;
        }

        h3 {
            margin-bottom: 20px;
        }

        button {
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            background-color: #007bff;
            color: white;
        }

        .resultado {
            margin-top: 15px;
            font-weight: bold;
        }

        canvas {
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="container">

    <h1>Sistema de Validación de Procesos Estocásticos (SVPE)</h1>

    <div class="card">
        <h3>Simulación Estadística</h3>
        <button onclick="simular()">Generar Simulación</button>
        <p id="resultado" class="resultado"></p>
    </div>

    <div class="card">
        <h3>Histograma - Prueba de Uniformidad</h3>
        <canvas id="histograma"></canvas>
    </div>

    <div class="card">
        <h3>Diagrama de Dispersión - Prueba de Independencia</h3>
        <canvas id="dispersión"></canvas>
    </div>

</div>

<!-- Archivo JS externo -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>