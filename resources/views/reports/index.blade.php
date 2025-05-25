<x-layout title="Relatório de Faturas">
    <div class="row">
        <div id="statement_by_month" class="col-6"></div>
        <div id="statement_by_month_by_category" class="col-6"></div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
    const optionsStatements = {
        chart: { type: 'bar' },
        series: @json($report['statementByMonth']['series']),
        xaxis: {
            categories: @json($report['statementByMonth']['categories'])
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

    const optionsStatementsByCategory = {
        chart: { type: 'bar' },
        series: @json($report['statementByMonthByCategory']['series']),
        xaxis: {
            categories: @json($report['statementByMonthByCategory']['categories'])
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

    const chartStatements = new ApexCharts(document.querySelector("#statement_by_month"), optionsStatements);
    const chartStatementsByCategory = new ApexCharts(document.querySelector("#statement_by_month_by_category"), optionsStatementsByCategory);

    chartStatements.render();
    chartStatementsByCategory.render();
    </script>
</x-layout>