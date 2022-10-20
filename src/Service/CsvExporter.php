<?php
/**
 * Created by PhpStorm.
 * User: vlad
 * Date: 23.07.18
 * Time: 13:17
 */

namespace App\Service;

use App\Entity\Vente;
use App\Entity\Connection;
use Doctrine\Common\Collections\ArrayCollection;

use Doctrine\ORM\QueryBuilder;

use Symfony\Component\HttpFoundation\StreamedResponse;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Contracts\Translation\TranslatorInterface;

class CsvExporter
{
    
    public function getResponseFromQueryBuilder(QueryBuilder $queryBuilder, $columns, $filename)
    {
        $entities = new ArrayCollection($queryBuilder->getQuery()->getResult());
        $response = new StreamedResponse();
        if (is_string($columns)) {
            $columns = $this->getColumnsForEntity($columns);
        }
        $response->setCallback(function () use ($entities, $columns) {
            $handle = fopen('php://output', 'w+');
            // Add header
            fputcsv($handle, array_keys($columns));
            while ($entity = $entities->current()) {
                $values = [];
                foreach ($columns as $column => $callback) {
                    $value = $callback;
                    if (is_callable($callback)) {
                        $value = $callback($entity);
                    }
                    $values[] = $value;
                }
                fputcsv($handle, $values);
                $entities->next();
            }
            fclose($handle);
        });
        $response->headers->set('Content-Type', 'text/csv; charset=utf-8');
        $response->headers->set('Content-Disposition', 'attachment; filename="' . $filename . '"');

        return $response;
        
    }
    
    private function getColumnsForEntity($class)
    {
        
        if ($class==Vente::class) {
            $columns[Vente::class] = [
            'Date' => function (Vente $vente) {
                return $vente->getDate()->format('d/m/Y H:i');
            },
            'Produit' => function (Vente $vente) {
                return $vente->getProduit();
            },
            'Prix unitaire' => function (Vente $vente) {
                return $vente->getPu();
            },
            'Quantité' => function (Vente $vente) {
                return $vente->getQuantity();
            },
            'Prix total' => function (Vente $vente) {
                return $vente->getPrixTotal();
            },
            'Vendeur' => function (Vente $vente) {
                return $vente->getVendor();
            },
            ];
        }
        if ($class==Connection::class) {
            $columns[Connection::class] = [
            'id' => function (Connection $connection) {
                return $connection->getId();
            },
            'Date' => function (Connection $connection) {
                return $connection->getDate()->format('d/m/Y H:i');
            },
            'Poste - wifi' => function (Connection $connection) {
                return $connection->getName();
            },
            'Montant' => function (Connection $connection) {
                return $connection->getMontant();
            },
            ];
        }
        
        if (array_key_exists($class, $columns)) {
            return $columns[$class];
        }
        throw new \InvalidArgumentException(sprintf(
            'No columns set for "%s" entity',
            $class
        ));
    }
}
