<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\SportEvent; 
use App\Entity\User; 
use App\Entity\SportCategory; 
use App\DataFixtures\UserFixtures;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;


class SportEventFixture extends BaseFixture implements DependentFixtureInterface
{

	private static $eventTitles = [
	       'Course autour du lac',
	       'Compétition amicale',
	       'Entrainements de reprise',
	       'Préparation en vue d\'une compet', 
	       'Séance d\'initiation', 
	   ];

	private static $thumbnailsUrl = [
			'/img/component/card/thumbnail_basket.jpg',
			'/img/component/card/thumbnail_petanque.jpg',
			'/img/component/card/thumbnail_running_1.jpg',
			'/img/component/card/thumbnail_running_2.jpg',
			'/img/component/card/thumbnail_running_3.jpg',
	];

	private static $eventLevels = [
			'Séance initiation',
			'Tous niveaux',
			'Confirmés',
			'Experts',
			'Fou furieux',
	];


	private function getSportCategories(ObjectManager $manager){

			$sportCatRepo = $manager->getRepository(SportCategory::class);
			$sportCategories = $this->sportCatRepo->findAll();

			return $sportCategories;
	}

	

    public function loadData(ObjectManager $manager)
    {

        $this->createMany(SportEvent::class, 15, function($event, $count){



        	$event->setTitle($this->faker->randomElement(self::$eventTitles))
				   ->setDescription($this->faker->paragraph(3, true))
				   ->setOrganiser($this->getRandomReference(User::class))
				   ->setLocationDpt($this->faker->numberBetween(10000, 95000))
				   ->setLocationCity($this->faker->city())
				   ->setLocationAddress($this->faker->address())
				   ->setLocationDescription($this->faker->paragraph(3, true))
				   ->setThumbnail($this->faker->randomElement(self::$thumbnailsUrl))
				   ->addPlayer($event->getOrganiser())
				   ->addPlayer($this->getRandomReference(User::class))
				   ->setLevel($this->faker->randomElement(self::$eventLevels))
				   ->setLevelDescription($this->faker->paragraph(4, true))
				   ->setMaterial($this->faker->sentences(3, false))
				   ->setPriceDescription($this->faker->paragraph(4, true))
				   ->setCreatedAt(new \DateTime("now"))
				   ->setUpdatedAt(new \DateTime("now"))
				   ->setDate($this->faker->dateTimeBetween('1 days' , '6 months'))
				   ->setTimeStart($this->faker->dateTimeBetween('1 days' , '6 months'))
				   ->setTimeEnd($this->faker->dateTimeBetween('1 days' , '6 months'))
				   ->setSportCategory($this->getRandomReference(SportCategory::class))
				   ->setOtherAttributes($this->faker->sentences(3, false))
				   ->setMaxPlayers($this->faker->numberBetween(3, 20)) 

				   ; 

        }); 

        $manager->flush();

    }
    public function getDependencies()
    {
        return array(
            UserFixtures::class,

        );
    }
}
