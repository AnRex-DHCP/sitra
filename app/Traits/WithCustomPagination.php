<?php

namespace App\Traits;

trait WithCustomPagination
{
    public string $paginationView = 'components.pagination.bootstrap';
    public string $paginationTheme = 'bootstrap';

    public function initializeWithCustomPagination(): void
    {
        $this->paginationTheme = $this->paginationTheme ?? 'bootstrap';
        $this->paginationView = $this->paginationView ?? 'components.pagination.bootstrap';
    }

    public function getPaginationView(): string
    {
        return $this->paginationView;
    }

    public function setPaginationView(string $view): void
    {
        $this->paginationView = $view;
    }

    public function getPaginationTheme(): string
    {
        return $this->paginationTheme;
    }

    public function setPaginationTheme(string $theme): void
    {
        $this->paginationTheme = $theme;
    }

    public function paginationView()
    {
        return $this->getPaginationView();
    }
}
