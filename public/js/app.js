// =====================================
// SVPE - FRONTEND VISUALIZACIÓN
// Archivo: public/js/app.js
// =====================================


// ==============================
// DATOS SIMULADOS (MOCK)
// ==============================

let chartHistograma = null;
let chartScatter = null;

// ==============================
// FUNCIÓN PRINCIPAL
// ==============================
async function simular() {

    const resultado = document.getElementById("resultado");

    try {

        const response = await fetch('/api/generar', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                seed: 5,
                a: 3,
                c: 7,
                m: 100,
                n: 10
            })
        });

        const data = await response.json();

        if (!response.ok) {
            throw new Error("Error en el servidor");
        }

        // 🔹 Mostrar conclusiones reales
        resultado.innerHTML = `
            <strong>Ji-Cuadrada:</strong> ${data.ji_cuadrada.conclusion} <br>
            <strong>Rachas:</strong> ${data.rachas.conclusion}
        `;

        // 🔹 Graficar números normalizados reales
        generarHistograma(data.numeros_normalizados);
        generarScatter(data.numeros_normalizados);

    } catch (error) {
        resultado.innerText = "Error al conectar con el backend.";
        console.error(error);
    }
}


// ==============================
// HISTOGRAMA (UNIFORMIDAD)
// ==============================
function generarHistograma(data) {

    const intervalos = 5;
    const frecuencias = new Array(intervalos).fill(0);

    data.forEach(num => {
        let index = Math.floor(num * intervalos);

        if (index === intervalos) {
            index--;
        }

        frecuencias[index]++;
    });

    const labels = [
        "0 - 0.2",
        "0.2 - 0.4",
        "0.4 - 0.6",
        "0.6 - 0.8",
        "0.8 - 1"
    ];

    const canvas = document.getElementById('histograma');
    if (!canvas) return;

    const ctx = canvas.getContext('2d');

    if (chartHistograma) {
        chartHistograma.destroy();
    }

    chartHistograma = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Frecuencia Observada',
                data: frecuencias,
                backgroundColor: 'rgba(54, 162, 235, 0.6)'
            }]
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Distribución de Frecuencias'
                }
            }
        }
    });
}


// ==============================
// SCATTER (INDEPENDENCIA)
// ==============================
function generarScatter(data) {

    const scatterData = data.map((valor, indice) => {
        return {
            x: indice + 1,
            y: valor
        };
    });

    const canvas = document.getElementById('dispersión');
    if (!canvas) return;

    const ctx = canvas.getContext('2d');

    if (chartScatter) {
        chartScatter.destroy();
    }

    chartScatter = new Chart(ctx, {
        type: 'scatter',
        data: {
            datasets: [{
                label: 'Valores Generados',
                data: scatterData,
                backgroundColor: 'rgba(255, 99, 132, 0.7)'
            }]
        },
        options: {
            responsive: true,
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Índice'
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'Valor'
                    },
                    min: 0,
                    max: 1
                }
            }
        }
    });
} 