<?php

namespace App\DataFixtures;

use App\Entity\ProcessType;
use App\Entity\Section;
use App\Entity\Stage;
use Conduction\CommonGroundBundle\Service\CommonGroundService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class ShertogenboschFixtures extends Fixture
{
    private $commonGroundService;
    private $params;

    public function __construct(CommonGroundService $commonGroundService, ParameterBagInterface $params)
    {
        $this->commonGroundService = $commonGroundService;
        $this->params = $params;
    }

    public function load(ObjectManager $manager)
    {
        // Lets make sure we only run these fixtures on larping enviroment
        if (
            $this->params->get('app_domain') != 'shertogenbosch.commonground.nu' &&
            strpos($this->params->get('app_domain'), 'shertogenbosch.commonground.nu') == false &&
            $this->params->get('app_domain') != 's-hertogenbosch.commonground.nu' &&
            $this->params->get('app_domain') != 'verhuizen.accp.s-hertogenbosch.nl' &&
            strpos($this->params->get('app_domain'), 'verhuizen.accp.s-hertogenbosch.nl') == false &&
            $this->params->get('app_domain') != 'verhuizen=.s-hertogenbosch.nl' &&
            strpos($this->params->get('app_domain'), 'verhuizen.s-hertogenbosch.nl') == false &&
            strpos($this->params->get('app_domain'), 's-hertogenbosch.commonground.nu') == false &&
            $this->params->get('app_domain') != 'zuid-drecht.nl' && strpos($this->params->get('app_domain'), 'zuid-drecht.nl') == false
        ) {
            return false;
        }

        /*
         *  Verhuizen
         */
        $id = Uuid::fromString('c8de2851-332d-4284-b86e-ba0615694427');
        $processType = new ProcessType();
        $processType->setName('Verhuizen');
        $processType->setIcon('fal fa-truck-moving');
        $processType->setDescription('Hier kunt u uw verhuizing doorgeven.');
        $processType->setSourceOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'4f387d0e-a2e5-44c0-9902-c31b63a8ee36'])); //'001709124'
        $processType->setRequestType($this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'request_types', 'id'=>'37812338-fa7c-46c5-a914-bcf17339a4c5']));
        $processType->setLogin('onSubmit');
        $manager->persist($processType);
        $processType->setId($id);
        $manager->persist($processType);
        $manager->flush();
        $processType = $manager->getRepository('App:ProcessType')->findOneBy(['id'=> $id]);

        $stage = new Stage();
        $stage->setName('Waarheen en Waneer');
        $stage->setDescription('Waarheen en waneer wilt u verhuizen');
        $stage->setIcon('fal fa-calendar');
        $stage->setSlug('gegevens');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setStage($stage);
        $section->setName('Datum en tijd');
        $section->setDescription('Datum en tijd van de verhuizing');
        $section->setProperties([]);
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'77aa09c9-c3d5-4764-9670-9ea08362341b']),
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'4b77bd59-d198-4aaf-ae0c-f66b16a6893d']),
        ]);
        $stage->addSection($section);

        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        $stage = new Stage();
        $stage->setName('Contact Gegevens');
        $stage->setDescription('Hoe kunnen wij u bereiken');
        $stage->setIcon('fal fa-calendar');
        $stage->setSlug('contact');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setStage($stage);
        $section->setName('Gegevens');
        $section->setDescription('Waar kunnen wij u bereiken als we vragen hebben over deze verhuizing');
        $section->setProperties([]);
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'32061b32-1f8d-4bd7-b203-52b22585f3c9']),
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'09cac491-a428-47eb-99ac-9717b1690620']),
        ]);
        $stage->addSection($section);

        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();

        $section = new Section();
        $section->setStage($stage);
        $section->setName('Notificatie');
        $section->setDescription('Mogen wij andere op de hoogste stellen van uw verhuizing?');
        $section->setProperties([]);
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component'=>'vtc', 'type'=>'properties', 'id'=>'f1964c98-df49-431a-a5e1-64c17d7d956b']),
        ]);
        $manager->persist($section);

        $manager->flush();

        $stage = new Stage();
        $stage->setName('gegevens organisatie');
        $stage->setDescription('De contactgegeven van de organisatie');
        $stage->setIcon('fas fa-users   ');
        $stage->setSlug('bedrijfgegevens');
        $stage->setProcess($processType);

        $section = new Section();
        $section->setStage($stage);
        $section->setName('Contactgegevens voor de tompoes');
        $section->setDescription('Wat zijn uw contactgegevens?');
        $section->setProperties([
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => 'ba8506d8-458e-4d6d-b88a-8107f960d9b5']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '009d51f1-c5bd-402c-8be4-bf79a00ea22f']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '42f011f7-a77d-48db-b415-d4bc0f0bf6dc']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '20d3b9cc-131a-4397-803f-2c43b6deb6ca']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '922f34e2-39db-4e0b-a98c-252ed7243945']),
            $this->commonGroundService->cleanUrl(['component' => 'vtc', 'type' => 'properties', 'id' => '2cc19bb6-808e-4cd2-80a9-d9404f134280']),
        ]);
        $stage->addSection($section);

        $processType->addStage($stage);
        $manager->persist($processType);
        $manager->flush();
    }
}
