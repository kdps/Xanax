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

}