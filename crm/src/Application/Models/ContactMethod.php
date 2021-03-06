<?php
/**
 * @copyright 2012-2014 City of Bloomington, Indiana
 * @license http://www.gnu.org/licenses/agpl.txt GNU/AGPL, see LICENSE
 * @author Cliff Ingham <inghamn@bloomington.in.gov>
 */
namespace Application\Models;
use Application\ActiveRecord;
use Application\Database;

class ContactMethod extends ActiveRecord
{
	protected $tablename = 'contactMethods';
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
				$this->exchangeArray($id);
			}
			else {
				$db = Database::getConnection();
				$sql = ActiveRecord::isId($id)
					? 'select * from contactMethods where id=?'
					: 'select * from contactMethods where name=?';
				$result = $db->createStatement($sql)->execute([$id]);
				if (count($result)) {
					$this->exchangeArray($result->current());
				}
				else {
					throw new \Exception('contactMethods/unknown');
				}
			}
		}
		else {
			// This is where the code goes to generate a new, empty instance.
			// Set any default values for properties that need it here
		}
	}

	public function validate()
	{
		if (!$this->getName()) { throw new \Exception('missingRequiredFields'); }
	}

	public function save() { parent::save(); }

	//----------------------------------------------------------------
	// Generic Getters & Setters
	//----------------------------------------------------------------
	public function __toString() { return parent::get('name'); }
	public function getId()      { return parent::get('id');   }
	public function getName()    { return parent::get('name'); }

	public function setName($s) { parent::set('name', $s); }

	/**
	 * @param array $post
	 */
	public function handleUpdate($post)
	{
		$this->setName($post['name']);
	}
}
