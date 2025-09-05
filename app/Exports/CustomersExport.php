<?php

namespace App\Exports;

use App\Models\Customer;
use App\Models\Sortable\Direction;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

/**
 * Defines the export functionality for Customers.
 */
class CustomersExport implements FromQuery, WithHeadings, WithMapping
{
    /**
     * A field => value array of filters to apply to the export query.
     */
    protected array $filter = [];

    /**
     * The field by which to sort the export query.
     */
    protected string $sort;

    /**
     * The direction in which to sort the export query.
     */
    protected Direction $direction;

    /**
     * If true the export will be a template. Used by customers if they want an export file in the correct format
     */
    protected bool $template = false;

    /**
     * Defines the query to be used for the export.
     */
    public function query()
    {
        if ($this->template) {
            return Customer::query()->whereRaw('0=1');
        }

        return Customer::filter($this->filter)
            ->sortable($this->sort, $this->direction);
    }

    /**
     * The column headings for the export.
     */
    public function headings(): array
    {
        return [
            'Name',
            'Email',
            'Phone',
            'Organisation',
            'Job Title',
            'Date Of Birth',
        ];
    }

    /**
     * Defines the mapping of the export data.
     */
    public function map($row): array
    {
        return [
            'name' => $row->name,
            'email' => $row->email,
            'phone' => $row->phone,
            'organisation' => $row->organisation,
            'job_title' => $row->job_title,
            'date_of_birth' => $row->date_of_birth->format('Y-m-d'),
        ];
    }

    /**
     * Fluent setter to set the sorting direction for the export query
     */
    public function setDirection(Direction $direction): self
    {
        $this->direction = $direction;

        return $this;
    }

    /**
     * Fluent setter to set the sorting field for the export query
     */
    public function setSort(string $sort): self
    {
        $this->sort = $sort;

        return $this;
    }

    /**
     * Fluent setter to set the filters for the export query
     */
    public function setFilter(array $filter): self
    {
        $this->filter = $filter;

        return $this;
    }

    /**
     * Fluent setter to set the template flag for the export query
     */
    public function setTemplate(bool $template): self
    {
        $this->template = $template;

        return $this;
    }
}
