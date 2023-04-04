<?php

use StudentList\Helpers\{LinkBuilder, Marker};
?>

<main>
    <nav class="navbar navbar-light bg-light">
        <div class="container-fluid">
            <a class="btn btn-outline-primary my-2" href="/form">Редактировать личную информацию</a>
            <form action="/">
                <div class="input-group">
                    <input class="form-control" type="search" name="search" id="search" placeholder="Поиск" value="<?= htmlspecialchars($search) ?>">
                    <input type="submit" value="Найти" class="btn btn-outline-primary">
                </div>
            </form>
        </div>
    </nav>
    <h1 class="text-center">Список студентов</h1>
    <?php if ($search) : ?>
        <div class="text-center">
            <div>Показаны результаты, найденные по запросу «<?= htmlspecialchars($search) ?>»</div>
            <a class="link-primary" href="/">Показать всех</a>
        </div>
    <?php endif; ?>
    <table class="table table-bordered table-sm table-hover">
        <thead class="table-primary">
            <tr>
                <th>Имя
                    <a href="<?= LinkBuilder::getSortingLink('firstname') ?>" title="По возрастанию">▲</a>
                    <a href="<?= LinkBuilder::getSortingLink('firstname', 'DESC') ?>" title="По убыванию">▼</a>
                </th>
                <th>Фамилия
                    <a href="<?= LinkBuilder::getSortingLink('lastname') ?>" title="По возрастанию">▲</a>
                    <a href="<?= LinkBuilder::getSortingLink('lastname', 'DESC') ?>" title="По убыванию">▼</a>
                </th>
                <th>Номер группы
                    <a href="<?= LinkBuilder::getSortingLink('groupNumber') ?>" title="По возрастанию">▲</a>
                    <a href="<?= LinkBuilder::getSortingLink('groupNumber', 'DESC') ?>" title="По убыванию">▼</a>
                </th>
                <th>Баллы ЕГЭ
                    <a href="<?= LinkBuilder::getSortingLink('examScores') ?>" title="По возрастанию">▲</a>
                    <a href="<?= LinkBuilder::getSortingLink('examScores', 'DESC') ?>" title="По убыванию">▼</a>
                </th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($students as $student) :
                if ($search) : ?>
                    <tr>
                        <td><?= Marker::mark($student->getFirstname(), $search) ?></td>
                        <td><?= Marker::mark($student->getLastname(), $search) ?></td>
                        <td><?= Marker::mark($student->getGroupNumber(), $search) ?></td>
                        <td><?= Marker::mark($student->getExamScores(), $search) ?></td>
                    </tr>
                <?php else : ?>
                    <tr>
                        <td><?= htmlspecialchars($student->getFirstname()) ?></td>
                        <td><?= htmlspecialchars($student->getLastname()) ?></td>
                        <td><?= htmlspecialchars($student->getGroupNumber()) ?></td>
                        <td><?= htmlspecialchars($student->getExamScores()) ?></td>
                    </tr>
            <?php endif;
            endforeach; ?>
        </tbody>
    </table>
    <nav>
        <ul class="pagination justify-content-center">
            <?php if ($paginator->getStartPagination() > 1) : ?>
                <li class="page-item">
                    <a class="page-link" href="<?= LinkBuilder::getPageLink(1) ?>"><?= 1 ?></a>
                </li>
            <?php endif; ?>
            <?php if ($paginator->getStartPagination() > 2) : ?>
                <li class="page-item">
                    <p class="page-link">...</p>
                </li>
            <?php endif; ?>
            <?php for ($i = $paginator->getStartPagination(); $i <= $paginator->getEndPagination(); $i++) :
                if ($i === $paginator->getCurrentPage()) : ?>
                    <li class="page-item active">
                        <p class="page-link"><?= $paginator->getCurrentPage() ?></p>
                    </li>
                <?php else : ?>
                    <li class="page-item">
                        <a class="page-link" href="<?= LinkBuilder::getPageLink($i) ?>"><?= $i ?></a>
                    </li>
                <?php endif; ?>
            <?php endfor; ?>
            <?php if ($paginator->getEndPagination() < $paginator->getLastPage() - 1) : ?>
                <li class="page-item">
                    <p class="page-link">...</p>
                </li>
            <?php endif; ?>
            <?php if ($paginator->getEndPagination() < $paginator->getLastPage()) : ?>
                <li class="page-item">
                    <a class="page-link" href="<?= LinkBuilder::getPageLink($paginator->getLastPage()) ?>"><?= $paginator->getLastPage() ?></a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
</main>