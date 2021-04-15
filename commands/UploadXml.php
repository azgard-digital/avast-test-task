<?php
declare(strict_types=1);

namespace Commands;

use App\Redis;
use App\XmlParser;
use App\RedisStorageService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UploadXml extends Command
{
    protected static $defaultName = 'upload-xml';
    protected const DEFAULT_PATH = '/var/www/xml';

    protected function configure(): void
    {
        $this->addArgument('file', InputArgument::REQUIRED)
            ->addArgument('flag', InputArgument::REQUIRED)
            ->setDescription('Upload xml to redis.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $section = $output->section();
        $errOutput = $output->getErrorOutput();

        try {
            $folder = getenv('XML_FOLDER_PATH', true) ?? self::DEFAULT_PATH;
            $path = $folder.'/'.$input->getArgument('file');
            $redis = new Redis();
            $storage = new RedisStorageService($redis->connect());
            $reader = \XMLReader::open($path);
            $parser = new XmlParser($storage, $reader);

            foreach ($parser->export() as $key) {

                if ($input->getArgument('flag') === 'true') {
                    $section->writeln($key);
                }
            }

            $reader->close();
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $errOutput->writeln('<error>'.$e->getMessage().'</error>');
        }

        return Command::FAILURE;
    }
}