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
	];


    protected function loadData(ObjectManager $manager)
    {

    	$this->createMany(SportCategory::class, 3, function($sportCategory, $count){


	        $sportCategory->setSportName(self::$sportNames[$count]);
	        $sportCategory->setThumbnailCollection(self::$thumbnails[$count]);


    	}); 
        
        $manager->flush();

    }
}
