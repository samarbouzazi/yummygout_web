<?php

namespace App\Controller;

use App\Entity\Fournisseurs;
use App\Entity\Stocks;
use App\Form\FournisseursType;
use App\Form\StocksType;
use App\Repository\StocksRepository;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CalendarRepository;
use Twilio\Rest\Client;
use Dompdf\Dompdf;
use Dompdf\Options;

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
        return $this->render('stocks/AfficheS.html.twig', ['sto' => $sto]
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

            $sid    = "AC1b97326883a46c718448ffdad3857462";

            $token  = "b2fcfad308a28e05354d8232f266163e";

            $twilio = new Client($sid, $token);

            $message = $twilio->messages
                ->create("+21651714905", // to
                    array(
                        "messagingServiceSid" => "MGe2aa2a0bdace81011498b94b52e3e14f",


                        "body" => "un stock a été ajouté avec succées "
                    )
                );
            print($message->sid);

            $em = $this->getDoctrine()->getManager();
            $em->persist($sto);
            $em->flush();
            return $this->redirectToRoute('affS');
        }
        return $this->render('stocks/Add.html.twig', [
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
     * @Route("event/calendar", name="calendar")
     */
    public function calendar(): Response
    {
        // $event = $calendar->findAll();
        $event = $this->getDoctrine()->getRepository(Stocks::class)->findAll();
        $rdvs = [];
        $allDay = true;
        foreach ($event as $event) {
            $rdvs[] = [
                'id' => $event->getIds(),
                'start' => $event->getdateFinS()->format('Y-m-d H:i:s'),
                'end' => $event->getdateFinS()->format('Y-m-d H:i:s'),
                'title' => $event->getNoms(),
                'description' =>'lala',
                'backgroundColor' => "#0000ff",
                'borderColor' => "#ff0000",
                'textColor' => "#ffffff",
                'allDay' => $allDay,
            ];
        }
        $data = json_encode($rdvs);
        return $this->render('stocks/test.html.twig', compact('data'));
        /*  return $this->render('base_back/voyage/calendar.html.twig', [
                'controller_name' => 'VoyageController',
            ]);
        */
    }



    public function getData() :array
    {
        /**
         * @var $Stock Resta[]
         */
        $list = [];

        $Use = $this->getDoctrine()->getRepository(Stocks::class)->findAll();

        foreach ($Use as $Resta) {
            $list[] = [
                $Resta->getIds(),
                $Resta->getNoms(),
                // $Resta->getRoles(),
                $Resta->getPrixs(),
                $Resta->getQts(),

            ];
        }
        return $list;
    }

    /**
     * @Route("/excel/export",  name="export")
     */
    public function export(Request  $request)
    {

        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setTitle("DataUser List");

        $sheet->getCell("A1")->setValue("ID");
        $sheet->getCell("B1")->setValue("LIBELLE");
        $sheet->getCell("C1")->setValue("PRIX");
        $sheet->getCell("D1")->setValue("QUANTITE");



        $sheet->getColumnDimension("A")->setWidth(20);
        $sheet->getColumnDimension("B")->setWidth(20);
        $sheet->getColumnDimension("C")->setWidth(20);
        $sheet->getColumnDimension("D")->setWidth(20);



        $spreadsheet->getActiveSheet()->setAutoFilter(
            $spreadsheet->getActiveSheet()->calculateWorksheetDimension()
        );
        $sheet->fromArray($this->getData(), null, "A2", true);
        $writer = new Xlsx($spreadsheet);
        $writer->save("uploads/data.xlsx");

        $response = new BinaryFileResponse("uploads/data.xlsx");

        $disposition = $response->headers->makeDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            "data.xlsx"
        );

        $response->headers->set("Content-Disposition", $disposition);

        return $response;



    }

    /**
     * @Route("/default", name="default")
     */
    public function pdf(Request $request, StocksRepository $repository)
    {
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        //l'image est située au niveau du dossier public
        $png = file_get_contents("logo.png");
        $pngbase64 = base64_encode($png);
        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('stocks/pdf.html.twig', [
            "img64"=>$pngbase64,
            'sto' => $repository->findAll()
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("Listproduits.pdf", [

            "sto" => true,
        ]);
    }


}
