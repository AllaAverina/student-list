<?php

namespace StudentList\Helpers;

use StudentList\Models\StudentModel\StudentGateway;

class Paginator
{
    private $gateway;
    private $currentPage = 1;
    private $lastPage = 1;
    private $diff = 1;

    public function __construct(StudentGateway $gateway)
    {
        $this->gateway = $gateway;
    }

    public function setCurrentPage(int $currentPage): void
    {
        $this->currentPage = $currentPage;
    }

    public function setLastPage(int $itemsPerPage, string $search): void
    {
        if ($search) {
            $count = $this->gateway->getSearchCount($search);
        } else {
            $count = $this->gateway->getCount();
        }
        $this->lastPage = (int)ceil($count / $itemsPerPage);
    }

    public function setDiff(int $diff): void
    {
        $this->diff = $diff;
    }

    public function getCurrentPage(): int
    {
        return $this->currentPage;
    }

    public function getLastPage(): int
    {
        return $this->lastPage;
    }

    public function getStartPagination(): int
    {
        if ($this->currentPage > $this->diff) {
            return $this->currentPage - $this->diff;
        }
        return $this->currentPage;
    }

    public function getEndPagination(): int
    {
        if ($this->currentPage + $this->diff < $this->lastPage) {
            return $this->currentPage + $this->diff;
        }
        return $this->lastPage;
    }
}
