<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Gumbercules\IisLogParser\LogFile;

class File_iterator
{

    protected $path;

    var $ci;

    function __construct()
    {
        $this->ci =& get_instance();
    }

    public function iterateIIS($path)
    {
        $dir = new DirectoryIterator($path);
        foreach ($dir as $fileinfo) {
            if (!$fileinfo->isDot()) {
                $this->importIIS($fileinfo->getFilename());
            }
        }
    }

    public function importIIS($fileName)
    {
        $targetDir  = FCPATH . "upload/iis_logs/";
        $targetFile = $targetDir . $fileName;
        $fields = null;
        $this->ci->load->model('parsers/iis_parser');
        $this->ci->load->library('logger');

        if ($targetFile) {
            //insert file information into db table
            //create an instance of \SplFileObject to inject into LogFile
            $pathToFile = FCPATH . "upload/iis_logs/" . $fileName;
            $file       = new \SplFileObject($pathToFile);

            //create instance of LogFile using \SplFileObject
            $logFile = new LogFile($file);

            //you will now have an array of LogEntry objects available via LogFile's getEntries() method
            $insert = 0;
            ini_set('memory_limit', '512M');
            ini_set('max_execution_time', '900000');
            set_time_limit(0);
            foreach ($logFile->getEntries() as &$entry) {
                $fields[] = array(
                    'datetime'    => $entry->getDateTime(),
                    'url'         => $entry->getRequestUri(),
                    'variable'    => $entry->getRequestQuery(),
                    'visiting_ip' => $entry->getClientIp(),
                    'agent'       => $entry->getClientUserAgent(),
                    'response'    => $entry->getResponseStatusCode(),
                    'time_taken'  => $entry->getTimeTaken()
                );
                $insert++;
            }
            //insert array into db in chunks
            $this->ci->iis_parser->insert($fields);
            $this->ci->logger->IISLog($fileName, $insert);
        }

    }
}