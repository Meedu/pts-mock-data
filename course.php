<?php
require_once 'vendor/autoload.php';

$config = require_once './config.php';

ini_set('memory_limit', '512M');

$faker = Faker\Factory::create();

$now = date('Y-m-d H:i:s');

$courseRows = [];
$videoRows = [];

for ($i = 10001; $i < 10001 + $config['course']['num']; $i++) {
    $desc = $faker->text();
    $courseRows[] = sprintf(
        //id,user_id,title,slug,thumb,charge,short_description,original_desc,render_desc,seo_kewords,seo_description,published_at,is_show,
        '(%d, 0, "%s", "%s", "%s", 0, "","%s","%s","","","%s",1,"%s","%s",1001,0,0,0)',
        $i,
        $faker->title(),
        $faker->slug(),
        'https://mock.com/mock.png',
        $desc,
        $desc,
        $now,
        $now,
        $now
    );
    for ($j = 0; $j <= $config['course']['video_num']; $j++) {
        $videoRows[] = sprintf(
            '(%d, "%s", "%s", "%s", 0, 0, "", "", "", "", "", "%s", 1, "%s", "%s", "", 0, 1000, "",0,0,0)',
            $i,
            $faker->title(),
            $faker->slug(),
            $faker->url(),
            $now,
            $now,
            $now,
        );
    }
}

$sql = 'INSERT INTO `course_categories` (`id`, `name`, `parent_id`, `parent_chain`, `is_show`, `sort`, `created_at`, `updated_at`) VALUES ';
$sql .= '(1001, "meedu分类", 0, "", 1, 1, "2022-07-17 14:14:14", "2022-07-17 14:14:14");';

$sql .= "\n\n";

$sql .= 'INSERT INTO `courses` (`id`, `user_id`, `title`, `slug`, `thumb`, `charge`, `short_description`, `original_desc`, `render_desc`, `seo_keywords`, `seo_description`, `published_at`, `is_show`, `created_at`, `updated_at`, `category_id`, `is_rec`, `user_count`, `is_free`) VALUES ';
$sql .= implode(',', $courseRows) . ';';

$sql .= "\n\n";

$sql .= "INSERT INTO `videos` (`course_id`, `title`, `slug`, `url`, `charge`, `view_num`, `short_description`, `original_desc`, `render_desc`, `seo_keywords`, `seo_description`, `published_at`, `is_show`, `created_at`, `updated_at`, `aliyun_video_id`, `chapter_id`, `duration`, `tencent_video_id`, `is_ban_sell`, `free_seconds`, `ban_drag`) VALUES ";
$sql .= implode(',', $videoRows) . ';';


file_put_contents('./data/' . date('Y-m-d') . '_courses.sql', $sql);

echo 'success';
