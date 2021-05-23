<?php

namespace App\Controller;

use App\Document\CSV_Upload;
use App\Form\Type\ShowType;
use App\Form\Type\UploadType;
use App\Service\FileUploader;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Console\Output\ConsoleOutput;
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
 * @Route("/")
 */
public function index()
{
    return $this->render('upload/index.html.twig');
}


/**
  *@Route("/newCreate", name = "newCreate")
  */
    public function newCreate(DocumentManager $dm, Request $request, FileUploader $fileUploader)
    {
        $upload = new CSV_Upload();
        $form = $this->createForm(UploadType::class, $upload);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {

            $content = $form->get('file_content')->getData();
            
            if($content)
            {
                $originalFilename = pathinfo($content->
                                    getClientOriginalName(),PATHINFO_FILENAME);
                $mimeType = pathinfo($content->
                                    getClientMimeType(), PATHINFO_EXTENSION);
                if($mimeType == 'ms-excel'){
                    $mimeType = 'csv';
                }
                $newFilename = $originalFilename.'.'.$mimeType;

                try{
                    $content->move(
                        $this->getParameter('content_directory'),$newFilename
                    );
                } catch (FileException $e) {

                }
                $upload->setFileName($newFilename);

                $file = 'C:/xampp/htdocs/Symfony-assignment/CSV_Upload/public/uploads/content/'. $newFilename;
                $filedata = file_get_contents($file);

                $serializer = new Serializer([new ObjectNormalizer()], [new CsvEncoder()]);
                $serializer = $this->get('serializer');
               $data = $serializer->encode($filedata, 'csv');
            // $da = $serializer->decode($data,'csv');
            // dd($da);

                $upload->setFileContent($data);

                $uploader = $form->get('uploadedBy')->getData();
                $upload->setUploadedBy($uploader);
               
            }
            $dm->persist($upload);
            $dm->flush(); 
           
            return $this->redirectToRoute('app_upload_content',
                    array('id' => $upload->getId()));
        }
         return $this->render('upload/new.html.twig',[
        'form' => $form->createView(),
         ]);
    }

    /**
     * @Route("/content/{id}", name="app_upload_content")
     */
    public function upload_content(Request $request, $id, DocumentManager $dm)
    {
        $fileId = $request->attributes->get('id');
        $upload = $dm->getRepository(CSV_Upload::class)->find($fileId);

        if (!$upload) {
            throw $this->createNotFoundException(
                'No product found for id '.$fileId
            );
        }
        return $this->render('upload/show.html.twig',[
            'filename' => $upload->getFileName(),
            'fileContent' => $upload->getFileContent(),
            'uploadedBy' => $upload->getUploadedBy(),
        ]);
    }

    public function csv()
    {
        $serializer = new Serializer([new ObjectNormalizer()], [new CsvEncoder()]);
        $serializer = $this->get('serializer');

    }

}















