<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.1
* File                    : includes/fees/class-frontend-fees.php
* File Version            : 1.0.3
* Created / Last Modified : 26 August 2015
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Front end fees PHP class.
*/

    if (!class_exists('DOPBSPFrontEndFees')){
        class DOPBSPFrontEndFees extends DOPBSPFrontEnd{
            /*
             * Constructor.
             */
            function __construct(){
            }
            
            /*
             * Get selected fees.
             * 
             * @param ids (string): fees IDs
             * @param language (string): selected language
             * 
             * @return data array
             */
            function get($ids,
                         $language = DOPBSP_CONFIG_TRANSLATION_DEFAULT_LANGUAGE){
                global $wpdb;
                global $DOPBSP;
                
                if ($ids != ''){
                    $where_query = array();
                    $ids_list = explode(',', $ids);

                    foreach ($ids_list as $id){
                        array_push($where_query, 'id='.$id);
                    }

                    $fees = $wpdb->get_results('SELECT * FROM '.$DOPBSP->tables->fees.' WHERE '.implode(' OR ', $where_query).' ORDER BY id');

                    foreach ($fees as $fee){
                        $fee->translation = $DOPBSP->classes->translation->decodeJSON($fee->translation,
                                                                                      $language);
                    }

                    return array('data' => array('fees' => $fees),
                                 'text' => array('byDay' => $DOPBSP->text('FEES_FRONT_END_BY_DAY'),
                                                 'byHour' => $DOPBSP->text('FEES_FRONT_END_BY_HOUR'),
                                                 'included' => $DOPBSP->text('FEES_FRONT_END_INCLUDED'),
                                                 'title' => $DOPBSP->text('FEES_FRONT_END_TITLE')));
                }
                else{
                    return array('data' => array('fees' => array()),
                                 'text' => array('byDay' => $DOPBSP->text('FEES_FRONT_END_BY_DAY'),
                                                 'byHour' => $DOPBSP->text('FEES_FRONT_END_BY_HOUR'),
                                                 'included' => $DOPBSP->text('FEES_FRONT_END_INCLUDED'),
                                                 'title' => $DOPBSP->text('FEES_FRONT_END_TITLE')));
                }
            }
        }
    }