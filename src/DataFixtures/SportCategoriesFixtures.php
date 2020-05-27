<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\SportCategory; 

class SportCategoriesFixtures extends BaseFixture
{

	private static $sportNames = [
	       0 => 'Running',
	       1 => 'Basket-ball',
	       2 => 'Pétanque',  
	       3 => 'Tennis',
	       4 => 'Cyclisme',
	       5 => 'Foot en salle', 
	       6 => 'Badminton',
	       7 => 'VTT',
	       8 => 'Bowling',
	       9 => 'Longboard', 
	       10 => 'Billard', 
	   ];

	private static $thumbnails = [
			0 => [
				'/img/component/card/thumbnail_running_1.jpg',
        		'/img/component/card/thumbnail_running_2.jpg',
        		'/img/component/card/thumbnail_running_3.jpg',
			],

			1 => [
        		'/img/component/card/thumbnail_basket.jpg',
			],

			2 => [
        		'/img/component/card/thumbnail_petanque.jpg',
			],
			3 => [
        		'/img/component/card/thumbnail_tennis_1.jpg',
        		'/img/component/card/thumbnail_tennis_2.jpg',
			],
			4 => [
        		'/img/component/card/thumbnail_bike.jpg',
			],
			5 => [
        		'/img/component/card/thumbnail_indoor_soccer.jpg',
			],
			6 => [
        		'/img/component/card/thumbnail_badminton.jpg',
			],
			7 => [
        		'/img/component/card/thumbnail_cross_bike.jpg',
			],
			8 => [
        		'/img/component/card/thumbnail_bowling.jpg',
			],
			9 => [
        		'/img/component/card/thumbnail_longboard.jpg',
			],
			10 => [
        		'/img/component/card/thumbnail_pool.jpg',
			],
	];


    protected function loadData(ObjectManager $manager)
    {

    	$this->createMany(SportCategory::class, 11, function($sportCategory, $count){


	        $sportCategory->setSportName(self::$sportNames[$count]);
	        $sportCategory->setThumbnailCollection(self::$thumbnails[$count]);


    	}); 
        
        $manager->flush();

    }
}
