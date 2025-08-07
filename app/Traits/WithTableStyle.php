<?php

namespace App\Traits;

trait WithTableStyle
{
    public string $tableView = 'components.tables.simple';
    public string $tableStyle = 'bootstrap';
    public array $tableConfig = [];

    protected array $styleViews = [
        'tailwind' => 'components.tables.tailwind',
        'simple' => 'components.tables.simple',
        'custom' => 'components.tables.custom',
        // Agrega aquí más estilos y sus vistas correspondientes
    ];

    public function initializeWithTableStyle(): void
    {
        $this->tableStyle = $this->tableStyle ?? 'simple';
        $this->tableView = $this->styleViews[$this->tableStyle] ?? 'components.tables.simple';
        $this->tableConfig = $this->getDefaultTableConfig();
    }

    public function setTableStyle(string $style): void
    {
        $this->tableStyle = $style;
        //dd($style);
        // Actualizar automáticamente la vista correspondiente al estilo
        $this->tableView = $this->styleViews[$style] ?? $this->styleViews['simple'];
        //dd($this->tableView);
        $this->tableConfig = match($style) {
            'simple' => $this->getDefaultTableConfig(),
            'bootstrap' => $this->getDefaultTableConfig(),
            'tailwind' => $this->getTailwindConfig(),
            'custom' => $this->getCustomConfig(),
            default => $this->getDefaultTableConfig()
        };
    }

    public function setTableView(string $view): void
    {
        if (!view()->exists($view)) {
            throw new \InvalidArgumentException("La vista '$view' no existe");
        }
        $this->tableView = $view;
    }


    public function getTableView(): string
    {
        return $this->tableView;
    }

    // ... resto del código ...

    protected function getCustomConfig(): array
    {
        return [
            'table_class' => 'custom-table',
            'thead_class' => 'custom-thead',
            'tbody_class' => 'custom-tbody',
            'tr_class' => 'custom-tr',
            'th_class' => 'custom-th',
            'td_class' => 'custom-td',
            'pagination_class' => 'custom-pagination',
            'search_class' => 'custom-search',
            'per_page_class' => 'custom-per-page',
            'wrapper_class' => 'custom-wrapper',
            'action_button_class' => 'custom-button',
            'action_wrapper_class' => 'custom-actions',
        ];
    }
}
