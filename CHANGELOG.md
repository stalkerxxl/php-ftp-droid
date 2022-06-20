# Changelog

All notable changes to `ftp-droid` will be documented in this file

## 1.0.0 - 2022-06-20

- initial release

available methods mapped to original methods php-ftp (read on the [php.net](https://www.php.net/manual/en/ref.ftp.php)):
```php
 close();// Closes an FTP connection.<br> * After calling this function, you can no longer use the FTP connection and must create a new one with FtpDroid::connect
 login(string $username, string $password);// Logs in to an FTP connection. Returns true on success or false on failure. If login fails, PHP will also throw a warning.
 alloc(int $size, string &$response = null);// Allocates space for a file to be uploaded.
 append(string $remote_filename, string $local_filename, int $mode = FTP_BINARY);// Append the contents of a file to another file on the FTP server
 cdup();// Changes to the parent directory
 chdir(string $directory);// Changes the current directory on a FTP server. If changing directory fails, PHP will also throw a warning.
 chmod(int $permissions, string $filename);// Set permissions on a file via FTP.
 delete(string $filename);// Deletes a file on the FTP server.
 exec(string $command);// Requests execution of a command on the FTP server.
 fget(resource $stream, string $remote_filename, int $mode = FTP_BINARY, int $offset = 0);// Downloads a file from the FTP server and saves to an open file.
 fput(string $remote_filename, resource $stream, int $mode = FTP_BINARY, int $offset = 0);// Uploads from an open file to the FTP server.
 get_option(int $option);// Retrieves various runtime behaviours of the current FTP connection.
 get(string $local_filename, string $remote_filename, int $mode = FTP_BINARY, int $offset = 0);// Downloads a file from the FTP server.
 mdtm(string $filename);// Returns the last modified time of the given file. Not all servers support this feature! mdtm() does not work with directories.
 mkdir(string $directory);// Creates a directory.
 mlsd(string $directory);// Returns a list of files in the given directory.
 nlist(string $directory);// Returns a list of files in the given directory.
 pasv(bool $enable);// Turns on or off passive mode. In passive mode, data connections are initiated by the client, rather than by the server. pasv() can only be called after a successful login!
 put(string $remote_filename, string $local_filename, int $mode = FTP_BINARY, int $offset = 0);// Uploads a file to the FTP server
 pwd();// Returns the current directory name
 quit();// Alias of close()
 raw(string $command);// Sends an arbitrary command to an FTP server
 rawlist(string $directory, bool $recursive = false);// Returns a detailed list of files in the given directory
 rename(string $from, string $to);// Renames a file or a directory on the FTP server
 rmdir(string $directory);// Removes a directory
 set_option(int $option, int|bool $value);// Set miscellaneous runtime FTP options
 site(string $command);// Sends a SITE command to the server
 size(string $filename);// Returns the size of the given file
 systype();// Returns the system type identifier of the remote FTP server
```
