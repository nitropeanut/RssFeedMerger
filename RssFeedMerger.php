<?php

/*
 * @author simran
 */
class RssFeedMerger 
{
    private $rssUrls;
    private $feeds;
    private $title;
    private $link;

    public function __construct (array $rssUrls, $title, $link)
    {
        $this->setRssUrls($rssUrls);
    }
    
    public function setTitle ($title)
    {
        $this->title = $title;
    }
    
    public function setLink ($link)
    {
        $this->setLink($link);
    }
    
    public function getTitle()
    {
        return $this->title;
    }
    
    public function getLink ()
    {
        return $this->link;
    }
    
    public function setRssUrls (array $rssUrls)
    {
        $this->rssUrls = $rssUrls;
    }
    
    public function getRssUrls ()
    {
        return $this->rssUrls;
    }
    
    public function addRssUrl ($rssUrl)
    {
        $this->setRssUrls(array_merge($this->getRssUrls(), $rssUrl));
    }
    
    protected function loadFeeds ()
    {
        unset ($this->feeds);
        
        foreach ($this->getRssUrls() as $rssUrl)
        {
            if (($feed = $this->loadFeed($rssUrl)) !== FALSE)
            {
                $this->feeds[] = $feed;
            }
            else
            {
                return false;
            }
        }
        
        return true;
    }

    protected function loadFeed ($rssUrl)
    {
        try
        {
            $feed = Zend_Feed::import ($rssUrl);
        }
        catch (Zend_Feed_Exception $e)
        {
            return false;
        }
        
        return $feed;
    }
    
    public function fetch ()
    {
        if (!$this->loadFeeds())
        {
            throw new Exception ('Failed to load feeds');
        }
        
        $mergedFeedEntries = new RssMergedEntryList();
        
        foreach ($this->feeds as $feed)
        {
            foreach ($feed as $entry)
            {
                $toMergeEntry = new Zend_Feed_Builder_Entry($entry->title(), $entry->link(), $entry->description());
                $toMergeEntry->setLastUpdate(strtotime($entry->pubDate()));
                $mergedFeedEntries->insert($toMergeEntry);
            }
        }
        
        $header = new Zend_Feed_Builder_Header($this->getTitle(), $this->getLink());
        
        $rssBuilder = new RssFeedBuilder($header, iterator_to_array($mergedFeedEntries));
        
        $mergedFeed = Zend_Feed::importBuilder($rssBuilder);
        
        return $mergedFeed->saveXml();
    }
    
}

?>
