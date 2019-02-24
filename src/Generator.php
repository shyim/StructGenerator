<?php


namespace Shyim\StructGenerator;

use Shyim\StructGenerator\Optimizer\OptimizerInterface;
use Shyim\StructGenerator\Optimizer\RemoveDuplicateStructs;
use Shyim\StructGenerator\Reader\DefaultReader;
use Shyim\StructGenerator\Reader\ReaderInterface;
use Shyim\StructGenerator\Writer\WriterInterface;
use Shyim\StructGenerator\Writer\ZendCodeWriter;

class Generator
{
    /**
     * @var ReaderInterface
     */
    private $reader;

    /**
     * @var WriterInterface
     */
    private $writer;

    /**
     * @var Configuration
     */
    private $configuration;

    /**
     * @var OptimizerInterface[]
     */
    private $optimizers = [];

    public function __construct()
    {
        $this->reader = new DefaultReader();
        $this->writer = new ZendCodeWriter();
    }

    public function generate(Configuration $configuration, array $data)
    {
        $this->configuration = $configuration;

        $data = $this->reader->read($configuration, $data);

        foreach ($this->getOptimizer() as $optimizer) {
            do {
                $oldData = $data;
                $data = $optimizer->optimize($data);
            } while (md5(json_encode($oldData)) !== md5(json_encode($data)));
        }

        $this->writer->write($configuration, $data);
    }

    public function setReader(ReaderInterface $reader): void
    {
        $this->reader = $reader;
    }

    public function setWriter(WriterInterface $writer): void
    {
        $this->writer = $writer;
    }

    public function setOptimizer(array $optimizer): void
    {
        $this->optimizers = $optimizer;
    }

    protected function getOptimizer(): array
    {
        $optimizer = $this->optimizers;

        if ($this->configuration->tryToRemoveDuplicateStructs) {
            $optimizer[] = new RemoveDuplicateStructs();
        }

        return $optimizer;
    }
}
