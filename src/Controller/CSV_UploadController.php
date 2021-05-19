<?php

namespace App\Controller;

use App\Document\CSV_Upload;
use App\Form\Type\ShowType;
use App\Form\Type\UploadType;
use App\Service\FileUploader;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\HeaderUtils;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\String\Slugger\SluggerInterface;

class CSV_UploadController extends AbstractController
{

    /**
     * @Route("/testUpload", methods={"GET"})
     */
    public function testUpload(DocumentManager $dm) : Response
    {
        $upload = new CSV_Upload();
        $upload->setFileName("trial");
        $upload->setFileContent('C:\Users\urvashih\Documents\Images\urvashi-26th');
        // $upload->setUploadedAt(new \DateTime('now'));
        $dm->persist($upload);
        $dm->flush();
        // return new Response("Data Uploaded " . $upload->getFileName());

        return $this->render('upload/testUpload.html.twig',[
            'file_name' => $upload->getFileName(),
            'file_content' => $upload->getFileContent(),
            'chunkSize' => $upload->getChunkSize(),
            'uploadDate' => $upload->getUploadDate(),
        ]);
    }

    /**
     * @Route("/task")
     */
    public function task (Request $request) : Response
    {
        $upload = new CSV_Upload();
        //$upload->setFileName("trial-2");
        // $upload->setUploadedAt(new \DateTime('now'));

        $form = $this->createForm(UploadType::class,$upload);

        return $this->render('upload/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/formCreate")
     */

    public function formCreate (Request $request, DocumentManager $dm )
    {
        $upload = new CSV_Upload();

        $form = $this->createForm(UploadType::class, $upload);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $upload = $form->getData();
            //
            $dm->persist($upload);
            $dm->flush();            

            return new Response(
                "Data Uploaded Successfully, Id - "
             . $upload->getId()
             . " , FileName = " 
             .$upload->getFileName() 
             . $upload->getFileContent()
            .$upload->getChunkSize());

            // return $this->redirectToRoute('Success');
        }

        return $this->render('upload/new.html.twig',[
            'form' => $form->createView(),
        ]);

    }

    /**
     * @Route("/findUpload")
     */
    public function showUpload(Request $request, DocumentManager $dm)
    {
        $upload = new CSV_Upload();
        $form = $this->createForm(ShowType::class, $upload);
        
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $upload = $dm->getRepository(CSV_Upload::class)->findAll($request);
            
            // $upload = $this->get('doctrine_mongodb')
            // ->getRepository(CSV_Upload::class)
            // ->findOneByFileId($request);
            
            if(! $upload){
                throw $this->createNotFoundException('Not Upload on this ID');
            }
            else
            {

                return new Response('Upload found, file name is' . $upload);
            }
        }
        return $this->render('upload/find.html.twig',[
            'form' => $form->createView(),
        ]);
    }
/**
 * @Route("/showImage")
 */
    public function showImage(DocumentManager $dm)
    {
        $upload = new CSV_Upload();
        $upload = $dm->createQueryBuilder('C:\Users\urvashih\Documents\Images\urvashi-26th')
            ->field('filename')->equals('trial')
            ->getQuery()
            ->getSingleResult();
            
        header('Content-type: image/png;');
        return $upload->getFileContent();
    }

    public function getContent(string $file_content)
    {
        $content = file_get_contents($file_content);
        return $content;
    }
////////////////////////////////////////////////////////

/**
  *@Route("/newCreate")
  */
    public function newCreate(DocumentManager $dm, Request $request, FileUploader $fileUploader)
    {
        $upload = new CSV_Upload();
        $form = $this->createForm(UploadType::class, $upload);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            //$content = $form->getData();

            $content = $form->get('content_of')->getData();

            if($content)
            {
              $file_content = $fileUploader->uploading($content);
              $upload->setFileContent($file_content);
            }

            $original = $content->getClientOriginalName();
            $file = 'C:/xampp/htdocs/Symfony-assignment/CSV_Upload/public/uploads/content/'. $original;
            $filedata = file_get_contents($file);


            $dm->persist($upload);
            $dm->flush(); 

            return new Response('Success '.$upload->getId().$filedata);
          //  return $this->redirectToRoute('app_upload_content');
        }
         return $this->render('upload/new.html.twig',[
        'form' => $form->createView(),
         ]);
    }

    /**
     * @Route("/success", name="app_upload_content")
     */
    public function success()
    {
        return new Response("Uploaded SuccessFully");
    }

    /**
     * @Route("/CSV")
     */
    public function CSVIndex()
    {
       // $serializer = new Serializer([new ObjectNormalizer()], [new CsvEncoder()]);
        // $serializer = $container->get('serializer');
        // $serializer->encode($data, 'csv');
        //$publicpath = '/../CSV_Upload/public/uploads/content/';
      //  $file_name = $serializer->decode(file_get_contents
        //('C:/xampp/htdocs/Symfony-assignment/CSV_Upload/public/uploads/content/data-csv.csv'), 'csv');
       // print_r($file_name);

      $originalName = 'data.csv';
      $file = 'C:/xampp/htdocs/Symfony-assignment/CSV_Upload/public/uploads/content/'. $originalName;
      $filedata = file_get_contents($file);

      $response = new Response($filedata);

        return new Response($response);

    }

}















