<?php
if (!cmsms()) exit;

if(isset($params['item_id']) && !isset($params['event_id'])) $params['event_id'] = $params['item_id'];

if (isset($params['event_id']) || isset($params['event_ids']))
{
	
	$c = new MCFCriteria();
	$c->add('published', '1');
	
	if (isset($params['event_id']))
	{		
		$c->add('id', $params['event_id']);
	}
	else
	{
		$c->add('id', $params['event_ids'], MCFCriteria::IN);
	}
	
	{{$module->getModuleName()}}Object::globalFrontendFilters($c);
	
	$items = {{$module->getModuleName()}}Object::doSelect($c);
	
	if(MCFCalendar::checkCompatibility('{{$module->getModuleName()}}Object'))
	{
		MCFCalendar::loadiCalLibraries();
		
		$a = new iCalendar;
		
		foreach ($items as $item)
		{
			$ev = new iCalendar_event;

			// Convenience: if you don't specify this, one will be auto-generated
			//$ev->add_property('uid', '4306f93e-e379-11d9-bd57-ff0e7e0d5d50');
			//$ev->add_property('uid', rfc2445_guid());
			// Attachments: an application and a URL
			//$ev->add_property('attach', base64_encode('Application-Data-Octets'), array('fmttype' => 'application/octet-stream', 'encoding' => 'BASe64', 'value' => 'binARY'));
			//$ev->add_property('attach', 'http://www.moodle.org/');

			// Summary and description; also resources
			$ev->add_property('summary', $item->getTitle());
			if (method_exists($item, 'getDescription'))
			{
				$ev->add_property('description', $item->getDescription());
			}
			if (method_exists($item, 'getResources'))
			{
				$ev->add_property('resources', explode(',',$item->getResources()));				
			}
			// Start-end date
			//$ev->add_property('class', 'PRIVATE');
			
			$dtstart = date('Ymd', strtotime($item->getStartDate()));
			
			if($start_time = $item->start_time)
			{	
				$dtstart .= 'T' . date('His', strtotime($start_time));
				$ev->add_property('dtstart', $dtstart);
			}
			else
			{
				$ev->add_property('dtstart', $dtstart, array('value' => 'DATE'));
			}

			if(($end_time = $item->end_time) && (($end_time != $start_time) || ($this->end_date != $this->start_date)))
			{
				$dtend = date('Ymd', strtotime($item->getEndDate())) . 'T' . date('His', strtotime($end_time));
				$ev->add_property('dtend', $dtend); 
			}
			else
			{
				$dtend = date('Ymd', strtotime($item->getEndDate() .' + 1 day')); // Need to put one day later for this to work. Don't ask why...
				$ev->add_property('dtend', $dtend , array('value' => 'DATE')); 
			}


						

			//	$ev->add_property('dtstamp', '20050622T235601Z');

			$ev->add_property('dtstamp', date('Ymd\THis\Z', strtotime($item->getCreatedAt())));
						
			//	$ev->add_property('attendee', 'mailto:pj@uom.gr', array('cn' => 'John Papaioannou', 'delegated-from' => array('mailto:bla@some.net', 'mailto:bla@some.net')));
			//$ev->add_property('exdate', array('20050622T235601Z', '20060622T235601Z'));
			//$ev->add_property('exrule', 'FREQ=WEEKLY;COUNT=4;INTERVAL=2;BYDAY=TU,TH');
			//$ev->add_property('request-status', '2.3.1;Some explanation for the request status code');
			//$ev->add_property('recurrence-id', '20050622T235601Z', array('value' => 'DATE-TIME', 'range' => 'thisANDFUTURE'));
			//$ev->add_property('rdate', array('19960403T020000Z/19960403T040000Z','19960404T010000Z/PT3H'), array('value' => 'PERIOD'));
			//$ev->add_property('rdate', array(19970101,19970120,19970217,19970421,19970526,19970704,19970901,19971014,19971128,19971129,19971225), array('value' => 'DATE'));
			//$ev->add_property('geo', array(37.386013,-122.082932));
			//$ev->add_property('organizer', 'MAILTO:jsmith@host1.com', array('cn' => 'John C. Smith', 'dir' => 'ldap://host.com:6666/o=3DDC%20Associates,c=3DUS??(cn=3DJohn%20Smith)'));

			$a->add_component($ev);
		}

		$a->add_property('prodid', '-//M&C - Jean-Christophe Cuvelier//M&C Factory '.date('Y').'//EN');
	//	$a->add_property('version', '2.0');
		$a->add_property('calscale', 'GREGORIAN');
	//	$a->add_property('method', 'PUBLISH');
	
		//header("Content-Type: text/calendar");
		cmsms()->set_variable('content-type', 'text/calendar');
	  	header("Content-Disposition: inline; filename=iCal.ics");
		
		echo $a->serialize();

	}	
}