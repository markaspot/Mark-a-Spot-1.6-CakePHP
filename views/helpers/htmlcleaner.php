<?php  
/** 
 * HtmlCleaner Helper 
 * HTML source code cleaner (great help for cleaning MS Word content) 
 * Uses Tidy if available. 
 * Based on HTMLCleaner 1.0 (c) 2007-2008 Lucian Sabo luciansabo@gmail.com  
 * http://luci.criosweb.ro/blog/2007/08/04/html-cleaner/ 
 *  
 * Copyright (c) 2010 Dominion Enterprises  
 * Licensed under The MIT License 
 *  
 * @author        Pete Hudgins pete.hudgins@dominionenterprises.com 
 * @copyright    Copyright 2010 Dominion Enterprises 
 * @license        http://www.opensource.org/licenses/mit-license.php The MIT License 
 */ 

class HtmlcleanerHelper extends AppHelper 
{ 
    /** 
     * Options for configuring the cleaning 
     * RemoveStyles: removes style definitions like style and class 
     * IsWord: Microsoft Word flag - specific operations may occur 
     * UseTidy: uses the tidy engine also to cleanup the source (recommended) 
     * TidyBefore: apply Tidy first (not recommended as tidy messes up sometimes legitimate spaces
     * CleaningMethod: cleaning methods 
     * OutputXHTML: converts to XHTML by using TIDY. 
     * FillEmptyTableCells: fills empty cells with non-breaking spaces 
     * DropEmptyParas: drops empty paragraphs 
     * Optimize: Optimize code - merge tags 
     * Compress: trims all spaces (line breaks tabs) between tags and between words. 
     * Encoding: the encoding of the html snippet to clean 
     * @var array 
     */ 
    var $_options = array( 
        "RemoveStyles" => true, 
        "IsWord" => true, 
        "UseTidy" => true, 
        "TidyBefore" => false, 
        "CleaningMethod" => array( 
            "tags" => "whitelist", 
            "attributes" => "blacklist" 
        ), 
        "OutputXHTML" => true, 
        "FillEmptyTableCells" => true, 
        "DropEmptyParas" => true, 
        "Optimize" => true, 
        "Compress" => false, 
        "Encoding" => "UTF8" 
    ); 

    /** 
     * Allowable tags 
     * @var string 
     */ 
    var $_tag_whitelist = "<table><tbody><thead><tfoot><tr><th><td><colgroup><col> 
        <p><br/><hr><blockquote><b><i><u><sub><sup><em><tt><var><code><xmp><cite> 
        <pre><abbr><acronym><address><samp><fieldset><legend><a><img><h1><h2><h3> 
        <h4><h4><h5><h6><ul><ol><li><dl><dt><frame><frameset><form><input><select> 
        <option><optgroup><button><textarea>"; 

    /** 
     * Regular Expression for attributes that will be stripped by default 
     * @var string 
     */ 
    var $_attrib_blacklist = "id|on[\w]+"; 

    /** 
     * Tags to cleanup if Optimize is true 
     * @var array  
     */ 
    var $_cleanup_tags = array('a','span','b','i','u','strong','em','big','small', 
        'tt','var','code','xmp','cite','pre','abbr','acronym','address','q','samp', 
        'sub','sup'); 

    /** 
     * Tidy configuration options 
     * @var array  
     */ 
    var $_tidy_config = array( 
        'indent' => true, 
        'output-xhtml' => true, 
        'word-2000' => false, 
        'drop-proprietary-attributes' => true, 
        'hide-comments' => true, 
        'preserve-entities' => true, 
        'quote-ampersand' => true, 
        'show-body-only' => true, 
        'wrap' => 0 
    ); 

    /** 
     * The html snippet to clean 
     * @var string 
     */ 
    var $_html = ""; 

    /** 
     * Configures the options for cleaning 
     * @param array $options Configuration options for the cleaning process 
     */ 
    function setOptions($options = array()) 
    { 
        $default = array( 
            "RemoveStyles" => true, 
            "IsWord" => true, 
            "UseTidy" => true, 
            "TidyBefore" => false, 
            "CleaningMethod" => array( 
                "tags" => "whitelist", 
                "attributes" => "blacklist" 
            ), 
            "OutputXHTML" => true, 
            "FillEmptyTableCells" => true, 
            "DropEmptyParas" => true, 
            "Optimize" => true, 
            "Compress" => false, 
            "Encoding" => "UTF8" 
        ); 
        $new = array_merge_recursive($default, (array)$options); 

        $this->_options = $new; 
        $this->__setTidyConfig(); 
    } 

    /** 
     * Sets the Tidy options based on the configuration of Options. 
     *  
     */ 
    function __setTidyConfig() 
    { 
        if($this->_options["IsWord"]){ 
            $this->_tidy_config['word-2000'] = true; 
            $this->_tidy_config['drop-proprietary-attributes'] = true; 
        } 
        else { 
            $this->_tidy_config['word-2000'] = false; 
        } 
        if($this->_options["OutputXHTML"]) { 
            $this->_options["UseTidy"] = true; 
            $this->_tidy_config['output-xhtml'] = true; 
        } 
        else { 
            $this->_tidy_config['output-xhtml'] = false; 
        } 
    } 

    /** 
     * Removes attributes from html tags that match the provided pattern 
     * Example of pattern: "id|on[\w]+" 
     * @param string $attribs Regex pattern of attributes to remove 
     */ 
    function removeBlacklistedAttributes($attribs) 
    { 
        $this->_html = preg_replace('/[\s]+('.$attribs.')=[\s]*("[^"]*"|\'[^\']*\')/i',"",$this->_html);
        $this->_html = preg_replace('/[\s]+('.$attribs.')=[\s]*[^ |^>]*/i',"",$this->_html); 
    } 

