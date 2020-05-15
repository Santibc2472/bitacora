<?php

/*
 * Title                   : DOT Framework
 * File                    : framework/includes/class-database.php
 * Author                  : Dot on Paper
 * Copyright               : © 2017 Dot on Paper
 * Website                 : https://www.dotonpaper.net
 * Description             : Database PHP class.
 */

    if (!class_exists('DOTDatabase')){
        class DOTDatabase{
	    /*
	     * Public variables.
	     */
	    public $error; // Query error description.
	    public $insert_id; // The ID of a row when it is added to a table.
	    public $result; // A list with query results.
	    public $result_query; // An object with query results.
	    public $rows_affected; // The number of rows affected by a query.
	    public $rows_no; // The number of rows returned by a query.
	    public $query; // The query that is being executed.
	    
            /*
             * Constructor
	     * 
	     * @usage
	     *	    The constructor is called when a class instance is created.
	     * 
             * @params
	     *	    -
	     * 
	     * @post
	     *	    -
	     * 
	     * @get
	     *	    -
	     * 
	     * @sessions
	     *	    -
	     * 
	     * @cookies
	     *	    -
	     * 
	     * @constants
	     *	    -
	     * 
	     * @globals
	     *	    -
	     * 
	     * @functions
	     *	    -
	     *	    
	     * @hooks
	     *	    -
	     * 
	     * @layouts
	     *	    -
	     * 
	     * @return
	     *	    -
	     * 
	     * @return_details
	     *	    -
	     * 
	     * @dv
	     *	    -
	     * 
	     * @tests
	     *	    -
             */
            function __construct(){
            }
	    
/*
 * Main functions.
 */
	    
            /*
             * Initialize tables names.
	     * 
	     * @usage
	     *	    framework/dot.php : init()
	     * 
             * @params
	     *	    -
	     * 
	     * @post
	     *	    -
	     * 
	     * @get
	     *	    -
	     * 
	     * @sessions
	     *	    -
	     * 
	     * @cookies
	     *	    -
	     * 
	     * @constants
	     *	    DOT_DATABASE_TABLES_PREFIX (string): tables names prefix from the database
	     * 
	     * @globals
	     *	    wpdb (object): WordPress database object
	     * 
	     *	    DOT (object): DOT framework main class variable
	     *	    dot_database_tables (array): a list with all database tables
	     * 
	     * @functions
	     *	    -
	     *	    
	     * @hooks
	     *	    -
	     * 
	     * @layouts
	     *	    -
	     * 
	     * @return
	     *	    Tables list.
	     * 
	     * @return_details
	     *	    The public variable [DOT->tables] from framework/dot.php will be completed with all tables keys.
	     * 
	     * @dv
	     *	    -
	     * 
	     * @tests
	     *	    -
             */
            public function tables(){
		global $DOT;
                global $dot_database_tables;
		global $wpdb;
		
		foreach ($dot_database_tables as $key => $table){
		    $table = $table;
		    $DOT->tables->$key = $wpdb->prefix.DOT_DATABASE_TABLES_PREFIX.$key;
		}
            }

	    /*
	     * Set query results, usually after a query is executed.
	     * 
	     * @usage
	     *	    this : delete()
	     *	    this : insert()
	     *	    this : query()
	     *	    this : replace()
	     *	    this : results()
	     *	    this : row()
	     *	    this : update()
	     *	    this : val()
	     * 
             * @params
	     *	    -
	     * 
	     * @post
	     *	    -
	     * 
	     * @get
	     *	    -
	     * 
	     * @sessions
	     *	    -
	     * 
	     * @cookies
	     *	    -
	     * 
	     * @constants
	     *	    -
	     * 
	     * @globals
	     *	    wpdb (object): WordPress database object
	     * 
	     * @functions
	     *	    -
	     *	    
	     * @hooks
	     *	    -
	     * 
	     * @layouts
	     *	    -
	     * 
	     * @return
	     *	    All public variables are set.
	     * 
	     * @return_details
	     *	    Public variables type:
	     *		error (string/boolean): wpdb->last_error
	     *		insert_id (integer): wpdb->insert_id
	     *		result (array): wpdb->last_result
	     *		result_query (object): wpdb->result
	     *		rows_affected (integer): wpdb->rows_affected
	     *		rows_no (integer): wpdb->num_rows
	     *		query (string): wpdb->last_query
	     * 
	     * @dv
	     *	    -
	     * 
	     * @tests
	     *	    -
             */
	    public function set(){
		global $wpdb;
		
		$this->error = $wpdb->last_error;
		$this->insert_id = $wpdb->insert_id;
		$this->result = $wpdb->last_result;
		$this->result_query = $wpdb->result;
		$this->rows_affected = $wpdb->rows_affected;
		$this->rows_no = $wpdb->num_rows;
		$this->query = $wpdb->last_query;
	    }

/*
 * Query functions.
 */
	    
	    /*
	     * Execute a MySQL database query.
	     * 
	     * @usage
	     *	    Reserved framework function that will be called by DOT application.
	     * 
             * @params
	     *	    query (string): the query to be executed
	     * 
	     * @post
	     *	    -
	     * 
	     * @get
	     *	    -
	     * 
	     * @sessions
	     *	    -
	     * 
	     * @cookies
	     *	    -
	     * 
	     * @constants
	     *	    -
	     * 
	     * @globals
	     *	    wpdb (object): WordPress database object
	     * 
	     * @functions
	     *	    WP : wpdb->query() // Execute a query.
	     * 
	     *	    this : this() // Set query results.
	     *	    
	     * @hooks
	     *	    -
	     * 
	     * @layouts
	     *	    -
	     * 
	     * @return
	     *	    Query result.
	     * 
	     * @return_details
	     *	    -
	     * 
	     * @dv
	     *	    -
	     * 
	     * @tests
	     *	    -
             */
	    public function query($query){
		global $wpdb;
		
		$result = $wpdb->query($query);
		
		$this->set();
		
		return $result;
	    }
	    
	    /*
	     * Create query for safe execution.
	     * 
	     * @usage
	     *	    Reserved framework function that will be called by DOT application.
	     * 
             * @params
	     *	    query (string): the query to be executed
	     *	    values (array): the list of values passed to the query
	     * 
	     * @post
	     *	    -
	     * 
	     * @get
	     *	    -
	     * 
	     * @sessions
	     *	    -
	     * 
	     * @cookies
	     *	    -
	     * 
	     * @constants
	     *	    -
	     * 
	     * @globals
	     *	    wpdb (object): WordPress database object
	     * 
	     * @functions
	     *	    WP : wpdb->prepare() // Delete rows from a table.
	     * 
	     * @hooks
	     *	    -
	     * 
	     * @layouts
	     *	    -
	     * 
	     * @return
	     *	    Safe query string.
	     * 
	     * @return_details
	     *	    The query string is escaped to prevent injections, remove double quotes, single quotes and add the appropriate values type (%d, %F, %s).
	     * 
	     * @dv
	     *	    -
	     * 
	     * @tests
	     *	    -
             */
	    public function safe($query,
				 $values){
		global $wpdb;
		
		return $wpdb->prepare($query, $values);
	    }
	    
	    /*
	     * Delete one or more rows in a database table.
	     * 
	     * @usage
	     *	    Reserved framework function that will be called by DOT application.
	     * 
             * @params
             *	    table (string): table name
	     *	    where (array): conditions
	     *	    formats_where (array): conditions values format
	     * 
	     * @post
	     *	    -
	     * 
	     * @get
	     *	    -
	     * 
	     * @sessions
	     *	    -
	     * 
	     * @cookies
	     *	    -
	     * 
	     * @constants
	     *	    -
	     * 
	     * @globals
	     *	    wpdb (object): WordPress database object
	     * 
	     * @functions
	     *	    WP : wpdb->delete() // Delete rows from a table.
	     * 
	     *	    this : set() // Set query results.
	     *	    
	     * @hooks
	     *	    -
	     * 
	     * @layouts
	     *	    -
	     * 
	     * @return
	     *	    The number of rows deleted.
	     * 
	     * @return_details
	     * 
	     * @dv
	     *	    -
	     * 
	     * @tests
	     *	    -
             */
	    public function delete($table,
				   $where,
				   $formats_where = null){
		global $wpdb;
		
		$result = $wpdb->delete($table,
					$where,
					$formats_where);
		
		$this->set();
		
		return $result;
	    }
	    
	    /*
	     * Insert a row into a database table.
	     * 
	     * @usage
	     *	    Reserved framework function that will be called by DOT application.
	     * 
             * @params
             *	    table (string): table name
	     *	    values (array): values to be added to the database
	     *	    formats (array): values format
	     * 
	     * @post
	     *	    -
	     * 
	     * @get
	     *	    -
	     * 
	     * @sessions
	     *	    -
	     * 
	     * @cookies
	     *	    -
	     * 
	     * @constants
	     *	    -
	     * 
	     * @globals
	     *	    wpdb (object): WordPress database object
	     * 
	     * @functions
	     *	    WP : wpdb->insert() // Insert a row into a table.
	     * 
	     *	    this : set() // Set query results.
	     *	    
	     * @hooks
	     *	    -
	     * 
	     * @layouts
	     *	    -
	     * 
	     * @return
	     *	    New row ID.
	     * 
	     * @return_details
	     * 
	     * @dv
	     *	    -
	     * 
	     * @tests
	     *	    -
             */
	    public function insert($table,
				   $values,
				   $formats = null){
		global $wpdb;
		
		$result = $wpdb->insert($table,
					$values,
					$formats);
		
		$this->set();
		
		return $result;
	    }
	    
	    /*
	     * Replace row fields in a database table.
	     * 
	     * @usage
	     *	    Reserved framework function that will be called by DOT application.
	     * 
             * @params
             *	    table (string): table name
	     *	    values (array): values to be added to the database
	     *	    formats (array): values format
	     * 
	     * @post
	     *	    -
	     * 
	     * @get
	     *	    -
	     * 
	     * @sessions
	     *	    -
	     * 
	     * @cookies
	     *	    -
	     * 
	     * @constants
	     *	    -
	     * 
	     * @globals
	     *	    wpdb (object): WordPress database object
	     * 
	     * @functions
	     *	    WP : wpdb->replace() // Replace a row in a table.
	     * 
	     *	    this : set() // Set query results.
	     *	    
	     * @hooks
	     *	    -
	     * 
	     * @layouts
	     *	    -
	     * 
	     * @return
	     *	    Replaced row ID.
	     * 
	     * @return_details
	     * 
	     * @dv
	     *	    -
	     * 
	     * @tests
	     *	    -
             */
	    public function replace($table,
				    $values,
				    $formats = null){
		global $wpdb;
		
		$result = $wpdb->replace($table,
					 $values,
					 $formats);
		
		$this->set();
		
		return $result;
	    }
	    
	    /*
	     * Update row fields in a database table.
	     * 
	     * @usage
	     *	    Reserved framework function that will be called by DOT application.
	     * 
             * @params
             *	    table (string): table name
             *	    values (array): values to be updated to the database
	     *	    where (array): conditions
	     *	    formats (array): values format
	     *	    formats_where (array): conditions values format
	     * 
	     * @post
	     *	    -
	     * 
	     * @get
	     *	    -
	     * 
	     * @sessions
	     *	    -
	     * 
	     * @cookies
	     *	    -
	     * 
	     * @constants
	     *	    -
	     * 
	     * @globals
	     *	    wpdb (object): WordPress database object
	     * 
	     * @functions
	     *	    WP : wpdb->update() // Update a row in a table.
	     * 
	     *	    this : set() // Set query results.
	     *	    
	     * @hooks
	     *	    -
	     * 
	     * @layouts
	     *	    -
	     * 
	     * @return
	     *	    The number of rows updated.
	     * 
	     * @return_details
	     * 
	     * @dv
	     *	    -
	     * 
	     * @tests
	     *	    -
             */
	    public function update($table,
				   $values,
				   $where,
				   $formats = null,
				   $formats_where = null){
		global $wpdb;
		
		$result = $wpdb->update($table,
					$values,
					$where,
					$formats = null,
					$formats_where = null);
		
		$this->set();
		
		return $result;
	    }
	    
	    /*
	     * Get query results.
	     * 
	     * @usage
	     *	    Reserved framework function that will be called by DOT application.
	     * 
             * @params
             *	    query (string): the query to be executed
	     * 
	     * @post
	     *	    -
	     * 
	     * @get
	     *	    -
	     * 
	     * @sessions
	     *	    -
	     * 
	     * @cookies
	     *	    -
	     * 
	     * @constants
	     *	    -
	     * 
	     * @globals
	     *	    wpdb (object): WordPress database object
	     * 
	     * @functions
	     *	    WP : wpdb->get_results() // Get generic results.
	     * 
	     *	    this : this() // Set query results.
	     *	    
	     * @hooks
	     *	    -
	     * 
	     * @layouts
	     *	    -
	     * 
	     * @return
	     *	    Query results array.
	     * 
	     * @return_details
	     * 
	     * @dv
	     *	    -
	     * 
	     * @tests
	     *	    -
             */
	    public function results($query){
		global $wpdb;
		
		$result = $wpdb->get_results($query);
		
		$this->set();
		
		return $result !== null ? $result:false;
	    }
	    
	    /*
	     * Get one row from a database table.
	     * 
	     * @usage
	     *	    Reserved framework function that will be called by DOT application.
	     * 
             * @params
             *	    query (string): the query to be executed
             *	    row (integer): row number
	     * 
	     * @post
	     *	    -
	     * 
	     * @get
	     *	    -
	     * 
	     * @sessions
	     *	    -
	     * 
	     * @cookies
	     *	    -
	     * 
	     * @constants
	     *	    -
	     * 
	     * @globals
	     *	    wpdb (object): WordPress database object
	     * 
	     * @functions
	     *	    WP : wpdb->get_row() // Get row.
	     * 
	     *	    this : this() // Set query results.
	     *	    
	     * @hooks
	     *	    -
	     * 
	     * @layouts
	     *	    -
	     * 
	     * @return
	     *	    Query results selected row or false if it does not exist.
	     * 
	     * @return_details
	     * 
	     * @dv
	     *	    -
	     * 
	     * @tests
	     *	    -
	     */
	    public function row($query, 
				$row = 0){
		global $wpdb;
		
		$result = $wpdb->get_row($query,
					 OBJECT,
					 $row);
		
		$this->set();
		
		return $result !== null ? $result:false;
	    }
	    
	    /*
	     * Get the value of one column from one row from a database table.
	     * 
	     * @usage
	     *	    Reserved framework function that will be called by DOT application.
	     * 
             * @params
             *	    query (string): the query to be executed
             *	    column (integer): column number
             *	    row (integer): row number
	     * 
	     * @post
	     *	    -
	     * 
	     * @get
	     *	    -
	     * 
	     * @sessions
	     *	    -
	     * 
	     * @cookies
	     *	    -
	     * 
	     * @constants
	     *	    -
	     * 
	     * @globals
	     *	    wpdb (object): WordPress database object
	     * 
	     * @functions
	     *	    WP : wpdb->get_var() // Get a variable.
	     * 
	     *	    this : this() // Set query results.
	     *	    
	     * @hooks
	     *	    -
	     * 
	     * @layouts
	     *	    -
	     * 
	     * @return
	     *	    The column value.
	     * 
	     * @return_details
	     * 
	     * @dv
	     *	    -
	     * 
	     * @tests
	     *	    -
	     */
	    public function val($query = null, 
				$column = 0, 
		                $row = 0){
		global $wpdb;
		
		$result = $wpdb->get_var($query,
					 $column,
					 $row);
		
		$this->set();
		
		return $result !== null ? $result:false;
	    }
        }
    }