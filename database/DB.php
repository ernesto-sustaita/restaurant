<?php
namespace database;

/**
 *
 * @author ernesto
 *        
 */
class DB
{
    /**
     * @var DB The reference to *DB* instance of this class
     */
    private static $instance;
    
    /**
     * @var object mysqli handler
     */
    private $mysqli;
    
    /**
     * Returns the *DB* instance of this class.
     *
     * @return object Singleton The *Singleton* instance
     */
    public static function getInstance()
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }
        
        return static::$instance;
    }
    
    /**
     * Protected constructor to prevent creating a new instance of the
     * *DB* via the `new` operator from outside of this class.
     */
    protected function __construct()
    {
        $this->mysqli = new \MySQLI('localhost', 'usuario_pos', 'YssqnsN_2021', 'pos');
        $this->mysqli->set_charset('utf8');
    }
    
    /**
     * Private clone method to prevent cloning of the instance of the
     * *DB* instance.
     */
    private function __clone()
    {
    }
    
    /**
     * Private unserialize method to prevent unserializing of the *DB*
     * instance.
     */
    private function __wakeup()
    {
    }
    
    /**
     * Returns the database handler.
     *
     * @return object mysqli The database handler
     */
    public function handler()
    {
        return $this->mysqli;
    }
    
    /**
     * Runs a MySQL query.
     *
     * @param string The sql query
     *
     * @return false|\mysqli_result The result of running the query
     */
    public function query($sql)
    {
        return $this->mysqli->query($sql);
    }
    
    /**
     * Escapes the data to prevent MySQL injections.
     *
     * @param string The string to be escaped
     *
     * @return string The escaped string
     */
    public function escape($data)
    {
        return $this->mysqli->real_escape_string($data);
    }
    
    /**
     * 
     * @param string $sql
     * @return false|\mysqli_stmt
     */
    public function prepare($sql){
        return  $this->mysqli->prepare($sql);
    }
    
    /**
     * 
     * @return int
     */
    public function getLastInsertId(){
        return $this->mysqli->insert_id;
    }
    
    /**
     * 
     * @return int
     */
    public function getAffectedRows(){
        return $this->mysqli->affected_rows;
    }

}

