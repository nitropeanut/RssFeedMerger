<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RssFeedBuilder
 *
 * @author simran
 */
class RssFeedBuilder implements Zend_Feed_Builder_Interface
{
    private $header;
    
    public function __construct (Zend_Feed_Builder_Header $header, array $entries)
    {
        $this->setHeader($header);
        $this->setEntries($entries);
    }
    
    public function setEntries (array $entries)
    {
        $this->entries = $entries;
    }
    
    public function setHeader (Zend_Feed_Builder_Header $header)
    {
        $this->header = $header;
    }
    
    public function getHeader ()
    {
        return $this->header;
    }
    
    public function getEntries ()
    {
        return $this->entries;
    }
}

?>
