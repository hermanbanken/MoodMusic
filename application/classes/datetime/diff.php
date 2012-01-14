<?php
class Datetime_Diff extends DateTime {
    
    protected $strings = array(
        'y' => array('1 year ago', '%d years ago'),
        'm' => array('1 month ago', '%d months ago'),
        'd' => array('1 day ago', '%d days ago'),
        'h' => array('1 hour ago', '%d hours ago'),
        'i' => array('1 minute ago', '%d minutes ago'),
        's' => array('now', '%d seconds ago'),
    );
    
    /**
     * Returns the difference from the current time in the format X time ago
     * @return string
     */
    public function __toString() {
        $now = new DateTime('now');
        $diff = $this->diff($now);
        
        foreach($this->strings as $key => $value){
            if( ($text = $this->getDiffText($key, $diff)) ){
                return $text;
            }
        }
        return '';
    }
    
    /**
     * Try to construct the time diff text with the specified interval key
     * @param string $intervalKey A value of: [y,m,d,h,i,s]
     * @param DateInterval $diff
     * @return string|null
     */
    protected function getDiffText($intervalKey, $diff){
        $pluralKey = 1;
        $value = $diff->$intervalKey;
        if($value > 0){
            if($value < 2){
                $pluralKey = 0;
            }
            return sprintf($this->strings[$intervalKey][$pluralKey], $value);
        }
        return null;
    }
}
?>