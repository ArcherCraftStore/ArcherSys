<?php

namespace afterlogic\DAV\CardDAV\Backend;

use afterlogic\DAV\Constants;

class PDO extends \Sabre\CardDAV\Backend\PDO {
	
	/**
     * Sets up the object
     */
    public function __construct() {

		$oPdo = \CApi::GetPDO();
		$sDbPrefix = \CApi::GetSettings()->GetConf('Common/DBPrefix');

		parent::__construct($oPdo, $sDbPrefix.Constants::T_ADDRESSBOOKS, $sDbPrefix.Constants::T_CARDS);

    }
	
    /**
     * Returns the addressbook for a specific user.
     *
     * @param string $principalUri
     * @param string $addressbookUri
     * @return array
     */
    public function getAddressBookForUser($principalUri, $addressbookUri) {

        $stmt = $this->pdo->prepare('SELECT id, uri, displayname, principaluri, description, ctag FROM '.$this->addressBooksTableName.' WHERE principaluri = ? AND uri = ?');
        $stmt->execute(array($principalUri, $addressbookUri));

        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
		return array(
			'id'  => $row['id'],
			'uri' => $row['uri'],
			'principaluri' => $row['principaluri'],
			'{DAV:}displayname' => $row['displayname'],
			'{' . \Sabre\CardDAV\Plugin::NS_CARDDAV . '}addressbook-description' => $row['description'],
			'{http://calendarserver.org/ns/}getctag' => $row['ctag'],
			'{' . \Sabre\CardDAV\Plugin::NS_CARDDAV . '}supported-address-data' => new \Sabre\CardDAV\Property\SupportedAddressData(),
		);

    }	
	
    /**
     * Returns all cards for a specific addressbook id.
     *
     * @return array
     */
    public function getCardsSharedToAll($addressbookId) {

        $stmt = $this->pdo->prepare('SELECT id, carddata, uri, lastmodified FROM ' . $this->cardsTableName . ' WHERE addressbookid = ?');
        $stmt->execute(array($addressbookId));

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);


    }
	
	/**
     * Returns all cards for a specific addressbook id.
     *
     * @param mixed $addressbookId
     * @return array
     */
    public function getCardsByOffset($addressbookId, $iOffset, $iRequestLimit) {

        $stmt = $this->pdo->prepare(
				'SELECT id, carddata, uri, lastmodified 
					FROM ' . $this->cardsTableName . ' 
						WHERE addressbookid = ? LIMIT ?, ?');
        $stmt->execute(array($addressbookId, $iOffset, $iRequestLimit));

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);

    }	
}

