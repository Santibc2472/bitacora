<?php
    if(!defined('ABSPATH')){
    	exit;
	}
    
    class booking_package_iCal {
        
        public $prefix = null;
        
        public $pluginName = null;
        
        public $setting = null;
        
        public function __construct($prefix, $pluginName) {
            
            $this->prefix = $prefix;
            $this->pluginName = $pluginName;
            $this->setting = new booking_package_setting($prefix);
            
        }
        
        public function isValid($token, $id = 'all'){
            
            #var_dump($token);
            $booking_sync = $this->setting->getBookingSyncList();
            $booking_sync = $booking_sync['iCal'];
            
            if ($id == 'all') {
                
                if (intval($booking_sync[$this->prefix.'ical_active']['value']) == 1 && $booking_sync[$this->prefix.'ical_token']['value'] == $token) {
                    
    			    $this->getBookingSchedules($id);
                    exit;
                    
                } else {
                    
                    return false;
                    
                }
                
            } else {
                
                $schedule = new booking_package_schedule($this->prefix, $this->pluginName);
                $calendarAccount = $schedule->getCalendarAccount($id);
                if (intval($calendarAccount['ical']) == 1 && $calendarAccount['icalToken'] == $token) {
                    
                    $this->getBookingSchedules($id);
                    exit;
                    
                } else {
                    
                    return false;
                    
                }
                
            }
            
        }
        
        public function getBookingSchedules($id = 'all'){
            
            #$timezone = get_option('timezone_string');
            $timezone = get_option($this->prefix . "timezone", null);
			if (is_null($timezone)) {
				
				$timezone = get_option('timezone_string', 'UTC');
				
			}
            
		    date_default_timezone_set('UTC');
		    $unixTime = date('U') - (7 * 1440 * 60);
		    $gmtOffset = get_option('gmt_offset');
		    $gmtOffset = date('P');
		    $url_parce = parse_url(get_home_url());
		    $host = $url_parce["host"];
		    
		    print "BEGIN:VCALENDAR\n";
            print "PRODID:-//WP_BOOKING_APP/" . $host . "\n";
            print "VERSION:2.0\n";
            print "CALSCALE:GREGORIAN\n";
            print "METHOD:PUBLISH\n";
            print "X-WR-CALNAME:WP_BOOKING_PACKAGE-" . $id . "\n";
            print "X-WR-TIMEZONE:".$timezone."\n";
            print "X-WR-CALDESC:\n";
		    
            $schedule = new booking_package_schedule($this->prefix, $this->pluginName);
            
            $month = date('m', $unixTime);
            $year = date('Y', $unixTime);
            if ($id == 'all') {
                
                $calendarList = $schedule->getCalendarAccountListData("`key`, `name`, `type`, `timezone`");
                foreach ((array) $calendarList as $key => $value) {
                    
                    $calendarTimezone = $timezone;
                    if ($value['timezone'] != 'none') {
                        
                        $calendarTimezone = $value['timezone'];
                        
                    }
                    
                    $month = date('m', $unixTime);
                    $year = date('Y', $unixTime);
                    $_POST['accountKey'] = $value['key'];
                    $response = $schedule->getReservationData($month, date('d', $unixTime), $year, true);
                    $this->createCard($value['key'], $value['name'], $value['type'], $schedule, $response, $calendarTimezone, $host);
                    $month++;
                    if ($month > 12) {
                        
                        $month = 1;
                        $year++;
                        
                    }
                    #$response = $schedule->getReservationData($month, 1, $year, true);
                    #$this->createCard($value['key'], $value['name'], $value['type'], $schedule, $response, $timezone, $host);
                    
                }
                
            } else {
                
                $calendar = $schedule->getCalendarAccount(intval($id));
                $calendarTimezone = $timezone;
                if ($calendar['timezone'] != 'none') {
                    
                    $calendarTimezone = $calendar['timezone'];
                    
                }
                $_POST['accountKey'] = $calendar['key'];
                $response = $schedule->getReservationData($month, date('d', $unixTime), $year, true);
                $this->createCard($calendar['key'], $calendar['name'], $calendar['type'], $schedule, $response, $calendarTimezone, $host);
                $month++;
                if ($month > 12) {
                    
                    $month = 1;
                    $year++;
                    
                }
                
                #$response = $schedule->getReservationData($month, 1, $year, true);
                #$this->createCard($calendar['key'], $calendar['name'], $calendar['type'], $schedule, $response, $timezone, $host);
                
            }
            
            
            /**
            $response = $schedule->getReservationData(date('m', $unixTime), date('d', $unixTime), date('Y', $unixTime), true);
            #date_default_timezone_set('UTC');
            date_default_timezone_set($timezone);
            for($i = 0; $i < count($response); $i++){
                
                $bookingDetail = $response[$i];
                $summaryList = array();
                //DESCRIPTION
                
                $descriptionList = array();
                for($a = 0; $a < count($bookingDetail['praivateData']); $a++){
                    
                    $praivateData = $bookingDetail['praivateData'][$a];
                    if(isset($praivateData['isName']) && $praivateData['isName'] == 'true'){
                        
                        array_push($summaryList, $praivateData['value']);
                        
                    }
                    
                    if($praivateData['active'] == 'true'){
                        
                        array_push($descriptionList, $praivateData['name']."\t".$praivateData['value']);
                        
                    }
                    
                }
                
                $summary = "No title";
                if(count($summaryList) != 0){
                    
                    $summary = implode(" ", $summaryList);
                    
                }
                
                $description = implode("\\n", $descriptionList);
                $selectedOptionsObject = $schedule->getSelectedOptions($bookingDetail['options']);
                $courseTime = intval($bookingDetail['courseTime']);
                $courseTime += $selectedOptionsObject['time'];
                
                
                $unixTime = $bookingDetail['date']['unixTime'];
                print "BEGIN:VEVENT\n";
                print "UID:".$bookingDetail['key']."@".$host."\n";
                print "DTSTART;TZID=".$timezone.":".date("Ymd\THi00", $unixTime)."\n";
                if($courseTime != 0){
                    
                    print "DTEND;TZID=".$timezone.":".date("Ymd\THi00", ($unixTime + ($bookingDetail['courseTime'] * 60)))."\n";
                    
                }else{
                    
                    print "DTEND;TZID=".$timezone.":".date("Ymd\THi00", $unixTime)."\n";
                    
                }
                print "DTSTAMP:".date("Ymd\THi00\Z")."\n";
                print "CREATED;TZID=".$timezone.":".date("Ymd\THi00", $bookingDetail['reserveTime'])."\n";
                print "DESCRIPTION:\n";
                print "STATUS:CONFIRMED\n";
                print "SEQUENCE:".($i + 1)."\n";
                print "SUMMARY:".$summary."\n";
                print "LOCATION:\n";
                print "DESCRIPTION:".$description."\n";
                print "END:VEVENT\n";
                #var_dump($bookingDetail['praivateData']);
                
            }
            **/
            
            print "END:VCALENDAR\n";
            
        }
        
        public function createCard($calendarKey, $calendarName, $calendarType, $schedule, $response, $timezone, $host){
            
            #date_default_timezone_set('UTC');
            date_default_timezone_set($timezone);
            for($i = 0; $i < count($response); $i++){
                
                $bookingDetail = $response[$i];
                if (isset($bookingDetail['status']) && $bookingDetail['status'] == 'canceled') {
                    
                    continue;
                    
                }
                $summaryList = array();
                //DESCRIPTION
                
                $descriptionList = array();
                for($a = 0; $a < count($bookingDetail['praivateData']); $a++){
                    
                    $praivateData = $bookingDetail['praivateData'][$a];
                    if(isset($praivateData['isName']) && $praivateData['isName'] == 'true'){
                        
                        array_push($summaryList, $praivateData['value']);
                        
                    }
                    
                    if(isset($praivateData['active']) && $praivateData['active'] == 'true'){
                        
                        if (is_string($praivateData['value'])) {
                            
                            array_push($descriptionList, $praivateData['name'] . "\t" . $praivateData['value']);
                            
                        } else if (is_array($praivateData['value'])) {
                            
                            array_push($descriptionList, $praivateData['name'] . "\t" . implode(' ', $praivateData['value']));
                            
                        }
                        
                        
                    }
                    
                }
                
                $summary = "No title";
                if(count($summaryList) != 0){
                    
                    $summary = implode(" ", $summaryList);
                    
                }
                
                $description = implode("\\n", $descriptionList);
                $selectedOptionsObject = $schedule->getSelectedServices($bookingDetail['options'], "options");
                $courseTime = intval($bookingDetail['courseTime']);
                $courseTime += $selectedOptionsObject['time'];
                
                $unixTime = $bookingDetail['date']['unixTime'];
                print "BEGIN:VEVENT\n";
                print "UID:".$bookingDetail['key']."@".$host."\n";
                
                if ($calendarType == 'day') {
                    
                    print "DTSTART;TZID=".$timezone.":".date("Ymd\THi00", $unixTime)."\n";
                    if($courseTime != 0){
                        
                        print "DTEND;TZID=".$timezone.":".date("Ymd\THi00", ($unixTime + ($courseTime * 60)))."\n";
                        
                    }else{
                        
                        print "DTEND;TZID=".$timezone.":".date("Ymd\THi00", $unixTime)."\n";
                        
                    }
                    
                } else {
                    
                    $accommodationDetails = json_decode($bookingDetail['accommodationDetails'], true);
                    print "DTSTART;TZID=".$timezone.":".date("Ymd\T12i00", $accommodationDetails['checkIn'])."\n";
                    print "DTEND;TZID=".$timezone.":".date("Ymd\T12i00", $accommodationDetails['checkOut'])."\n";
                    
                }
                
                
                
                print "DTSTAMP:".date("Ymd\THi00\Z")."\n";
                print "CREATED;TZID=".$timezone.":".date("Ymd\THi00", $bookingDetail['reserveTime'])."\n";
                print "STATUS:CONFIRMED\n";
                #print "SEQUENCE:".($i + 1)."\n";
                print "SEQUENCE:0\n";
                print "SUMMARY:".$summary."\n";
                print "LOCATION:".$calendarName."\n";
                print "DESCRIPTION:".$description."\n";
                print "END:VEVENT\n";
                #var_dump($bookingDetail['praivateData']);
                
            }
            
            
        }
        
        
    }



?>