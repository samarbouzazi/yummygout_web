<?php

namespace App\Services;
use Endroid\QrCode\Builder\BuilderInterface;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use Endroid\QrCode\Label\Alignment\LabelAlignmentCenter as LabelAlignmentCenterAlias;
use Endroid\QrCode\Label\Margin\Margin;

class QrcodeService
{
    /**
     * @var BuilderInterface
     */
    protected $builder;
    public function __construct(BuilderInterface $builder)
    {
        $this->builder = $builder;
    }
    public function qrcode($query)
    {
        $objDateTime= new \DateTime('NOW');
        $dateString= $objDateTime->format('d-m-Y H:i:s');



        $path=dirname(__DIR__,2).'/public/assets/';
        //set qrcode

        $result=$this->builder
            ->data($query)
            ->encoding(new Encoding('UTF-8'))
            ->errorCorrectionLevel(new ErrorCorrectionLevelHigh())
            ->size(200)
            ->margin(10)
            ->labelText($dateString)

            ->build();
        $namePng =uniqid('',''). '.png';

        $result->saveToFile( (\dirname(_DIR_,2).'/public/uploads/Qrcode/'.$namePng));
        return $result->getDataUri(); //recupere mon image
    }


        $result->saveToFile( (\dirname(__DIR__,2).'/public/uploads/qr-code/'.$namePng));
        return $result->getDataUri(); //recupere mon image
    }

}