<?php

namespace Webgiciel2\ModuleLog\Modules;

use Psr\Log\LoggerInterface;

class AppUploads
{
    public function __construct(
        private LoggerInterface $logger
    ) {}

    public function info(string $message, array $context = []): void
    {
        $this->logger->info('[UPLOAD] '.$message, $context);
    }

    public function error(string $message, array $context = []): void
    {
        $this->logger->error('[UPLOAD] '.$message, $context);
    }
}
