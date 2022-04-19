<?php

namespace App\Controller;

use App\Entity\Fournisseurs;
use App\Entity\Stocks;
use App\Form\FournisseursType;
use App\Form\StocksType;
use App\Repository\StocksRepository;
use Cassandra\Timestamp;
use Doctrine\ORM\Cache\TimestampRegion;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

// Include PhpSpreadsheet required namespaces
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class StocksController extends AbstractController
{
    /**
     * @Route("/stocks", name="app_stocks")
     */
    public function index(): Response
    {
        return $this->render('stocks/index.html.twig', [
            'controller_name' => 'StocksController',
        ]);
    }

    /**
     * @Route("/affS", name="affS")
     */

    public function afficheS(StocksRepository $repository)
    {
        $sto = $repository->findAll();
        return $this->render('stocks/AfficheS.html.twig',
            ['sto' => $sto]
        );

    }
    /**
     * @Route ("/Stocks/adds",name="adds")
     */

    public function add(Request $request)
    {
        $sto = new Stocks();
        $form = $this->createForm(StocksType::class, $sto);
        $form->add('Ajouter', SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($sto);
            $em->flush();
            return $this->redirectToRoute('affS');
        }
        return $this->render('stocks/AfficheS.html.twig', [
            'formS' => $form->createView()
        ]);

    }

    /**
     * @Route ("/stocks/updateS/{id}",name="updateS")
     */
    public function updateS(StocksRepository $repository, $id, Request $request)
    {
        $sto = $repository->find($id);
        $form = $this->createForm(StocksType::class, $sto);
        $form->add('modifier', SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute("affS");
        }
        return $this->render('stocks/updateS.html.twig', [
            'formS' => $form->createView()
        ]);
    }

    /**
     * @Route ("/deletes/{id}",name="deletes")
     */
    public function supprimer($id, StocksRepository $repository)
    {
        $sto = $repository->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($sto);
        $em->flush();

        return $this->redirectToRoute('affS');
    }


    /**
     * @Route("/recherche", name="rechercheAr")
     */
    public function affichages(Request $request){
        $search =$request->query->get('fournisseurs');
        $repo = $this->getDoctrine()->getRepository(Fournisseurs::class);

        $fournisseurs = $repo->findMulti($search);

        return $this->render('fournisseurs/Affiche.html.twig',
            ["fournisseurs" => $fournisseurs]);

    }


    /**
     * @Route("/excel", name="excel")
     */
    public function executeRegistrantsToCsv(StocksRepository $rep){

        $sto=$rep->findAll();
        $spreadsheet = new Spreadsheet();


        /* @var $sheet \PhpOffice\PhpSpreadsheet\Writer\Xlsx\Worksheet */
        $sheet = $spreadsheet->getActiveSheet();


        $sheet->setCellValue('A1','hello');
        $sheet->setTitle("My First Worksheet");

        // Create your Office 2007 Excel (XLSX Format)
        $writer = new Xlsx($spreadsheet);

        // Create a Temporary file in the system
        $fileName ='.xlsx';
        $temp_file = tempnam(sys_get_temp_dir(), $fileName);

        // Create the excel file in the tmp directory of the system
        $writer->save($temp_file);

        // Return the excel file as an attachment
        return $this->file($temp_file, $fileName, ResponseHeaderBag::DISPOSITION_INLINE);

        // Return a text response to the browser saying that the excel was succesfully created


    }
    /**
     * @Route("/default", name="default")
     */
    public function pdf(Request $request, StocksRepository $repository)
    {
        //All formations
        $sto = $repository->findAll();

// Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('stocks/pdf.html.twig', [
            'title' => "Welcome to our PDF Test", "sto" => $sto
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("mystock.pdf", [
            "Attachment" => true
        ]);

    }



}
