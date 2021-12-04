<?php

class PHPDataObjectAttributes {

	private $connection;

	public function __construct($connection) {
		self::$connection = $connection;
	}

    public function setAttribute($key, $value) {
        self::$connection->setAttribute($key, $value);
    }

    public function setColumNameCase($value) {
        $this->setAttribute(\PDO::ATTR_CASE, $value);
    }

    public function setColumNameNaturalCase() {
        $this->setColumNameCase(\PDO::CASE_NATURAL);
    }

    public function setColumNameLowerCase() {
        $this->setColumNameCase(\PDO::CASE_LOWER);
    }

    public function setColumNameUpperCase() {
        $this->setColumNameCase(\PDO::CASE_UPPER);
    }

    public function setErrorReportingMode($value) {
        $this->setAttribute(\PDO::ATTR_ERRMODE, $value);
    }

    public function setSilentErrorReportingMode() {
        $this->setColumNameCase(\PDO::ERRMODE_SILENT);
    }

    public function setWarningErrorReportingMode() {
        $this->setColumNameCase(\PDO::ERRMODE_WARNING);
    }

    public function setExceptionErrorReportingMode() {
        $this->setColumNameCase(\PDO::ERRMODE_EXCEPTION);
    }

    public function setTimeout($value) {
        $this->setAttribute(\PDO::ATTR_TIMEOUT, $value);
    }

    public function useEmulatePreparedStatement(bool $bool) {
        $this->setAttribute(\PDO::ATTR_EMULATE_PREPARES, $bool);
    }

    // If this attribute is set to true on a PDOStatement, the MySQL driver will use the buffered versions of the MySQL API.
    public function useBufferedQueries(bool $bool) {
        $this->setAttribute(\PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, $bool);
    }

    public function setDefaultFetchMode($string) {
        $this->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, $string);
    }

    public function setAssociativeArrayFetch(bool $bool) {
        $this->setDefaultFetchMode(\PDO::FETCH_ASSOC, $bool);
    }

    // Duplicate column avoidance
    public function setAssociativeArraySameColumnNameFetch(bool $bool) {
        $this->setDefaultFetchMode(\PDO::FETCH_NAMED, $bool);
    }
    
    public function setColunNumberFetch(bool $bool) {
        $this->setDefaultFetchMode(\PDO::FETCH_NUM, $bool);
    }

    public function setPredefinedClassFetch(bool $bool) {
        $this->setDefaultFetchMode(\PDO::FETCH_OBJ, $bool);
    }

    // Command to execute when connecting to the MySQL server. Will automatically be re-executed when reconnecting.
    public function setConnectionCommand($string) {
        $this->setAttribute(\PDO::MYSQL_ATTR_INIT_COMMAND, $string);
    }

    // The file path to the SSL certificate.
    public function setSSLCertificateFilePath($filepath) {
        $this->setAttribute(\PDO::MYSQL_ATTR_SSL_CERT, $filepath);
    }

    // The file path to the directory that contains the trusted SSL CA certificates, which are stored in PEM format.
    public function setTrustedSSLCACertificateFilePath($filepath) {
        $this->setAttribute(\PDO::MYSQL_ATTR_SSL_CAPATH, $filepath);
    }

    // The file path to the SSL key.
    public function setSSLCertificateKeyFilePath($filepath) {
        $this->setAttribute(\PDO::MYSQL_ATTR_SSL_KEY, $filepath);
    }

    // Enable network communication compression.
    public function setNetworkCommunicationCompression($enable) {
        $this->setAttribute(\PDO::MYSQL_ATTR_COMPRESS, $enable);
    }

    public function setSSLEncryptionCipher($cipher) {
        $this->setAttribute(\PDO::MYSQL_ATTR_SSL_CIPHER, $cipher);
    }

    // Disables multi query execution
    public function useMultiQueryExecution($size) {
        $this->setAttribute(\PDO::MYSQL_ATTR_MULTI_STATEMENTS, $size);
    }

}