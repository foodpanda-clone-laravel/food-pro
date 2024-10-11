<?php

namespace App\DTO;

class RevenueReportDTO extends BaseDTO
{
    public int $restaurant_id;   // The ID of the associated restaurant
    public int $branch_id;       // The ID of the associated branch
    public int $total_orders;    // The total number of orders
    public float $total_revenue; // The total revenue generated
    public string $report_month; // The month of the report

    public function __construct($data) {
        $this->restaurant_id = $data['restaurant_id'];
        $this->branch_id = $data['branch_id'];
        $this->total_orders = $data['total_orders'];
        $this->total_revenue = $data['total_revenue'];
        $this->report_month = $data['report_month'];
    }
}
