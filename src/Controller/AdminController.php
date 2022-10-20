<?php

namespace App\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use AlterPHP\EasyAdminExtensionBundle\Controller\EasyAdminController;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Contracts\Translation\TranslatorInterface;
use Dompdf\Dompdf;
use Dompdf\Options;
use EasyCorp\Bundle\EasyAdminBundle\Event\EasyAdminEvents;
use App\Entity\Facture;
use App\Entity\Vente;
use App\Entity\User;
use App\Entity\Stock;
use App\Entity\Connection;
use Symfony\Component\Security\Core\Encoder\EncoderFactory;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;
use Doctrine\ORM\Query;
use App\Service\CsvExporter;


class AdminController extends EasyAdminController
{
    /**
     * @var TranslatorInterface
     */
    private $translator;
    private $csvExporter;
    /**
     * AdminController constructor.
     * @param TranslatorInterface $translator
     */
    public function __construct(TranslatorInterface $translator,CsvExporter $csvExporter)
    {
        $this->translator = $translator;
        $this->csvExporter = $csvExporter;
    }

    public function persistEntity($entity)
    {
        if (method_exists($entity, 'setVendor')) {
            $entity->setVendor($this->getUser());
            $entity->setPrixTotal(0);/*mbola tsy natao en prod ty partie 1 ty*/
            parent::persistEntity($entity);

            /*$factures = $entity->getFactures();
            foreach ($factures as $facture) {
              $facture->setTotal(0);
              parent::updateEntity($facture);
            }*/
            
        }
        elseif (method_exists($entity, 'getStock')) {
            
            parent::persistEntity($entity);
            
        }
        else{
          parent::persistEntity($entity);
        }
        if (method_exists($entity, 'getProduit')) {
           $product = $entity->getProduit();
           $stocks = $product->getStock();
           foreach ($stocks as $stock) {
             $stock->setReste();
             parent::updateEntity($stock);
           }
           
           parent::persistEntity($entity);
           
        }
        if (method_exists($entity, 'getRemarque')) {
            parent::persistEntity($entity);
              $stock =$entity->getStock();
              $quantity = $entity->getQuantity();
              $name_stock = $stock->getName();
              $quantity_stock = $stock->getReste();
              $stock->setReste();
              $reste = $quantity_stock - $quantity;
            
            parent::updateEntity($stock);
            $this->addFlash('warning', "le stock de ".$name_stock." est maintenant de ".$reste);
        }
        if (method_exists($entity, 'getReste')) {
            $entity->setReste();
            parent::persistEntity($entity);
        }
        if (method_exists($entity, 'getMontant')) {
            $entity->setDate();
            parent::persistEntity($entity);
        }

    }
    
    public function updateEntity($entity)
    {
      parent::updateEntity($entity);
      if (method_exists($entity, 'getProduit')) {
        $factures = $entity->getFactures();
        $stocks = $entity->getProduit()->getStock();
        foreach ($factures as $facture) {
          $facture->setTotal(0);
          parent::updateEntity($facture);
        }
        foreach ($stocks as $stock) {
          $stock->setReste();
          parent::updateEntity($stock);
        }
        $entity->setPrixTotal('0');
        $entity->setPu('');
        parent::updateEntity($entity);
      }
      if (method_exists($entity, 'getTotal')) {
        $ventes = $entity->getVentes();
        foreach ($ventes as $vente) {
          $stocks = $vente->getProduit()->getStock();
          foreach ($stocks as $stock) {
            $stock->setReste();
            parent::updateEntity($stock);
          }
          
        }
        $entity->setTotal(0);
        parent::updateEntity($entity);
      }
      if (method_exists($entity, 'getReste')) {
            $entity->setReste();
            parent::updateEntity($entity);
        }
      
    }

    

        public function exportAction()
        {
            $sortDirection = $this->request->query->get('sortDirection');
            if (empty($sortDirection) || !in_array(strtoupper($sortDirection), ['ASC', 'DESC'])) {
                $sortDirection = 'DESC';
            }
            $queryBuilder = $this->createListQueryBuilder(
                $this->entity['class'],
                $sortDirection,
                $this->request->query->get('sortField'),
                $this->entity['list']['dql_filter']
            );
            return $this->csvExporter->getResponseFromQueryBuilder(
                $queryBuilder,
                $this->entity['class'],
                substr($this->entity['class'].'', 10).'.csv'
            );
        }

