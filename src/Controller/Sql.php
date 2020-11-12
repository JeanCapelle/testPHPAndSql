<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Sql extends AbstractController{
    
    /**
    * @Route("/sql" , name="sql", methods={"GET"})
    */
    public function DisplaySqlExercice(){
            $em = $this->getDoctrine()->getManager();
    
            $query = 'SELECT a.name, ur.author, ur.comment, ur.grade, ur.review_date  
            FROM (select ur.*, row_number() over (partition by artisan_id order by review_date desc) AS seqnum FROM user_review ur ) ur 
            INNER JOIN artisan AS a 
            ON ur.artisan_id = a.id
            where seqnum <= 3';
            
            $statement = $em->getConnection()->prepare($query);
            $statement->execute();
    
            $result = $statement->fetchAll();
            // dump($result);die;
            return $this->render('sql/query.html.twig', [
                'result' => $result,
                'query' => $query
            ]);
    }
}