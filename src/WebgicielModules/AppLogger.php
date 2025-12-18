<?php

namespace Webgiciel2\ModuleLog\WebgicielModules;

class AppLogger
{
    private string $logDir;

    public function __construct(string $projectDir)
    {
        $this->logDir = $projectDir . '/var/log/custom/';

        if (!is_dir($this->logDir)) {
            mkdir($this->logDir, 0777, true);
        }
    }

    public function log(string $message, ?string $ip = $_SERVER['REMOTE_ADDR']): void
    {
        $date = new \DateTime();

        $filename = $this->getAvailableLogFilename(clone $date);

        $logMessage = sprintf(
            "[%s] %s%s\n",
            $date->format('Y-m-d H:i:s'),
            $ip ? $ip . ', ' : '',
            $message
        );

        file_put_contents($filename, $logMessage, FILE_APPEND);
    }

    private function getAvailableLogFilename(\DateTime $date): string
    {
        $maxLines = 500; 

        while (true) {
            $logFilename = $this->logDir . 'log_' . $date->format('Y_m_d') . '.txt';

            if (!file_exists($logFilename)) {
                return $logFilename;
            }

            $lineCount = (int) exec(
                'wc -l < ' . escapeshellarg($logFilename)
            );

            if ($lineCount < $maxLines) {
                return $logFilename;
            }

            $date->modify('+1 day');
        }
    }
}
