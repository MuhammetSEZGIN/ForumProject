<?php
namespace App\Helpers;
enum FileMessagesEnum: string {
    case FILE_UPLOADED_SUCCESSFULLY = 'File uploaded successfully';
    case FILE_UPLOADED_FROM_FTP_SERVER_SUCCESSFULLY = 'File uploaded successfully from FTP server';
    case FILE_UPLOADED_FROM_FTP_SERVER_FAIL = 'File uploaded failed from FTP server';

    case NO_FILE_IN_FTP = 'There is no file in the FTP folder';
    case NO_FILE_IN_INBOX = 'There is no file in the INBOX folder';

    case USER_NAME_DOESNT_EXISTS_IN_FOLDER = 'There is no user name in the FOLDER';
    case FILE_MOVED_TO_ERROR_DIRECTORY = 'File moved to error directory';
}
