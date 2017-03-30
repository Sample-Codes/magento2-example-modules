<?php

namespace ProjectEight\Ftp\Model;

use Magento\Framework\Filesystem\Io\Ftp as FtpClient;
use ProjectEight\Ftp\Model\Exception\FtpConnectionFailed;
use ProjectEight\Ftp\Model\Exception\FtpDownloadFailed;
use ProjectEight\Ftp\Model\Exception\FtpUploadFailed;

class Ftp
{
    /**
     * FTP Client
     *
     * @var FtpClient
     */
    private $ftpClient;

    /**
     * Ftp constructor
     *
     * @param FtpClient $ftpClient
     */
    public function __construct(FtpClient $ftpClient)
    {
        $this->ftpClient = $ftpClient;
    }

    /**
     * Get FTP credentials
     *
     * @return string[]
     */
    protected function _getCredentials()
    {
        return [
            'host'      => 'ftp.localhost.com',
            'username'  => 'ftp_username',
            'password'  => 'ftp_password'
        ];
    }

    /**
     * Open FTP connection
     *
     * @return null|true
     */
    protected function _openConnection()
    {
        try {
            $this->ftpClient->open($this->_getCredentials());
        } catch (FtpConnectionFailed $exception) {
            // Log error

            return false;
        }

        return true;
    }

    /**
     * Close FTP connection
     *
     * @return null|true
     */
    protected function _closeConnection()
    {
        try {
            $this->ftpClient->close();
        } catch (FtpConnectionFailed $exception) {
            // Log error

            return false;
        }

        return true;
    }

    /**
     * Download file from FTP
     *
     * @return bool|string
     */
    public function downloadFile()
    {
        try {
            $this->_openConnection();

            $file = $this->ftpClient->read('file_to_download.txt');
        } catch (FtpDownloadFailed $exception) {
            // Log error

            return false;
        }

        $this->_closeConnection();

        return $file;
    }

    /**
     * Upload file to FTP
     *
     * @return bool
     */
    public function uploadFile()
    {
        try {
            $this->_openConnection();

            $result = $this->ftpClient->write('uploaded_filename.csv', 'file_to_upload.csv');
        } catch (FtpUploadFailed $exception) {
            // Log error

            return false;
        }

        $this->_closeConnection();

        return $result;
    }
}
