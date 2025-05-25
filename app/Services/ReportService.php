<?php

namespace App\Services;

use App\Repositories\StatementRepository;

class ReportService
{
    private StatementRepository $statementRepository;

    public function __construct(StatementRepository $statementRepository)
    {
        $this->statementRepository = $statementRepository;
    }

    public function generateMonthlyReport(int $userId)
    {
        $data = $this->statementRepository->reportMonthByMonth($userId);

        return $this->groupChartSeries($data, 'month', 'account', 'total');
    }

    public function generateMonthlyReportByCategory(int $userId)
    {
        $data = $this->statementRepository->reportMonthByMonthByCategory($userId);

        return $this->groupChartSeries($data, 'month', 'category', 'total');
    }

    private function groupChartSeries(array $data, string $categoryField, string $seriesField, string $valueField): array
    {
        $categories = [];
        $tempSeries = [];

        foreach ($data as $row) {
            $category = $row->{$categoryField};
            $series = $row->{$seriesField};
            $value = (float) $row->{$valueField};

            if (!in_array($category, $categories)) {
                $categories[] = $category;
            }

            $tempSeries[$series][$category] = $value;
        }

        sort($categories); // Sort categories (e.g.: months)

        $series = [];

        foreach ($tempSeries as $seriesName => $valuesByCategory) {
            $points = [];

            foreach ($categories as $cat) {
                $points[] = $valuesByCategory[$cat] ?? 0;
            }

            $series[] = [
                'name' => $seriesName,
                'data' => $points,
            ];
        }

        return [
            'categories' => $categories,
            'series' => $series,
        ];
    }
}
