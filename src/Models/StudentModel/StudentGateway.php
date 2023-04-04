<?php

namespace StudentList\Models\StudentModel;

use StudentList\Database\Connection;
use StudentList\Models\StudentModel\Student;

class StudentGateway
{
    protected $table;
    protected $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
        $this->table = 'students';
    }

    public function getById(int $id): object
    {
        return $this->connection->getRow(
            "SELECT * FROM `$this->table` WHERE `id`=:id",
            Student::class,
            [':id' => $id]
        );
    }

    public function getSorted(string $sort, string $order, int $limit, int $offset): array
    {
        return $this->connection->getRows(
            "SELECT * FROM `$this->table` ORDER BY `$sort` $order LIMIT $limit OFFSET $offset",
            Student::class
        );
    }

    public function findSorted(string $sort, string $order, int $limit, int $offset, string $search = null): array
    {
        return $this->connection->getRows(
            "SELECT * FROM `$this->table` WHERE CONCAT(`firstname`, `lastname`, `groupNumber`, `examScores`) LIKE :search
            ORDER BY `$sort` $order LIMIT $limit OFFSET $offset",
            Student::class,
            [':search' => "%$search%"]
        );
    }

    public function getCount(): int
    {
        return (int)$this->connection->getColumn("SELECT COUNT(*) FROM `$this->table`");
    }

    public function getSearchCount(string $search): int
    {
        return (int)$this->connection->getColumn(
            "SELECT COUNT(*) FROM `$this->table` WHERE CONCAT(`firstname`, `lastname`, `groupNumber`, `examScores`) LIKE :search",
            [':search' => "%$search%"]
        );
    }

    public function checkEmail(string $email, ?int $id): int
    {
        if ($id) {
            return (int)$this->connection->getColumn(
                "SELECT COUNT(*) FROM `$this->table` WHERE `email`=:email AND NOT `id`=:id",
                [':email' => $email, ':id' => $id]
            );
        }

        return (int)$this->connection->getColumn(
            "SELECT COUNT(*) FROM `$this->table` WHERE `email`=:email",
            [':email' => $email]
        );
    }

    public function update(Student $student): void
    {
        $sql = "UPDATE `$this->table` SET `firstname`=:firstname, `lastname`=:lastname, `gender`=:gender, `dateOfBirth`=:dateOfBirth,
        `email`=:email, `examScores`=:examScores, `groupNumber`=:groupNumber, `residence`=:residence WHERE `id`=:id";
        $this->connection->runQuery($sql, [
            ':id' => $student->getId(),
            ':firstname' => $student->getFirstname(),
            ':lastname' => $student->getLastname(),
            ':gender' => $student->getGender(),
            ':dateOfBirth' => $student->getDateOfBirth(),
            ':email' => $student->getEmail(),
            ':examScores' => $student->getExamScores(),
            ':groupNumber' => $student->getGroupNumber(),
            ':residence' => $student->getResidence(),
        ]);
    }

    public function insert(Student $student): void
    {
        $sql = "INSERT INTO `$this->table` (`firstname`, `lastname`, `gender`, `dateOfBirth`, `email`, `examScores`, `groupNumber`, `residence`)
        VALUES (:firstname, :lastname, :gender, :dateOfBirth, :email, :examScores, :groupNumber, :residence)";
        $this->connection->runQuery($sql, [
            ':firstname' => $student->getFirstname(),
            ':lastname' => $student->getLastname(),
            ':gender' => $student->getGender(),
            ':dateOfBirth' => $student->getDateOfBirth(),
            ':email' => $student->getEmail(),
            ':examScores' => $student->getExamScores(),
            ':groupNumber' => $student->getGroupNumber(),
            ':residence' => $student->getResidence()
        ]);
        $id = $this->connection->getLastInsertId();
        $student->setId($id);
    }
}
