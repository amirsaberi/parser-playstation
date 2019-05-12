<?php

namespace AbuseIO\Parsers;

use AbuseIO\Models\Incident;

use Illuminate\Support\Facades\Log;


/**
 * Class Playstation
 * @package AbuseIO\Parsers
 */
class Playstation extends Parser
{
    /**
     * Create a new Playstation instance
     *
     * @param \PhpMimeMailParser\Parser $parsedMail phpMimeParser object
     * @param array $arfMail array with ARF detected results
     */
    public function __construct($parsedMail, $arfMail)
    {
        // Call the parent constructor to initialize some basics
        parent::__construct($parsedMail, $arfMail, $this);
    }

    /**
     * Parse attachments
     * @return array    Returns array with failed or success data
     *                  (See parser-common/src/Parser.php) for more info.
     */
    public function parse()
    {
		
		$report = [ ];

		$subject = $this->parsedMail->getHeader('subject');
		$body = $body = $this->parsedMail->getMessageBody();;

        	// Grab the message part from the body
		preg_match_all('/~ (?<time>(.*)) \(UTC\), (?<ip>(.*)), Account Takeover Attempts/', $body, $matches);

		$this->feedName = "login-attack";

		if (is_array($matches)) {

                    $i = 0;
                    foreach ($matches['ip'] as $match) {
			$match = trim($match);
			$time = ltrim($matches['time'][$i]);
			$time = rtrim($time);
			$time = strtotime($time);

			$incident = new Incident();
			$incident->source      = config("{$this->configBase}.parser.name");
			$incident->source_id   = false;
			$incident->ip          = $match;
			$incident->domain      = false;
			$incident->class       = config("{$this->configBase}.feeds.{$this->feedName}.class");
			$incident->type        = config("{$this->configBase}.feeds.{$this->feedName}.type");
			$incident->timestamp   = $time;
			#$incident->timestamp   = strtotime($report['Date']);
			$incident->information = json_encode($report);

			$this->incidents[] = $incident;

		    }
		}


	return $this->success();

    }
}
