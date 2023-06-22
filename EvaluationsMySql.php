<?php

/*
 * Выбрать без join-ов и подзапросов все департаменты, в которых есть мужчины, и все они (каждый)
 * поставили высокую оценку (строго выше 5).
 */

require __DIR__ . '/index.php';
setEnv();

function getDataEvaluations(): array
{
    $uid1 = uniqid();
    $uid2 = uniqid();
    $uid3 = uniqid();
    $uid4 = uniqid();
    $uid5 = uniqid();
    $uidDep1 = uniqid();
    $uidDep2 = uniqid();
    $uidDep3 = uniqid();

    return [
        ['respondent_id' => $uid1, 'department_id' => $uidDep1, 'gender' => 1, 'value' => 3],
        ['respondent_id' => $uid2, 'department_id' => $uidDep2, 'gender' => 1, 'value' => 6],
        ['respondent_id' => $uid3, 'department_id' => $uidDep3, 'gender' => 0, 'value' => 6],
        ['respondent_id' => $uid4, 'department_id' => $uidDep1, 'gender' => 0, 'value' => 3],
        ['respondent_id' => $uid5, 'department_id' => $uidDep3, 'gender' => 1, 'value' => 7],
    ];
}

function createEvaluationsTable()
{
    $sql = "CREATE TABLE IF NOT EXISTS `evaluations` (`respondent_id` varchar(37) primary key, `department_id` varchar(37), `gender` boolean, `value` integer)";
    makeQuery($sql);
}

function seedEvaluation(string $respondentId, string $departmentId, string $gender, int $value): void
{
    $sql = "INSERT INTO `evaluations` (`respondent_id`, `department_id`, `gender`, `value`) VALUES ('{$respondentId}', '{$departmentId}', {$gender}, {$value});";
    makeQuery($sql);
}

function seedEvaluations(): void
{
    $sql = "select * from `evaluations`;";
    $res = makeQuery($sql);
    if (!empty($res)) {
        return;
    }

    $data = getDataEvaluations();

    foreach ($data as $item) {
        seedEvaluation($item['respondent_id'], $item['department_id'], '"' . $item['gender'] . '"', $item['value']);
    }
}

function createDataEvaluations(): void
{
    createEvaluationsTable();
    seedEvaluations();
}

function findEvaluations(): void
{
    createDataEvaluations();
    $sql = "SELECT department_id from evaluations
                where gender = true and value > 5 group by department_id";
    makeQuery($sql);
    var_dump($sql);
}

findEvaluations();
