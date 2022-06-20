<?php

namespace Kartulin\FtpDroid;

use Psr\Log\LoggerInterface;

/**
 * @method FtpDroid close() Closes an FTP connection.<br> * After calling this function, you can no longer use the FTP connection and must create a new one with FtpDroid::connect
 * @method FtpDroid login(string $username, string $password) Logs in to an FTP connection. Returns true on success or false on failure. If login fails, PHP will also throw a warning.
 * @method FtpDroid alloc(int $size, string &$response = null) Allocates space for a file to be uploaded.
 * @method FtpDroid append(string $remote_filename, string $local_filename, int $mode = FTP_BINARY) Append the contents of a file to another file on the FTP server
 * @method FtpDroid cdup() Changes to the parent directory
 * @method FtpDroid chdir(string $directory) Changes the current directory on a FTP server. If changing directory fails, PHP will also throw a warning.
 * @method FtpDroid chmod(int $permissions, string $filename) Set permissions on a file via FTP.
 * @method FtpDroid delete(string $filename) Deletes a file on the FTP server.
 * @method FtpDroid exec(string $command) Requests execution of a command on the FTP server.
 * @method FtpDroid fget(resource $stream, string $remote_filename, int $mode = FTP_BINARY, int $offset = 0) Downloads a file from the FTP server and saves to an open file.
 * @method FtpDroid fput(string $remote_filename, resource $stream, int $mode = FTP_BINARY, int $offset = 0) Uploads from an open file to the FTP server.
 * @method FtpDroid get_option(int $option) Retrieves various runtime behaviours of the current FTP connection.
 * @method FtpDroid get(string $local_filename, string $remote_filename, int $mode = FTP_BINARY, int $offset = 0) Downloads a file from the FTP server.
 * @method FtpDroid mdtm(string $filename) Returns the last modified time of the given file. Not all servers support this feature! mdtm() does not work with directories.
 * @method FtpDroid mkdir(string $directory) Creates a directory.
 * @method FtpDroid mlsd(string $directory) Returns a list of files in the given directory.
 * @method FtpDroid nlist(string $directory) Returns a list of files in the given directory.
 * @method FtpDroid pasv(bool $enable) Turns on or off passive mode. In passive mode, data connections are initiated by the client, rather than by the server. pasv() can only be called after a successful login!
 * @method FtpDroid put(string $remote_filename, string $local_filename, int $mode = FTP_BINARY, int $offset = 0) Uploads a file to the FTP server
 * @method FtpDroid pwd() Returns the current directory name
 * @method FtpDroid quit() Alias of close()
 * @method FtpDroid raw(string $command) Sends an arbitrary command to an FTP server
 * @method FtpDroid rawlist(string $directory, bool $recursive = false) Returns a detailed list of files in the given directory
 * @method FtpDroid rename(string $from, string $to) Renames a file or a directory on the FTP server
 * @method FtpDroid rmdir(string $directory) Removes a directory
 * @method FtpDroid set_option(int $option, int|bool $value) Set miscellaneous runtime FTP options
 * @method FtpDroid site(string $command) Sends a SITE command to the server
 * @method FtpDroid size(string $filename) Returns the size of the given file
 * @method FtpDroid systype() Returns the system type identifier of the remote FTP server
 */
class FtpDroid
{
    public string $hostname;
    public bool $ssl;
    public int $port;
    public int $timeout;
    /**
     * @var $handler resource|null|false
     */
    private $handler = null;
    private ?LoggerInterface $logger = null;
    /**
     * @var null|mixed|boolean
     */
    public $result = null;
    public array $errors = [];

    protected function __construct(){}

    /**
     * @param  string  $hostname  This parameter shouldn't have any trailing slashes and shouldn't be prefixed with ftp://.
     * @param  bool  $ssl  TRUE, if want use ftp_ssl_connect()
     * @param  int  $port  21 by default
     * @param  int  $timeout  This parameter specifies the timeout for all subsequent network operations.
     * @return FtpDroid
     */
    public static function connect(string $hostname, bool $ssl = false, int $port = 21, int $timeout = 90): FtpDroid
    {
        if (!extension_loaded('ftp')) {
            throw new \RuntimeException('PHP FTP library is not loaded');
        }
        //FIXME add validate $hostname
        $client = new self();
        $client->hostname = $hostname;
        $client->ssl = $ssl;
        $client->port = $port;
        $client->timeout = $timeout;

        if ($client->ssl) {
            $client->handler = ftp_ssl_connect($hostname, $port, $timeout);

        } else {
            $client->handler = ftp_connect($hostname, $port, $timeout);
        }
        if (!$client->handler) {
            throw new \RuntimeException("Couldn't connect to ftp-server");
        }

        return $client;
    }

    /**
     * Set logger
     * @param  LoggerInterface  $logger
     * @return $this
     */
    private function setLogger(LoggerInterface $logger): FtpDroid
    {
        $this->logger = $logger;

        return $this;
    }

    /**
     * example: function (FtpDroid $client) { // you_logic_here// return...}
     * @param  callable  $callback
     * @return $this
     */
    public function callback(callable $callback): FtpDroid
    {
        if (is_callable($callback)) {
            call_user_func($callback, $this);
        }

        return $this;
    }

    /**
     * Magic section :-)
     * @param $method
     * @param $args
     * @return $this
     */
    public function __call($method, $args): FtpDroid
    {
        if (is_callable([$this, $method])) {
            $this->result = $this->runCommand($method, $args);
            if (!$this->result) {
                $this->errors[time()] = $method;
            }

            return $this;

        } else {
            throw new \InvalidArgumentException($method." doesn't exist");
        }
    }

    /**
     * Run ftp-handler command
     * @param  string  $command
     * @param $args
     * @return mixed|bool
     */
    protected function runCommand(string $command, $args)
    {
        return call_user_func('ftp_'.$command, $this->handler, ...$args);
    }

    /**
     * for next release
     * @return void
     */
    private function log(): void
    {
        if ($this->logger) {
            $logger = $this->logger;
            //TODO make logging
        }
    }
}