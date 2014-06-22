<?php

  class MCFExtraFeatures
  {
    var $version = 1;
    
    protected $features;
    
    // public function __toString()
    //     {
    //       return '';
    //     }
    
    // Selectors
    
    public function getSelector($name)
    {
      return (isset($this->features['selectors'][$name]))?$this->features['selectors'][$name]:null;
    }
    
    public function setSelector($name, MCFSelector $selector)
    {
      $this->features['selectors'][$name] = $selector;
    }
    
	// Events

	public function getEvents()
	{
		return $this->features['events'];
	}
	
	public function getEvent($module_name, $event_name)
	{
		return (isset($this->features['events'][$module_name][$event_name]))?$this->features['events'][$module_name][$event_name]:null;
	}
    
	public function removeEvent($module_name, $event_name)
	{
		unset($this->features['events'][$module_name][$event_name]);
	}
    
	public function setEvent($module_name, $event_name, $code)
	{
		$this->features['events'][$module_name][$event_name] = $code;
	}
  }