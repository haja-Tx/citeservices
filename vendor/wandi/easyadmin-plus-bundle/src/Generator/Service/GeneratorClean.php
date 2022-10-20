<?php

namespace Wandi\EasyAdminPlusBundle\Generator\Service;

use Wandi\EasyAdminPlusBundle\Generator\GeneratorTool;
use Wandi\EasyAdminPlusBundle\Generator\Model\Entity;
use Wandi\EasyAdminPlusBundle\Generator\Exception\RuntimeCommandException;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Yaml\Yaml;

class GeneratorClean extends GeneratorBase implements GeneratorConfigInterface
{
    private $consoleOutput;
    private $bundles;

    public function buildServiceConfig()
    {
        $this->consoleOutput = new ConsoleOutput();
        $this->bundles = $this->container->getParameter('kernel.bundles');
    }

    public function run(): void
    {
        $fileContent = Yaml::parse(file_get_contents($this->projectDir.'/config/packages/easy_admin.yaml'));

        if (!isset($fileContent['imports'])) {
            return;
        }

        $entitiesToDelete = $this->getEntitiesToDelete($fileContent);

        if (!empty($entitiesToDelete)) {
            $this->consoleOutput->writeln('<info>Start </info>of cleaning easyadmin configuration files.');
            $this->purgeImportedFiles($entitiesToDelete);
            $this->purgeEasyAdminMenu($entitiesToDelete);
            $this->purgeEntityFiles($entitiesToDelete);
        }

        $this->consoleOutput->writeln('Cleaning process <info>completed</info>');
    }

    /**
     * Returns the list of entities to delete.
     */
    private function getEntitiesToDelete($fileContent): array
    {
        $entitiesToDelete = [];
        $entitiesList = $this->getEntitiesNameFromMetaDataList($this->em->getMetadataFactory()->getAllMetadata(), $this->bundles);
        $entitiesEasyAdmin = $this->getEasyAdminEntityNames($fileContent['imports']);

        foreach (array_diff($entitiesEasyAdmin, $entitiesList) as $entity) {
            $entitiesToDelete['name'][] = $entity;
            $entitiesToDelete['pattern'][] = 'easy_admin/entities/'.$entity.'.yaml';
        }

        return $entitiesToDelete;
    }

    private function getEasyAdminEntityNames(array $files): array
    {
        $entitiesName = [];
        $filesToDiscard = [
            'easy_admin/menu.yaml',
            'easy_admin/design.yaml',
        ];

        foreach ($files as $file) {
            if (in_array($file['resource'], $filesToDiscard)) {
                continue;
            }

            $lengthPattern = strlen('easy_admin/entities/');
            $entitiesName[] = substr($file['resource'], $lengthPattern, strlen($file['resource']) - $lengthPattern - 5);
        }

        return $entitiesName;
    }

    /**
     * Returns an array containing the names of the entities.
     */
    private function getEntitiesNameFromMetaDataList(array $metaDataList, array $bundles): array
    {
        $entitiesName = array_map(function ($metaData) use ($bundles) {
            return Entity::buildName(Entity::buildNameData($metaData, $bundles));
        }, $metaDataList);

        return $entitiesName;
    }

    private function purgeImportedFiles(array $entities): void
    {
        $fileBaseContent = Yaml::parse(file_get_contents(sprintf('%s/config/packages/easy_admin.yaml', $this->projectDir)));

        if (!isset($fileBaseContent['imports'])) {
            throw new RuntimeCommandException('No imported files2');
        }

        foreach ($fileBaseContent['imports'] as $key => $import) {
            if (in_array($import['resource'], $entities['pattern'])) {
                unset($fileBaseContent['imports'][$key]);
            }
        }

        $fileBaseContent['imports'] = array_values($fileBaseContent['imports']);
        $ymlContent = GeneratorTool::buildDumpPhpToYml($fileBaseContent, $this->parameters);
        file_put_contents(sprintf('%s/config/packages/easy_admin.yaml', $this->projectDir), $ymlContent);
    }

    private function purgeEasyAdminMenu(array $entities): void
    {
        $fileContent = Yaml::parse(file_get_contents(sprintf('%s/config/packages/easy_admin/menu.yaml', $this->projectDir)));

        if (!isset($fileContent['easy_admin']['design']['menu'])) {
            throw new RuntimeCommandException('no easy admin menu detected');
        }

        foreach ($fileContent['easy_admin']['design']['menu'] as $key => $entry) {
            if (in_array($entry['entity'], $entities['name'])) {
                unset($fileContent['easy_admin']['design']['menu'][$key]);
            }
        }

        $fileContent['easy_admin']['design']['menu'] = array_values($fileContent['easy_admin']['design']['menu']);
        $ymlContent = GeneratorTool::buildDumpPhpToYml($fileContent, $this->parameters);
        file_put_contents($this->projectDir.'/config/packages/easy_admin/menu.yaml', $ymlContent);
    }

    private function purgeEntityFiles(array $entities): void
    {
        foreach ($entities['name'] as $entityName) {
            $this->consoleOutput->writeln(sprintf('Purging entity <info>%s</info>', $entityName));
            $path = sprintf('/config/packages/easy_admin/entities/%s.yaml', $entityName);
            if (unlink($this->projectDir.$path)) {
                $this->consoleOutput->writeln(sprintf('   >File <comment>%s</comment> has been <info>deleted</info>.', $path));
            } else {
                throw new RuntimeCommandException(sprintf('Unable to delete configuration file for %s entity', $entityName));
            }
        }
    }
}
