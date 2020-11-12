<?php   

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\{TextareaType,SubmitType};
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\HttpFoundation\Request;


class Friend extends AbstractController{

    const ME = 'moi';

    /**
    * @Route("/algo" , name="algo", methods={"GET", "POST"})
    */
    public function formFriendQuestion(Request $request){
        $defaultData = ['question' => 'Je suis ami avec Sophie---Est-ce que Sophie est mon amie?'];
        $form = $this->createFormBuilder($defaultData)
            ->add('question', TextareaType::class)
            ->add('submit', SubmitType::class)
            ->getForm();
    
        
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $question = $form->get('question')->getData('question');
            $result = $this->isFriend($question);
            $result = $result ? 'true' : 'false';
            return $this->redirectToRoute('answer', array(
                'result' => $result,
            ));  
        }
        
        return $this->render('friend/form.html.twig', [
            'formQuestion' => $form->createView(),
        ]);
    }

    /**
    * @Route("/answer/{result}" , name="answer", methods={"GET"})
    */
    public function resultQuestion($result){
        return $this->render('friend/is_friend.html.twig', [
            'result' => $result
        ]);
    }

    /* 
    * isFriend :Treatment of whether the question is true or false
    * @return Boolean
    */
    protected function isFriend(string $question){
        $splitString  = explode("---", $question);
        $sentence     = trim($splitString[0]);  
        $realQuestion = trim($splitString[1]); 

        $questionName    = $this->getNameInQuestion($realQuestion);
        $arrayNames      = $this->getMatriceArrayNames($sentence);
        $arrayFriendship = $this->buildFriendship($arrayNames, $sentence);
        
        return $this->correlation($arrayFriendship, $questionName);  
    }

    /* 
    * getNameInQuestion : return name of the question asked
    * @return string $questionName
    */
    protected function getNameInQuestion(String $string){
        $explodedQuestion = explode(" ", $string);
        return $explodedQuestion[2];
    }

    /* 
    * getMatriceArrayNames : Builds an array of  with  names of as indexes
    * @return array $arrayNames
    */
    protected function getMatriceArrayNames(String $string){
        // regex for get all words witg first letter in caps ( for names and I)
        preg_match_all("([A-Z][a-zA-Z]*\s*)", $string, $matches);

        $arrayNames = [];
        $matches = $matches[0];
        foreach( $matches as $matche ){
            $name = trim(preg_replace('/\s\s+/', '', $matche));
            if(!empty($name)){
                if(!array_key_exists($name, $arrayNames)){
                    $name = $this->isMe($name) ? $arrayNames[self::ME]= [] : $arrayNames[$name]= [];
                }
            }
        }
        return $arrayNames;
    }

    /* 
    * buildFriendship : Adds everyone's friendships in the array 
    * @return array $arrayNames
    */
    protected function buildFriendship(array $arrayNames, string $sentence){
        $arraySentence = explode("\r\n", $sentence);
        foreach($arraySentence as $friendship){
            if(!empty($friendship)){
                $arrayFriendship = explode(" ", $friendship); 
                $name1 = $arrayFriendship[0];                
                $name2 = end($arrayFriendship);
                
                $name1 = $this->isMe($name1) ? self::ME : $name1;
                $name2 = $this->isMe($name2) ? self::ME : $name2;

                array_push($arrayNames[$name1], $name2); 
                array_push($arrayNames[$name2], $name1); 
            }
        }
        return $arrayNames;    
    }

    /* 
    * correlation : Correlate the friends for each index
    * @return bool 
    */
    protected function correlation(array $arrayFriendship, string $questionName){
        // test most basic possibility first
        if (in_array($questionName, $arrayFriendship['moi'])) {
            return true;
        }
        foreach($arrayFriendship as $friend => $arrayValue){
            foreach($arrayValue as $value){
                $arrayFriendship[$friend] = array_unique(array_merge($arrayFriendship[$friend], $arrayFriendship[$value]), SORT_REGULAR);
            }
        }
        return in_array(self::ME, $arrayFriendship[$questionName]);
    }

    protected function isMe(string $string){
        $regex = "/(je)|(Je)/";
        $resultMatches = preg_match($regex, $string, $matches);
        return (bool) count($matches);
    }
}