<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\LineChart;
use App\Entity\Connection;
use App\Entity\Vente;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\JsonResponse;

class ChartController extends AbstractController
{
	/**
     * @Route("/private/test", name="test")
     */
	public function chart(Request $request):Response
	{
		$pieChart = new PieChart();
        $chart = new LineChart();
        $chart2 = new LineChart();
        $format ='Jour';
         if($request->isMethod('post')){
          $format = $request->request->get("periode");
        }
        // if($request->isXmlHttpRequest()) {
     //        $format = $request->request->get('periode');
            
     //        return new Response($format);
     //    }
   
        switch ($format) {
            case 'Jour':
                $format1 = 'd-m-Y';
                $title = 'journalier';
                break;
            case 'Mois':
                $format1 = 'm-Y';
                $title = 'mensuel';
                break;
            case 'Année':
                $format1 = 'Y';
                $title = 'annuel';
                break;
            
        }
        
        // $result = array_merge($this->tabconnection($format1), $this->tabvente($format1));
        // var_dump($result);
        $chart->getData()->setArrayToDataTable($this->tabconnection($format1));
        $chart->getOptions()->getChartArea();
            // ->setTitle('Connection internet cyber');
        $chart->getOptions()
            ->setTitle('Connection '.$title)
            ->setHeight(400)
            ->setWidth('auto')
            ->setSeries([['axis' => 'Date']])
            ->setVAxes(['y' => ['Connexion' => ['label' => 'Montant'] ]]);
        $chart2->getData()->setArrayToDataTable($this->tabvente($format1));
        $chart2->getOptions()->getChartArea();
            // ->setTitle('Vente Tsena');
        $chart2->getOptions()
            ->setTitle('Vente '.$title)
            ->setHeight(400)
            ->setWidth('auto')
            ->setSeries([['axis' => 'Date']])
            ->setVAxes(['y' => ['Vente' => ['label' => 'Montant vente'], ]]);
    $pieChart->getData()->setArrayToDataTable($this->tabnamevente());
    $pieChart->getOptions()->setTitle('Répartition des produits');
    $pieChart->getOptions()->setHeight(400);
    $pieChart->getOptions()->setWidth('auto');
    $pieChart->getOptions()->setIs3d(true);
    $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
    $pieChart->getOptions()->getTitleTextStyle()->setColor('#009900');
    $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
    $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
    $pieChart->getOptions()->getTitleTextStyle()->setFontSize(20);
        /*return $this->render('chart/chart.html.twig', [
            'piechart' => $pieChart,
            'chart' => $chart,
            'chart2' => $chart2,
        ]);*/
        return new JsonResponse([
            'html' => $this->renderView('chart/chart.html.twig',[
            // 'piechart' => $pieChart,
            'chart' => $chart,
            'chart2' => $chart2,
        ])], 200);
	}
    /**
     * @Route("/private/chart", name="chart")
     * Require ROLE_ADMIN for *every* controller method in this class.
	 *
  	 * @IsGranted("ROLE_ADMIN")
     */
    public function index(Request $request):Response
    {	
    	$pieChart = new PieChart();
    	$chart = new LineChart();
    	$chart2 = new LineChart();
    	$format ='Jour';
    	 if($request->isMethod('post')){
		  $format = $request->request->get("periode");
		}
		// if($request->isXmlHttpRequest()) {
	 //        $format = $request->request->get('periode');
	        
	 //        return new Response($format);
	 //    }
   
 		switch ($format) {
 			case 'Jour':
 				$format1 = 'd-m-Y';
 				$title = 'journalier';
 				break;
 			case 'Mois':
 				$format1 = 'm-Y';
 				$title = 'mensuel';
 				break;
 			case 'Année':
 				$format1 = 'Y';
 				$title = 'annuel';
 				break;
 			
 		}
 		
 		// $result = array_merge($this->tabconnection($format1), $this->tabvente($format1));
 		// var_dump($result);
    	$chart->getData()->setArrayToDataTable($this->tabconnection($format1));
    	$chart->getOptions()->getChartArea();
		    // ->setTitle('Connection internet cyber');
		$chart->getOptions()
			->setTitle('Connection '.$title)
		    ->setHeight(400)
		    ->setWidth('auto')
		    ->setSeries([['axis' => 'Date']])
		    ->setVAxes(['y' => ['Connexion' => ['label' => 'Montant'] ]]);
		$chart2->getData()->setArrayToDataTable($this->tabvente($format1));
    	$chart2->getOptions()->getChartArea();
		    // ->setTitle('Vente Tsena');
		$chart2->getOptions()
			->setTitle('Vente '.$title)
		    ->setHeight(400)
		    ->setWidth('auto')
		    ->setSeries([['axis' => 'Date']])
		    ->setVAxes(['y' => ['Vente' => ['label' => 'Montant vente'], ]]);
    $pieChart->getData()->setArrayToDataTable($this->tabnamevente());
    $pieChart->getOptions()->setTitle('Répartition des produits');
    $pieChart->getOptions()->setHeight(400);
    $pieChart->getOptions()->setWidth('auto');
    $pieChart->getOptions()->setIs3d(true);
    $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
    $pieChart->getOptions()->getTitleTextStyle()->setColor('#009900');
    $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
    $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
    $pieChart->getOptions()->getTitleTextStyle()->setFontSize(20);
        return $this->render('chart/index.html.twig', [
            'piechart' => $pieChart,
            'chart' => $chart,
            'chart2' => $chart2,
        ]);
    }
    
    	
    private function tabconnection($format)
    {
    	$repository = $this->getDoctrine()->getRepository(Connection::class);
    	$connections = $repository->findAll();
    	// $tab[] = ['Date', 'Montant'];
   //  	$repository2 = $this->getDoctrine()->getRepository(Vente::class);
   //  	$ventes = $repository->findAll();
   //  	$test = array();
   //  	foreach ($connections as $vente) {
 		// 	$test = [$connection->getMontant(),$vente->getPrixTotal()];
 		// }
 		// var_dump($test);
    	foreach ($connections as $connection) {
    		$tab[] = [$connection->getDate()->format($format),$connection->getMontant()];
    		
    	}
    	$aggregateArray = array();
		foreach($tab as $row) {
		    if(!array_key_exists($row[0], $aggregateArray)) {
		        $aggregateArray[$row[0]] = 0;
		    }
		    $aggregateArray[$row[0]] += $row[1];
		}
		$final = array_map(function($v, $k){
            return array(0=>$k, 1=>$v);
        }, $aggregateArray, array_keys($aggregateArray));
    	
    	
    	// array_unshift($tab, ['Date', 'Montant']);
    	array_unshift($final, ['Date', 'Connexion']);
    	return $final;
    }
    private function tabvente($format)
    {
    	$repository = $this->getDoctrine()->getRepository(Vente::class);
    	$ventes = $repository->findAll();
    	// $tab[] = ['Date', 'Montant'];
    	
    	foreach ($ventes as $vente) {
    		$tab[] = [$vente->getDate()->format($format),$vente->getPrixTotal()];
    		
    	}
    	$aggregateArray = array();
		foreach($tab as $row) {
		    if(!array_key_exists($row[0], $aggregateArray)) {
		        $aggregateArray[$row[0]] = 0;
		    }
		    $aggregateArray[$row[0]] += $row[1];
		}
		$final = array_map(function($v, $k){
            return array(0=>$k, 1=>$v);
        }, $aggregateArray, array_keys($aggregateArray));
    	
    	
    	// array_unshift($tab, ['Date', 'Montant']);
    	array_unshift($final, ['Date', 'Vente']);
    	return $final;

    }
    private function tabnamevente()
    {
    	$repository = $this->getDoctrine()->getRepository(Vente::class);
    	$ventes = $repository->findAll();
    	// $tab[] = ['Date', 'Montant'];
    	
    	foreach ($ventes as $vente) {
    		$tab[] = [$vente->getProduit()->getName(),$vente->getPrixTotal()];
    		
    	}
    	$aggregateArray = array();
		foreach($tab as $row) {
		    if(!array_key_exists($row[0], $aggregateArray)) {
		        $aggregateArray[$row[0]] = 0;
		    }
		    $aggregateArray[$row[0]] += $row[1];
		}
		$final = array_map(function($v, $k){
            return array(0=>$k, 1=>$v);
        }, $aggregateArray, array_keys($aggregateArray));
    	
    	
    	// array_unshift($tab, ['Date', 'Montant']);
    	array_unshift($final, ['Produit', 'Montant']);
    	return $final;

    }
}
