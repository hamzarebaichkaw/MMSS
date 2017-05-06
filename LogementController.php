<?php

namespace LogementBundle\Controller;

use LogementBundle\Entity\Adress;
use LogementBundle\Entity\Logement;
use LogementBundle\Entity\Media;
use LogementBundle\Entity\Services;
use LogementBundle\Form\AdressType;
use LogementBundle\Form\LogementType;
use LogementBundle\Form\MediaType;
use LogementBundle\Form\ServicesType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManager;

class LogementController extends Controller
{


    public function AddLogementAction(Request $request)
    {

        $logement=new Logement();

        $form=$this->createForm(LogementType::class,$logement);
        if($form->handleRequest($request)->isValid()){
            $id_booker=1;
            $logement->setBookerId($id_booker);
            $excute=$this->getDoctrine()->getManager();

            $excute->persist($logement);
            $excute->  flush();


            return $this->redirectToRoute('Adress',array('id'=>$logement->getId()));

        }
           return $this->render('@Logement/Appotement.html.twig',array('form_logement'=>$form->createView()));

    }
    public function AjoutMediaAction(Request $request,$id){
        $media=new Media();
        $form_media=$this->createForm(MediaType::class,$media);
        $exlogement= $this->getDoctrine()->getManager();

        $logement=$exlogement->getRepository('LogementBundle:Logement')->find($id);
        if($form_media->handleRequest($request)->isValid()) {
            $file = $media->getBrochure();
            $media->setLogmentId($logement);
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move($this->getParameter('Brochure_dir'), $fileName);
            $media->setBrochure('http://localhost/MMSS/web/image_logement/' . $fileName);
            $excute_media = $this->getDoctrine()->getManager();
            $excute_media->persist($media);
            $excute_media->flush();
            return $this->redirectToRoute('Services', array('id' => $logement->getId()));
        }
        return $this->render('LogementBundle::LogementMedia.html.twig',array('medias'=>$form_media->createView()));

    }
    public function AdressAction(Request $request,$id){

$adress=new Adress();

$form=$this->createForm(AdressType::class,$adress);
        $exlogement= $this->getDoctrine()->getManager();
        $logement=$exlogement->getRepository('LogementBundle:Logement')->find($id);
if($form->handleRequest($request)->isValid()) {
    $excute = $this->getDoctrine()->getManager();
    $adress->setLogmentId($logement);
    $excute->persist($adress);
    $excute->flush();
    return $this->redirectToRoute('Medias',array('id'=>$logement->getId()));

}
        return $this->render('@Logement/AdressLogement.html.twig',array('form_logement'=>$form->createView()));

}

public function  ServicesLogementAction(Request $request ,$id){
        $services=new Services();
    $form=$this->createForm(ServicesType::class,$services);
    $exlogement= $this->getDoctrine()->getManager();
    $logement=$exlogement->getRepository('LogementBundle:Logement')->find($id);
    if($form->handleRequest($request)->isValid()) {
        $excute = $this->getDoctrine()->getManager();
        $services->setLogmentId($logement);
        $excute->persist($services);
        $excute->flush();
  return $this->redirectToRoute('homepage');
    }
    return $this->render('@Logement/Services_Logement.html.twig',array('Services_from'=>$form->createView()));

}
public function List_LogementAction(){
    //logement
   // $logements=new Logement();
    $em = $this->getDoctrine()->getManager();
    $query = $em->createQuery(
        'SELECT l.titre_logement AS tit, l.description AS descr, l.id AS lid, a.pays AS pay, a.cite AS cite, a.adress AS adr, m.brochure AS broch
    FROM LogementBundle:Logement l , LogementBundle:Adress a , LogementBundle:Media m
    WHERE l.id = a.Logment_id AND l.id = m.Logment_id
    '
    );
    $products = $query->getResult();

     /* $exucute_Logement=$this->getDoctrine()->getManager();
    $logements=$exucute_Logement->getRepository('LogementBundle:Logement')->findAll();
      $exucute_Adress=$this->getDoctrine()->getManager();

      $Adresse_Logement=$exucute_Adress->getRepository('LogementBundle:Adress')->findAll();
    $exucute_Media=$this->getDoctrine()->getManager();
    $Media_Logement=$exucute_Media->getRepository('LogementBundle:Media')->findAll();*/


    return $this->render('LogementBundle::List_Logement.html.twig',array('Logements'=>$products));
}

    public function HouserullAction( Request $request){

        $logement=new Logement();

        $form=$this->createForm(LogementType::class,$logement);
        if($form->handleRequest($request)->isValid()){
            $id_booker=$this->getUser();
           $logement->setBookerId($id_booker);
            $excute=$this->getDoctrine()->getManager();

            $excute->persist($logement);
            $excute->  flush();


            return $this->redirectToRoute('Adress',array('id'=>$logement->getId()));

        }
        return $this->render('@Logement/fullhouse.html.twig',array('form_logement'=>$form->createView()));





    }



    }