        public function imprimerAction()
    {
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        $pdfOptions->setDpi(150);
        
        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        //get method facture
        $id = $this->request->query->get('id');
        /*$facture = new Facture();*/
        $entityManager = $this->getDoctrine()->getManager();
        $facture = $entityManager->getRepository(Facture::class)->findOneById($id);
        $total = $facture->getTotal();
        $totalstr = $this->asLetters($total);
        $date = $facture->getDate();
        $name = $facture->getName();
        $ventes = $facture->getVentes();
        $vendor = $this->getUser();
        $note = $facture->getNote();
        $connection = $facture->getConnexion();
        $html = $this->renderView('vente/facture.html.twig',[
            'total' => $total, 
            'id' => $id,
            'name' => $name, 
            'ventes' => $ventes,
            'date' => $date,
            'totalstr' => $totalstr,
            'vendor' => $vendor,
            'note' => $note,
            'connexion' => $connection,
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);
        
        
       
        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A6', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("facture.pdf", [
            "Attachment" => false
        ]);
    }

    public static function asLetters($number) {
    $convert = explode('.', $number);
    $num[17] = array('zero', 'un', 'deux', 'trois', 'quatre', 'cinq', 'six', 'sept', 'huit',
                     'neuf', 'dix', 'onze', 'douze', 'treize', 'quatorze', 'quinze', 'seize');
                      
    $num[100] = array(20 => 'vingt', 30 => 'trente', 40 => 'quarante', 50 => 'cinquante',
                      60 => 'soixante', 70 => 'soixante-dix', 80 => 'quatre-vingt', 90 => 'quatre-vingt-dix');
                                      
    if (isset($convert[1]) && $convert[1] != '') {
      return self::asLetters($convert[0]).' et '.self::asLetters($convert[1]);
    }
    if ($number < 0) return 'moins '.self::asLetters(-$number);
    if ($number < 17) {
      return $num[17][$number];
    }
    elseif ($number < 20) {
      return 'dix-'.self::asLetters($number-10);
    }
    elseif ($number < 100) {
      if ($number%10 == 0) {
        return $num[100][$number];
      }
      elseif (substr($number, -1) == 1) {
        if( ((int)($number/10)*10)<70 ){
          return self::asLetters((int)($number/10)*10).'-et-un';
        }
        elseif ($number == 71) {
          return 'soixante-et-onze';
        }
        elseif ($number == 81) {
          return 'quatre-vingt-un';
        }
        elseif ($number == 91) {
          return 'quatre-vingt-onze';
        }
      }
      elseif ($number < 70) {
        return self::asLetters($number-$number%10).'-'.self::asLetters($number%10);
      }
      elseif ($number < 80) {
        return self::asLetters(60).'-'.self::asLetters($number%20);
      }
      else {
        return self::asLetters(80).'-'.self::asLetters($number%20);
      }
    }
    elseif ($number == 100) {
      return 'cent';
    }
    elseif ($number < 200) {
      return self::asLetters(100).' '.self::asLetters($number%100);
    }
    elseif ($number < 1000) {
      return self::asLetters((int)($number/100)).' '.self::asLetters(100).($number%100 > 0 ? ' '.self::asLetters($number%100): '');
    }
    elseif ($number == 1000){
      return 'mille';
    }
    elseif ($number < 2000) {
      return self::asLetters(1000).' '.self::asLetters($number%1000).' ';
    }
    elseif ($number < 1000000) {
      return self::asLetters((int)($number/1000)).' '.self::asLetters(1000).($number%1000 > 0 ? ' '.self::asLetters($number%1000): '');
    }
    elseif ($number == 1000000) {
      return 'millions';
    }
    elseif ($number < 2000000) {
      return self::asLetters(1000000).' '.self::asLetters($number%1000000);
    }
    elseif ($number < 1000000000) {
      return self::asLetters((int)($number/1000000)).' '.self::asLetters(1000000).($number%1000000 > 0 ? ' '.self::asLetters($number%1000000): '');
    }
  }
    /**
     * @param string $value
     * @return string
     */
    private function humanize(string $value): string
    {
        return ucfirst(strtolower(trim(preg_replace(['/([A-Z])/', '/[_\s]+/'], ['_$1', ' '], $value))));
    }


    protected function persistUserEntity($user)
    {
        $encodedPassword = $this->encodePassword($user, $user->getPassword());
        $user->setPassword($encodedPassword);

        parent::persistEntity($user);
    }

    protected function updateUserEntity($user)
    {
        $encodedPassword = $this->encodePassword($user, $user->getPassword());
        $user->setPassword($encodedPassword);

        parent::updateEntity($user);
    }

    private function encodePassword($user, $password)
    {
        $passwordEncoderFactory = new EncoderFactory([
            User::class => new MessageDigestPasswordEncoder('sha512', true, 5000)
        ]);

        $encoder = $passwordEncoderFactory->getEncoder($user);

        return $encoder->encodePassword($password, $user->getSalt());
    }
}
