chartIds.forEach((id, index) => {
  const ctx = document.getElementById(id);
  if (ctx) {
    new Chart(ctx, {
      type: "bar",
      data: {
        labels: [" Tests", " Released", " Attempted"],
        datasets: [
          {
            data: chartData[index],
            backgroundColor: "#9b2c2c",
            borderRadius: 4,
            barThickness: 30,
            minBarLength: 6
          },
        ],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false
          },
          tooltip: {
            callbacks: {
              label: function (context) {
                return `${context.formattedValue}`;
              }
            }
          },
          datalabels: {
              display: true,  
            anchor: 'end',
            align: 'end',
            color: '#000',
            font: {
              weight: 'bold'
            },
            formatter: Math.round
          }
        },
        scales: {
          x: {
            grid: {
              display: false
            }
          },
          y: {
            beginAtZero: true,
            suggestedMax: Math.max(...chartData[index]) + 20, //  IMPORTANT
            grid: {
              color: '#f0f0f0'
            },
            ticks: {
              precision: 0
            }
          }
        }
      },
      plugins: [ChartDataLabels] 
    });
  }
});
