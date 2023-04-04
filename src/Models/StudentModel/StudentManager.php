<?php

namespace StudentList\Models\StudentModel;

use StudentList\Models\StudentModel\{StudentGateway, Student};

class StudentManager
{
    protected $gateway;

    public function __construct(StudentGateway $gateway)
    {
        $this->gateway = $gateway;
    }

    public function getStudent(?int $id): object
    {
        if ($id) {
            $student = $this->gateway->getById($id);
            if ($student) {
                return $student;
            }
        }
        return new Student();
    }

    public function save(Student $student): void
    {
        $id = $student->getId();
        if ($id) {
            $this->gateway->update($student);
        } else {
            $this->gateway->insert($student);
        }
    }

    public function getStudentList(int $currentPage, int $limit, array $query): array
    {
        $columns = ['firstname', 'lastname', 'groupNumber', 'examScores'];
        $sort = (in_array(($query['sort'] ?? ''), $columns)) ? $query['sort'] : 'examScores';
        $order = (isset($query['order']) && $query['order'] === 'DESC') ? 'DESC' : 'ASC';
        $search = $query['search'] ?? null;
        $offset = ($currentPage - 1) * $limit;

        if ($search) {
            $search = trim(strval($search));
            return $this->gateway->findSorted($sort, $order, $limit, $offset, $search);
        }
        return $this->gateway->getSorted($sort, $order, $limit, $offset);
    }
}