    /** 
     * Uses the Tidy Configuration to run Tidy's cleanRepair method, if available. 
     */ 
    function tidyClean() 
    { 
        if(!class_exists('tidy')){ 
            if(function_exists('tidy_parse_string')){ 
                tidy_set_encoding("{$this->_options["Encoding"]}"); 
                foreach($this->_tidy_config as $k => $v) { 
                    tidy_setopt($k, $v); 
                } 
                tidy_parse_string($this->_html); 
                tidy_clean_repair(); 
                $this->_html = tidy_get_output(); 
            } 
            else { 
                error_log("Tidy is not supported on this platform. Basic Cleaning is applied.");
            } 
        } 
        else { 
            $tidy = new tidy; 
            $tidy -> parseString($this->_html, $this->_tidy_config, "{$this->_options["Encoding"]}"); 
            $tidy -> cleanRepair(); 
            $this -> html = $tidy; 
        } 
    } 

    /** 
     * Cleans the provided html snippet based on the configuation options 
     * @param string $html The html snippet to clean 
     * @param array $options Optional Configuration options for the cleaning process 
     * @return string The cleaned html snippet 
     */ 
    function cleanup($html, $options = null) 
    { 
        if(isset($options) && is_array($options)){ 
            $this->setOptions($options); 
        } 
        $this->_html = "{$html}"; 

        if($this->_options['UseTidy'] && $this->_options['TidyBefore']){ 
            $this->tidyClean(); 
        } 
        


        // Remove escape slashes 
        $this->_html = stripslashes($this -> _html); 

        if($this->_options['CleaningMethod']['tags'] == "whitelist"){ 
            // Trim everything before body tag, leaving possible body attributes 
            if(preg_match("/<body/i", "{$this -> _html}")){ 
                $this -> html = stristr($this -> _html, "<body"); 
            } 

            // strip tags, still leaving attributes, second variable is allowed tags 
            $this->_html = strip_tags($this->_html, $this->_tag_whitelist); 
        } 

        if($this->_options['RemoveStyles']){ 
            // Remove class and style attributes 
            $this->removeBlacklistedAttributes("class|style"); 
        } 

        if($this->_options['IsWord']){ 
            $this->removeBlacklistedAttributes("lang|[ovwxp]:\w+"); 
        } 

        if($this->_options['CleaningMethod']['attributes'] == "blacklist"){ 
            if(!empty ($this->_attrib_blacklist)){ 
                $this->removeBlacklistedAttributes($this->_attrib_blacklist); 
            } 
        } 

        if($this->_options['Optimize']){ 
            $repl = 1; 
            while($repl){ 
                $repl = 0; 
                foreach($this->_cleanup_tags as $tag){ 
                    // Strip empty inline tags 
                    $this -> _html = preg_replace("/<($tag)[^>]*>[\s]*([(&nbsp;)]*)[\s]*<\/($tag)>/i","\\2", $this -> _html,-1,$count); 
                    $repl += $count; 

                    // Merge inline tags 
                    $this -> _html = preg_replace("/<\/($tag)[^>]*>[\s]*([(&nbsp;)]*)[\s]*<($tag)>/i","\\2", $this -> _html,-1,$count); 
                    $repl += $count; 
                } 
            } 

            // Drop empty paragraph tags 
            
            // HK >>> Added this line to preseve linebreaks
            $this->_html = nl2br($this->_html);

            if($this->_options['DropEmptyParas']){ 
                $this -> _html = preg_replace('/<(p|h[1-6]{1})([^>]*)>[\s]*[(&nbsp;)]*[\s]*<\/(p|h[1-6]{1})>/i',"\r\n", $this -> _html); 
            } 

            // Trim extra spaces only if tidy is not set to indent 
            if(!$this->_tidy_config['indent']){ 
                // Trim extra spaces between words 
                $this -> _html = preg_replace('/([^<>])[\s]+([^<>])/i',"\\1 \\2", $this -> _html); 

                // Trim extra spaces before tags 
                $this -> _html = preg_replace('/[\n|\r|\r\n|][\n|\r|\r\n|]+</i',"<", $this -> _html); 
            } 
        } 

        if($this->_options['DropEmptyParas'] && !$this->_options['Optimize']){ 
            $this -> _html = preg_replace('/<(p|h[1-6]{1})([^>]*)>[\s]*[(&nbsp;)]*[\s]*<\/(p|h[1-6]{1})>/i',"\r\n", $this -> _html); 
        } 

        if($this->_options['FillEmptyTableCells']) { 
            $this -> _html = preg_replace("/<td([^>]*)>[\s]*<\/td>/i", "<td\\1>&nbsp;</td>", $this -> _html);
        } 

        if($this->_options['Compress']){ 
            // Trim spaces after tags 
            $this -> _html = preg_replace('/>[\s]+/',">", $this -> _html); 

            // Trim spaces before end tags 
            $this -> _html = preg_replace('/[\s]+<\//',"</", $this -> _html); 

            // Trim spaces before tags 
            $this -> _html = preg_replace('/[\s]+</',"<", $this -> _html); 

            // Trim extra spaces between words 
            $this -> _html = preg_replace('/([^<>])[\s]+([^<>])/',"\\1 \\2", $this -> _html); 
        } 

        if($this->_options['UseTidy'] && !$this->_options['TidyBefore']){ 
            $this->tidyClean(); 
        } 
        return $this->output("{$this->_html}"); 
    } 
} 
?>