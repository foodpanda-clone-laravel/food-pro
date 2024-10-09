<?php

namespace App\DTO;

class RevenueReportDTO extends BaseDTO
{
    public int $restaurant_id;   // The ID of the associated restaurant
    public int $branch_id;       // The ID of the associated branch
    public int $total_orders;     // The total number of orders
    public float $total_revenue;  // The total revenue generated
    public string $report_month;  // The month of the report

    public function __construct(
        int $restaurant_id,
        int $branch_id,
        int $total_orders,
        float $total_revenue,
        string $report_month
    ) {
        $this->restaurant_id = $restaurant_id;
        $this->branch_id = $branch_id;
        $this->total_orders = $total_orders;
        $this->total_revenue = $total_revenue;
        $this->report_month = $report_month;
    }
}
