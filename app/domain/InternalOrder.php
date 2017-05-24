<?php
namespace lab\domain;

class InternalOrder extends DomainObject
{
    private $contactPersonId;
    private $nr;
    private $year;
    private $akr;
    private $orderDate;
    private $receiveDate;
    private $nrOfAnalyzes;
    private $sum;
    private $foundSource;
    private $loadNr;
    private $methods = null;
    private $contactPerson = null;

    public function __construct(
        $id = null,
        $contact_person_id = null,
        $nr = null,
        $year = null,
        $akr = null,
        $order_date = null,
        $receive_date = null,
        $nr_of_analyzes = null,
        $sum = null,
        $found_source = null,
        $load_nr = null
    )
    {
        parent::__construct($id);
        $this->contactPersonId = $contact_person_id;
        $this->nr = $nr;
        $this->year = $year;
        $this->akr = $akr;
        $this->orderDate = $order_date;
        $this->receiveDate = $receive_date;
        $this->nrOfAnalyzes = $nr_of_analyzes;
        $this->sum = $sum;
        $this->foundSource = $found_source;
        $this->loadNr = $load_nr;
    }

    public function getContactPerson()
    {
        if (is_null($this->contactPerson)) {
            $finder = self::getFinder(ContactPerson::class);
            $this->contactPerson = $finder->find($this->contactPersonId);
        }
        return $this->contactPerson;
    }

    public function getMethods()
    {
        if (is_null($this->methods)) {
            $finder = self::getFinder(Method::class);
            $this->methods = $finder->findByInternalOrder($this->getId());
        }
        return $this->methods;
    }

    private function getAkrCode()
    {
        if ($this->getAkr()) {
            return '/AKR';
        }
    }

    public function getCode()
    {
        return 'Z-LA-'.$this->getNr().'/'.$this->getYear().$this->getAkrCode();
    }

    public function setContactPerson(ContactPerson $person)
    {
        $this->contactPerson = $person;
    }

    public function setMethods(\lab\domain\MethodCollection $methods)
    {
        $this->methods = $methods;
    }

    public function addMethod(\lab\domain\Method $method)
    {
        $this->getMethods()->add($method);
        //$method->addInternalOrder($this);
    }

    public function setNr($nr)
    {
        $this->nr = $nr;
//        $this->markDirty();
    }

    public function setYear($year)
    {
        $this->year = $year;
//        $this->markDirty();
    }

    public function setAkr($akr)
    {
        $this->akr = $akr;
    }

    public function setOrderDate($date)
    {
        $this->orderDate = $date;
    }

    public function setReceiveDate($date)
    {
        $this->receiveDate = $date;
    }

    public function setNrOfAnalyzes($nr)
    {
        $this->nrOfAnalyzes = $nr;
    }

    public function setSum($sum)
    {
        $this->sum = $sum;
    }

    public function setFoundSource($source)
    {
        $this->foundSource = $source;
    }

    public function setLoadNr($nr)
    {
        $this->loadNr = $nr;
    }

    public function getNr()
    {
        return $this->nr;
    }

    public function getYear()
    {
        return $this->year;
    }

    public function getAkr()
    {
        return $this->akr;
    }

    public function getOrderDate()
    {
        return $this->orderDate;
    }

    public function getReceiveDate()
    {
        return $this->receiveDate;
    }

    public function getNrOfAnalyzes()
    {
        return $this->nrOfAnalyzes;
    }

    public function getSum()
    {
        return $this->sum;
    }

    public function getFoundSource()
    {
        return $this->foundSource;
    }

    public function getLoadNr()
    {
        return $this->loadNr;
    }
}
