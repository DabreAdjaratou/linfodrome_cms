<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Article\Article::class, function (Faker $faker) {
    return [
    	'ontitle'=>$faker->sentence,
    	'title'=>$faker->sentence,
    	'alias'=>str_slug($faker->title),
    	'category_id'=>$faker->numberBetween($min = 1, $max = 25),
         'published'=>$faker->numberBetween($min = 0, $max = 3),
    	'featured'=>$faker->numberBetween($min = 0, $max = 1),
    	'image'=>'houphouet-40003.jpg',
    	'image_legend'=>null,
    	'video'=>null,
    	'gallery_photo'=>null,
    	'introtext'=>$faker->paragraph,
    	'fulltext'=>$faker->text($maxNbChars = 1000),  
    	'source_id'=>$faker->numberBetween($min = 1, $max = 3),
    	'keywords'=>'[{"value":"linfodrome.com"},{"value":"linfodrome.ci"},{"value":"linfodrome"},{"value":"abidjan"},{"value":"cote d\'ivoire"},{"value":"municipales"},{"value":"port-bouet"},{"value":"2018"}]',
    	'created_by'=>$faker->numberBetween($min = 1, $max = 1000),
    	'created_at'=>now(),
    	'start_publication_at'=>$faker->dateTime($max = 'now', $timezone = null),
    	'stop_publication_at'=>$faker->dateTime(),
    	'checkout'=>0,
    	'views'	=>$faker->numberBetween($min = 1000, $max = 9000)
    ];
});
