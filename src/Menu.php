<?php
namespace NexmoDemo;

/**
 * Phone Menu Logic
 */
class Menu
{
    /**
     * The NCCO Stack
     * @var array
     */
    protected $ncco = [];

    /**
     * App Config
     * @var array
     */
    protected $config;

    public function __construct($config)
    {
        $this->config = $config;
    }

    /**
     * When the call is answered, say hello.
     */
    public function answerAction()
    {
        $this->append([
            'action' => 'talk',
            'text' => 'Thanks for calling Nexmo order status hotline for demo
                      the Basic Interactive Voice Response (IVR) use case.'
        ]);

        $this->promptSearch();
    }

    public function searchAction($request)
    {
        if(isset($request['dtmf'])) {
            if($request['dtmf']=='888') {
              $this->append([
                  'action' => 'talk',
                  'text' => 'Your order of two hotdogs will be delivered to the white house.'
              ]);
            }
            else {
                $dates = [new \DateTime('yesterday'), new \DateTime('today'), new \DateTime('last week')];
                $status = ['shipped', 'backordered', 'pending'];

                $this->append([
                    'action' => 'talk',
                    'text' => 'Your order ' . $this->talkCharacters($request['dtmf'])
                              . ', your order ' . $this->talkCharacters($request['dtmf'])
                              . $this->talkStatus($status[array_rand($status)])
                              . ' as  of ' . $this->talkDate($dates[array_rand($dates)])
                ]);
            }
        }

        $this->append([
            'action' => 'talk',
            'text' => 'If you are done, hangup at any time. If you would like to search again'
        ]);

        $this->promptSearch();
    }

    protected function promptSearch()
    {
        $this->append([
            'action' => 'talk',
            'text' => 'enter 8 8 8 to get a demo status message or other numbers for a dummy message,
                      end the input with a pound sign'
        ]);

        $this->append([
            'action' => 'input',
            'eventUrl' => [$this->config['base_path'] . '/search'],
            'timeOut' => '30',
            'submitOnHash' => true
        ]);
    }

    protected function talkStatus($status)
    {
        switch($status){
            case 'shipped':
                return 'has been shipped';
            case 'pending':
                return 'is still pending';
            case 'backordered':
                return 'is backordered';
            default:
                return 'can not be located at this time';
        }
    }

    protected function talkDate(\DateTime $date)
    {
        return $date->format('l F jS');
    }

    protected function talkCharacters($string)
    {
        return implode(' ', str_split($string));
    }

    public function getStack()
    {
        return $this->ncco;
    }

    protected function append($ncco)
    {
        array_push($this->ncco, $ncco);
    }

    protected function prepend($ncco)
    {
        array_unshift($this->ncco, $ncco);
    }
}
