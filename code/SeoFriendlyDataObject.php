<?php
/**
 * SEO Friendly Data Objects
 * 
 * Please note that is uses the DataObjects title to generate a URLSegment
 */
class SeoFriendlyDataObject extends DataExtension
{
    /**
     * Create the MyYardStick data fields
     */
    public static $db = array(
        "URLSegment" => "Varchar(255)" // SEO friendly URL/Slug
    );
    
    /**
     * Get a DataObject record using the slug
     * 
     * @param string $class The Silverstripe class name of the object to get.
     * @param string $id url segment/slug
     */
    public static function get_by_url_segement($class, $uRLSegment)
    {
        return $class::get()->where("URLSegment='{$uRLSegment}'")->first();
    }
    
    /**
     * Generate a URL segment based on the title provided.
     * 
     * @param string $title Page title.
     * @return string Generated url segment
     */
    protected function generateURLSegment($title)
    {
        $filter = URLSegmentFilter::create();
        $t = $filter->filter($title);
        
        // Fallback to generic name if path is empty (= no valid, convertable characters)
        if (!$t || $t == '-' || $t == '-1') {
            $t = "{$this->owner->ClassName}-{$this->owner->ID}";
        } else {
            // Make sure that it does not already exists for another object
            $class = $this->owner->ClassName;
            $obj = $class::get()
                    ->filter(array("URLSegment" => $t))
                    ->exclude(array("ID" => $this->owner->ID))
                    ->first();
            if ($obj) {
                $t .= "-{$this->owner->ID}";
            }
        }

        return $t;
    }
    
    /**
     * Generate a URL Segement before the data object gets written
     */
    public function onBeforeWrite()
    {
        if ($this->owner->Title) {
            $this->owner->URLSegment = $this->generateURLSegment($this->owner->Title);
        }
        parent::onBeforeWrite();
    }
    
    /**
     * Update the CMS
     * 
     * @param FieldList $fields
     */
    public function updateCMSFields(FieldList $fields)
    {
        $fields->replaceField("URLSegment", $fields->dataFieldByName("URLSegment")->performReadonlyTransformation());
    }
}
