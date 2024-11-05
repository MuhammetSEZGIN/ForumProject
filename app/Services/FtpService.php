<?php

namespace App\Services;

class FtpService
{
    private static $ftp_conn;
    public static function connect()
    {
        $ftpserver = env('FTP_HOST');
        $ftpuser = env('FTP_USERNAME');
        $ftppass = env('FTP_PASSWORD');
        self::$ftp_conn = ftp_ssl_connect($ftpserver);
        $login = ftp_login(self::$ftp_conn, $ftpuser, $ftppass);
        return self::$ftp_conn;
    }

    public static function disconnect()
    {
        if (!isset(self::$ftp_conn)) {
            echo "No connection to close";
        } else {
            ftp_close(self::$ftp_conn);
            self::$ftp_conn = null;
        }
    }


}
