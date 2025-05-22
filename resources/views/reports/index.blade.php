<x-layout title="Relatório de Faturas">
    <div class="row">
        <div id="grafico-faturas" class="col-6"></div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
    const options = {
        chart: { type: 'bar' },
        series: @json($series),
        xaxis: {
            categories: @json($categories)
        },
        dataLabels: { enabled: false },
        plotOptions: {
          bar: {
            horizontal: false,
            columnWidth: '55%',
            borderRadius: 5,
            borderRadiusApplication: 'end'
          },
        },
        fill: {
          opacity: 1
        },
    };

    const chart = new ApexCharts(document.querySelector("#grafico-faturas"), options);
    chart.render();
    </script>
</x-layout>