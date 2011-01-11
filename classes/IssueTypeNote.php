<?php
/**
 * @copyright 2011 City of Bloomington, Indiana
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.txt
 * @author Cliff Ingham <inghamn@bloomington.in.gov>
 */
class IssueTypeNote
{
	private $id;
	private $issueType_id;
	private $note;

	private $issueType;

	/**
	 * Populates the object with data
	 *
	 * Passing in an associative array of data will populate this object without
	 * hitting the database.
	 *
	 * Passing in a scalar will load the data from the database.
	 * This will load all fields in the table as properties of this class.
	 * You may want to replace this with, or add your own extra, custom loading
	 *
	 * @param int|array $id
	 */
	public function __construct($id=null)
	{
		if ($id) {
			if (is_array($id)) {
				$result = $id;
			}
			else {
				$zend_db = Database::getConnection();
				$sql = 'select * from issueType_notes where id=?';
				$result = $zend_db->fetchRow($sql,array($id));
			}

			if ($result) {
				foreach ($result as $field=>$value) {
					if ($value) {
						$this->$field = $value;
					}
				}
			}
			else {
				throw new Exception('issueType_notes/unknownIssueTypeNote');
			}
		}
		else {
			// This is where the code goes to generate a new, empty instance.
			// Set any default values for properties that need it here
		}
	}

	/**
	 * Throws an exception if anything's wrong
	 * @throws Exception $e
	 */
	public function validate()
	{
		// Check for required fields here.  Throw an exception if anything is missing.
		if (!$this->issueType_id) {
			throw new Exception('issueTypeNotes/missingIssueType');
		}

		if (!$this->note) {
			throw new Exception('missingRequiredFields');
		}
	}

	/**
	 * Saves this record back to the database
	 */
	public function save()
	{
		$this->validate();

		$data = array();
		$data['issueType_id'] = $this->issueType_id;
		$data['note'] = $this->note;

		if ($this->id) {
			$this->update($data);
		}
		else {
			$this->insert($data);
		}
	}

	private function update($data)
	{
		$zend_db = Database::getConnection();
		$zend_db->update('issueType_notes',$data,"id='{$this->id}'");
	}

	private function insert($data)
	{
		$zend_db = Database::getConnection();
		$zend_db->insert('issueType_notes',$data);
		$this->id = $zend_db->lastInsertId('issueType_notes','id');
	}

	public function delete()
	{
		$zend_db = Database::getConnection();
		$zend_db->delete('issueType_notes','id='.$this->id);
	}

	//----------------------------------------------------------------
	// Generic Getters
	//----------------------------------------------------------------

	/**
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @return int
	 */
	public function getIssueType_id()
	{
		return $this->issueType_id;
	}

	/**
	 * @return string
	 */
	public function getNote()
	{
		return $this->note;
	}

	/**
	 * @return IssueType
	 */
	public function getIssueType()
	{
		if ($this->issueType_id) {
			if (!$this->issueType) {
				$this->issueType = new IssueType($this->issueType_id);
			}
			return $this->issueType;
		}
		return null;
	}

	//----------------------------------------------------------------
	// Generic Setters
	//----------------------------------------------------------------

	/**
	 * @param int $int
	 */
	public function setIssueType_id($int)
	{
		$this->issueType = new IssueType($int);
		$this->issueType_id = $int;
	}

	/**
	 * @param string $string
	 */
	public function setNote($string)
	{
		$this->note = trim($string);
	}

	/**
	 * @param IssueType $issueType
	 */
	public function setIssueType($issueType)
	{
		$this->issueType_id = $issueType->getId();
		$this->issueType = $issueType;
	}


	//----------------------------------------------------------------
	// Custom Functions
	// We recommend adding all your custom code down here at the bottom
	//----------------------------------------------------------------
	public function __toString()
	{
		return "{$this->note}";
	}
}