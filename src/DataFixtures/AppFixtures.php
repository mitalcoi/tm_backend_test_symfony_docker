<?php

namespace App\DataFixtures;

use App\Entity\QuestionnaireRoot;
use App\Entity\QuestionWithAnswers;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $samples = json_decode(file_get_contents(__DIR__.'/test_samples.json'));
        $root =new QuestionnaireRoot();
        $i = 0;
        foreach ($samples as $question => $answerOptions) {
           $this->addReference('question_'.$i, $root->addQuestion(uuid_create(), $question, $answerOptions));
           $i++;
        }
        $manager->persist($root);
        $manager->flush();
    }
}
