<?php defined('SYSPATH') OR die('No direct access allowed.');

require_once 'PHPUnit/Extensions/Database/TestCase.php';

/**
 * ORM MPTT Tests
 *
 * @package    ORM_MPTT
 * @author     Kiall Mac Innes
 * @copyright  (c) 2010 Kiall Mac Innes
 * @license    http://kohanaframework.org/license
 */
class ORMMPTTTest extends PHPUnit_Extensions_Database_TestCase {

	protected function getConnection()
    {
		$pdo_config = Kohana::config('unittest.pdo');

		Database::$default = 'unittest';

        $pdo = new PDO($pdo_config['dsn'], $pdo_config['username'], $pdo_config['password']);

		$sth = $pdo->prepare(file_get_contents(Kohana::find_file('tests', 'orm_mptt/test_data/dataset', 'sql')));
		$sth->execute();

        return $this->createDefaultDBConnection($pdo, $pdo_config['database']);
    }

    protected function getDataSet()
    {
		$file = Kohana::find_file('tests', 'orm_mptt/test_data/dataset', 'xml');
		
        return $this->createXMLDataSet($file);
    }

	/**
	 * Test selecting child nodes.
	 * @test
	 */
	public function select_child_nodes()
	{
		$root_node = ORM::factory('test_orm_mptt', 1);
		
		$this->assertTrue($root_node->loaded());

		$children = $root_node->children()->find_all();

		// Ensure we have 2 children
		$this->assertEquals(2, count($children));

		// Ensure the first child has ID = 2
		$this->assertEquals(2, $children[0]->id);

		// Ensure the second child has ID = 3
		$this->assertEquals(3, $children[1]->id);
	}

	/**
	 * Test selecting child nodes.
	 * @test
	 * @dataProvider select_siblings_provider
	 */
	public function select_siblings($node_id, $expected_sibling_count, $sibling_ids)
	{
		$node = ORM::factory('test_orm_mptt', $node_id);

		// Ensure node has been loaded sucessfully
		$this->assertTrue($node->loaded());


		$siblings = $node->siblings()->find_all();

		// Ensure we have 0 siblings
		$this->assertEquals($expected_sibling_count, count($siblings));

		
		// Ensure siblings are all present, and in the correct order.
		if ($expected_sibling_count > 0)
		{
			$x = 0;

			foreach ($sibling_ids as $sibling_id)
			{
				$this->assertEquals($sibling_id, $siblings[$x]->id);
				$x++;
			}
		}
	}

	public function select_siblings_provider()
    {
		// array ('ID', '# Of Expected Siblings', array('Sibling IDs'))
        return array(
          array(1, 0, array()),
        );
    }
}
