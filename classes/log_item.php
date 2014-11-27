<?php

/**
 * @package nxcVarnish
 * @class   nxcVarnishLogItem
 * @author  Serhey Dolgushev <serhey.dolgushev@nxc.no>
 * @date    27 Nov 2014
 * */
class nxcVarnishLogItem extends eZPersistentObject {

    public function __construct( array $row = null ) {
        parent::__construct( $row );

        if( $this->attribute( 'id' ) === null ) {
            $bt = debug_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS );
            foreach( $bt as $i => $call ) {
                // remove calls for current class and index.php
                if( isset( $call['class'] ) === false || $call['class'] === __CLASS__ ) {
                    unset( $bt[$i] );
                }
            }

            $baseDir = getcwd() . '/';
            foreach( $bt as $call ) {
                $backtrace[] = array(
                    'file'     => isset( $call['file'] ) ? str_replace( $baseDir, '', $call['file'] ) : null,
                    'line'     => isset( $call['line'] ) ? $call['line'] : null,
                    'function' => isset( $call['function'] ) ? $call['function'] : null,
                    'class'    => isset( $call['class'] ) ? $call['class'] : null,
                    'type'     => isset( $call['type'] ) ? $call['type'] : null,
                );
            }

            $this->setAttribute( 'backtrace', array_reverse( $backtrace ) );
        } else {
            // Unserialize backtrace
            $this->setAttribute( 'backtrace', unserialize( $this->attribute( 'backtrace' ) ) );
        }
    }

    public function __get( $attr ) {
        return null;
    }

    public static function definition() {
        return array(
            'fields'              => array(
                'id'           => array(
                    'name'     => 'ID',
                    'datatype' => 'integer',
                    'default'  => 0,
                    'required' => true
                ),
                'is_completed' => array(
                    'name'     => 'IsCompleted',
                    'datatype' => 'integer',
                    'default'  => 0,
                    'required' => true
                ),
                'date'         => array(
                    'name'     => 'Date',
                    'datatype' => 'integer',
                    'default'  => time(),
                    'required' => true
                ),
                'server'       => array(
                    'name'     => 'Server',
                    'datatype' => 'string',
                    'default'  => null,
                    'required' => false
                ),
                'request'      => array(
                    'name'     => 'Request',
                    'datatype' => 'string',
                    'default'  => '',
                    'required' => false
                ),
                'response'     => array(
                    'name'     => 'Response',
                    'datatype' => 'string',
                    'default'  => '',
                    'required' => false
                ),
                'duration'     => array(
                    'name'     => 'Duration',
                    'datatype' => 'float',
                    'default'  => 0,
                    'required' => false
                ),
                'backtrace'    => array(
                    'name'     => 'Backtrace',
                    'datatype' => 'string',
                    'default'  => null,
                    'required' => false
                )
            ),
            'function_attributes' => array(
                'backtrace_output' => 'getBacktraceOutput'
            ),
            'keys'                => array( 'id' ),
            'sort'                => array( 'id' => 'desc' ),
            'increment_key'       => 'id',
            'class_name'          => __CLASS__,
            'name'                => 'nxc_varnish_logs'
        );
    }

    public function getBacktraceOutput() {
        return var_export( $this->attribute( 'backtrace' ), true );
    }

    public function store( $fieldFilters = null ) {
        $this->setAttribute( 'backtrace', serialize( $this->attribute( 'backtrace' ) ) );
        eZPersistentObject::storeObject( $this, $fieldFilters );
        $this->setAttribute( 'backtrace', unserialize( $this->attribute( 'backtrace' ) ) );
    }

    public static function fetch( $id ) {
        return eZPersistentObject::fetchObject(
                self::definition(), null, array( 'id' => $id ), true
        );
    }

    public static function fetchList( $conditions = null, $limitations = null, $custom_conds = null ) {
        return eZPersistentObject::fetchObjectList(
                static::definition(), null, $conditions, null, $limitations, true, false, null, null, $custom_conds
        );
    }

    public static function getPossibleServers() {
        $db = eZDB::instance();
        $q  = 'SELECT DISTINCT server FROM nxc_varnish_logs WHERE server IS NOT NULL';
        $r  = $db->arrayQuery( $q );

        $return = array();
        foreach( $r as $row ) {
            $return[] = $row['server'];
        }
        return $return;
    }

    public static function getExpiryTime() {
        return eZINI::instance( 'varnish.ini' )->variable( 'General', 'LogsExpiryTime' );
    }

    public static function countAll( $conds = null, $fields = null ) {
        return eZPersistentObject::count( static::definition(), $conds, $fields );
    }

}
