<?php

/*
 * В базе данных имеется таблица с товарами goods (id INTEGER, name TEXT), таблица с тегами tags (id INTEGER, name TEXT)
 * и таблица связи товаров и тегов goods_tags (tag_id INTEGER, goods_id INTEGER, UNIQUE(tag_id, goods_id)).
 * Выведите id и названия всех товаров, которые имеют все возможные теги в этой базе.
 */

require __DIR__ . '/index.php';
setEnv();

function createGoodsTable(): void
{
    $sql = "CREATE TABLE IF NOT EXISTS `goods` (`id` INTEGER, `name` TEXT)";
    makeQuery($sql);
}

function createTagsTable(): void
{
    $sql = "CREATE TABLE IF NOT EXISTS `tags` (`id` INTEGER, `name` TEXT)";
    makeQuery($sql);
}

function createGoodsTagsTable(): void
{
    $sql = "CREATE TABLE IF NOT EXISTS `goods_tags` (`tag_id` INTEGER, `goods_id` INTEGER, UNIQUE(`tag_id`, `goods_id`))";
    makeQuery($sql);
}

function migrateGoods()
{
    createGoodsTable();
    createTagsTable();
    createGoodsTagsTable();
}

function seedGood(int $id, string $name): void
{
    $sql = "INSERT INTO `goods` (`id`, `name`) VALUES ({$id}, '{$name}')";
    makeQuery($sql);
}

function seedTag(int $id, string $name): void
{
    $sql = "INSERT INTO `tags` (`id`, `name`) VALUES ({$id}, '{$name}');";
    makeQuery($sql);
}

function seedGoodTag(int $tagId, int $goodsId): void
{
    $sql = "INSERT INTO `goods_tags` (`tag_id`, `goods_id`) VALUES ({$tagId}, '{$goodsId}');";
    makeQuery($sql);
}

function getDataGoods(): array
{
    return [
        'goods' => [
            ['id' => 1, 'name'  => 'good1'],
            ['id' => 2, 'name'  => 'good2'],
            ['id' => 3, 'name'  => 'good3'],
            ['id' => 4, 'name'  => 'good4'],
            ['id' => 5, 'name'  => 'good5'],
        ],
        'tags' => [
            ['id' => 1, 'name'  => 'tags1'],
            ['id' => 2, 'name'  => 'tags2'],
            ['id' => 3, 'name'  => 'tags3'],
            ['id' => 4, 'name'  => 'tags4'],
        ],
        'goods_tags' => [
            ['tag_id' => 1, 'goods_id' => 3],
            ['tag_id' => 2, 'goods_id' => 3],
            ['tag_id' => 3, 'goods_id' => 3],
            ['tag_id' => 4, 'goods_id' => 3],
            ['tag_id' => 1, 'goods_id' => 2],
            ['tag_id' => 2, 'goods_id' => 4],
            ['tag_id' => 4, 'goods_id' => 5],
            ['tag_id' => 1, 'goods_id' => 5],
            ['tag_id' => 2, 'goods_id' => 5],
            ['tag_id' => 3, 'goods_id' => 5],
        ]
    ];
}

function seedGoods(): void
{
    $sql = "select * from `goods`;";
    $res = makeQuery($sql);
    if (!empty($res)) {
        return;
    }

    $data = getDataGoods();

    $goods = $data['goods'];
    $tags = $data['tags'];
    $goodsTags = $data['goods_tags'];

    foreach ($goods as $good) {
        seedGood($good['id'], $good['name']);
    }

    foreach ($tags as $tag) {
        seedTag($tag['id'], $tag['name']);
    }

    foreach ($goodsTags as $goodTag) {
        seedGoodTag($goodTag['tag_id'], $goodTag['goods_id']);
    }
}

function createDataGoods(): void
{
    migrateGoods();
    seedGoods();
}

function findGoods(): void
{
    createDataGoods();
    $sql = "SELECT goods.id, goods.name from goods
                where (select count(tag_id) from goods_tags where goods_id = goods.id)=(select count(id) from tags);";
    makeQuery($sql);
    var_dump($sql);
}

findGoods();
