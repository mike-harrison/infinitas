<?php
	class MultiGroupedItemFixture extends CakeTestFixture {
		public $table = 'multi_grouped_items';

		public $fields = array(
			'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
			'name' => array('type' => 'string', 'null' => false, 'default' => NULL),
			'group_field_1' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 10),
			'group_field_2' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 10),
			'ordering' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 10),
			'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
		);

		public $records = array(
			array('id' => 1, 'name' => 'Group1 1 Group2 1 Item A', 'group_field_1' => 1, 'group_field_2' => 1, 'ordering' => 1),
			array('id' => 2, 'name' => 'Group1 1 Group2 1 Item B', 'group_field_1' => 1, 'group_field_2' => 1, 'ordering' => 2),
			array('id' => 3, 'name' => 'Group1 1 Group2 1 Item C', 'group_field_1' => 1, 'group_field_2' => 1, 'ordering' => 3),
			array('id' => 4, 'name' => 'Group1 1 Group2 1 Item D', 'group_field_1' => 1, 'group_field_2' => 1, 'ordering' => 4),
			array('id' => 5, 'name' => 'Group1 1 Group2 1 Item E', 'group_field_1' => 1, 'group_field_2' => 1, 'ordering' => 5),

			array('id' => 6, 'name' => 'Group1 1 Group2 2 Item A', 'group_field_1' => 1, 'group_field_2' => 2, 'ordering' => 1),
			array('id' => 7, 'name' => 'Group1 1 Group2 2 Item B', 'group_field_1' => 1, 'group_field_2' => 2, 'ordering' => 2),
			array('id' => 8, 'name' => 'Group1 1 Group2 2 Item C', 'group_field_1' => 1, 'group_field_2' => 2, 'ordering' => 3),
			array('id' => 9, 'name' => 'Group1 1 Group2 2 Item D', 'group_field_1' => 1, 'group_field_2' => 2, 'ordering' => 4),
			array('id' => 10, 'name' => 'Group1 1 Group2 2 Item E', 'group_field_1' => 1, 'group_field_2' => 2, 'ordering' => 5),

			array('id' => 11, 'name' => 'Group1 1 Group2 3 Item A', 'group_field_1' => 1, 'group_field_2' => 3, 'ordering' => 1),
			array('id' => 12, 'name' => 'Group1 1 Group2 3 Item B', 'group_field_1' => 1, 'group_field_2' => 3, 'ordering' => 2),
			array('id' => 13, 'name' => 'Group1 1 Group2 3 Item C', 'group_field_1' => 1, 'group_field_2' => 3, 'ordering' => 3),
			array('id' => 14, 'name' => 'Group1 1 Group2 3 Item D', 'group_field_1' => 1, 'group_field_2' => 3, 'ordering' => 4),
			array('id' => 15, 'name' => 'Group1 1 Group2 3 Item E', 'group_field_1' => 1, 'group_field_2' => 3, 'ordering' => 5),

			array('id' => 16, 'name' => 'Group1 1 Group2 4 Item A', 'group_field_1' => 1, 'group_field_2' => 4, 'ordering' => 1),
			array('id' => 17, 'name' => 'Group1 1 Group2 4 Item B', 'group_field_1' => 1, 'group_field_2' => 4, 'ordering' => 2),
			array('id' => 18, 'name' => 'Group1 1 Group2 4 Item C', 'group_field_1' => 1, 'group_field_2' => 4, 'ordering' => 3),
			array('id' => 19, 'name' => 'Group1 1 Group2 4 Item D', 'group_field_1' => 1, 'group_field_2' => 4, 'ordering' => 4),
			array('id' => 20, 'name' => 'Group1 1 Group2 4 Item E', 'group_field_1' => 1, 'group_field_2' => 4, 'ordering' => 5),

			array('id' => 21, 'name' => 'Group1 1 Group2 5 Item A', 'group_field_1' => 1, 'group_field_2' => 5, 'ordering' => 1),
			array('id' => 22, 'name' => 'Group1 1 Group2 5 Item B', 'group_field_1' => 1, 'group_field_2' => 5, 'ordering' => 2),
			array('id' => 23, 'name' => 'Group1 1 Group2 5 Item C', 'group_field_1' => 1, 'group_field_2' => 5, 'ordering' => 3),
			array('id' => 24, 'name' => 'Group1 1 Group2 5 Item D', 'group_field_1' => 1, 'group_field_2' => 5, 'ordering' => 4),
			array('id' => 25, 'name' => 'Group1 1 Group2 5 Item E', 'group_field_1' => 1, 'group_field_2' => 5, 'ordering' => 5),

			array('id' => 26, 'name' => 'Group1 2 Group2 1 Item A', 'group_field_1' => 2, 'group_field_2' => 1, 'ordering' => 1),
			array('id' => 27, 'name' => 'Group1 2 Group2 1 Item B', 'group_field_1' => 2, 'group_field_2' => 1, 'ordering' => 2),
			array('id' => 28, 'name' => 'Group1 2 Group2 1 Item C', 'group_field_1' => 2, 'group_field_2' => 1, 'ordering' => 3),
			array('id' => 29, 'name' => 'Group1 2 Group2 1 Item D', 'group_field_1' => 2, 'group_field_2' => 1, 'ordering' => 4),
			array('id' => 30, 'name' => 'Group1 2 Group2 1 Item E', 'group_field_1' => 2, 'group_field_2' => 1, 'ordering' => 5),

			array('id' => 31, 'name' => 'Group1 2 Group2 2 Item A', 'group_field_1' => 2, 'group_field_2' => 2, 'ordering' => 1),
			array('id' => 32, 'name' => 'Group1 2 Group2 2 Item B', 'group_field_1' => 2, 'group_field_2' => 2, 'ordering' => 2),
			array('id' => 33, 'name' => 'Group1 2 Group2 2 Item C', 'group_field_1' => 2, 'group_field_2' => 2, 'ordering' => 3),
			array('id' => 34, 'name' => 'Group1 2 Group2 2 Item D', 'group_field_1' => 2, 'group_field_2' => 2, 'ordering' => 4),
			array('id' => 35, 'name' => 'Group1 2 Group2 2 Item E', 'group_field_1' => 2, 'group_field_2' => 2, 'ordering' => 5),

			array('id' => 36, 'name' => 'Group1 2 Group2 3 Item A', 'group_field_1' => 2, 'group_field_2' => 3, 'ordering' => 1),
			array('id' => 37, 'name' => 'Group1 2 Group2 3 Item B', 'group_field_1' => 2, 'group_field_2' => 3, 'ordering' => 2),
			array('id' => 38, 'name' => 'Group1 2 Group2 3 Item C', 'group_field_1' => 2, 'group_field_2' => 3, 'ordering' => 3),
			array('id' => 39, 'name' => 'Group1 2 Group2 3 Item D', 'group_field_1' => 2, 'group_field_2' => 3, 'ordering' => 4),
			array('id' => 40, 'name' => 'Group1 2 Group2 3 Item E', 'group_field_1' => 2, 'group_field_2' => 3, 'ordering' => 5),

			array('id' => 41, 'name' => 'Group1 2 Group2 4 Item A', 'group_field_1' => 2, 'group_field_2' => 4, 'ordering' => 1),
			array('id' => 42, 'name' => 'Group1 2 Group2 4 Item B', 'group_field_1' => 2, 'group_field_2' => 4, 'ordering' => 2),
			array('id' => 43, 'name' => 'Group1 2 Group2 4 Item C', 'group_field_1' => 2, 'group_field_2' => 4, 'ordering' => 3),
			array('id' => 44, 'name' => 'Group1 2 Group2 4 Item D', 'group_field_1' => 2, 'group_field_2' => 4, 'ordering' => 4),
			array('id' => 45, 'name' => 'Group1 2 Group2 4 Item E', 'group_field_1' => 2, 'group_field_2' => 4, 'ordering' => 5),

			array('id' => 46, 'name' => 'Group1 2 Group2 5 Item A', 'group_field_1' => 2, 'group_field_2' => 5, 'ordering' => 1),
			array('id' => 47, 'name' => 'Group1 2 Group2 5 Item B', 'group_field_1' => 2, 'group_field_2' => 5, 'ordering' => 2),
			array('id' => 48, 'name' => 'Group1 2 Group2 5 Item C', 'group_field_1' => 2, 'group_field_2' => 5, 'ordering' => 3),
			array('id' => 49, 'name' => 'Group1 2 Group2 5 Item D', 'group_field_1' => 2, 'group_field_2' => 5, 'ordering' => 4),
			array('id' => 50, 'name' => 'Group1 2 Group2 5 Item E', 'group_field_1' => 2, 'group_field_2' => 5, 'ordering' => 5),

			array('id' => 51, 'name' => 'Group1 3 Group2 1 Item A', 'group_field_1' => 3, 'group_field_2' => 1, 'ordering' => 1),
			array('id' => 52, 'name' => 'Group1 3 Group2 1 Item B', 'group_field_1' => 3, 'group_field_2' => 1, 'ordering' => 2),
			array('id' => 53, 'name' => 'Group1 3 Group2 1 Item C', 'group_field_1' => 3, 'group_field_2' => 1, 'ordering' => 3),
			array('id' => 54, 'name' => 'Group1 3 Group2 1 Item D', 'group_field_1' => 3, 'group_field_2' => 1, 'ordering' => 4),
			array('id' => 55, 'name' => 'Group1 3 Group2 1 Item E', 'group_field_1' => 3, 'group_field_2' => 1, 'ordering' => 5),

			array('id' => 56, 'name' => 'Group1 3 Group2 2 Item A', 'group_field_1' => 3, 'group_field_2' => 2, 'ordering' => 1),
			array('id' => 57, 'name' => 'Group1 3 Group2 2 Item B', 'group_field_1' => 3, 'group_field_2' => 2, 'ordering' => 2),
			array('id' => 58, 'name' => 'Group1 3 Group2 2 Item C', 'group_field_1' => 3, 'group_field_2' => 2, 'ordering' => 3),
			array('id' => 59, 'name' => 'Group1 3 Group2 2 Item D', 'group_field_1' => 3, 'group_field_2' => 2, 'ordering' => 4),
			array('id' => 60, 'name' => 'Group1 3 Group2 2 Item E', 'group_field_1' => 3, 'group_field_2' => 2, 'ordering' => 5),

			array('id' => 61, 'name' => 'Group1 3 Group2 3 Item A', 'group_field_1' => 3, 'group_field_2' => 3, 'ordering' => 1),
			array('id' => 62, 'name' => 'Group1 3 Group2 3 Item B', 'group_field_1' => 3, 'group_field_2' => 3, 'ordering' => 2),
			array('id' => 63, 'name' => 'Group1 3 Group2 3 Item C', 'group_field_1' => 3, 'group_field_2' => 3, 'ordering' => 3),
			array('id' => 64, 'name' => 'Group1 3 Group2 3 Item D', 'group_field_1' => 3, 'group_field_2' => 3, 'ordering' => 4),
			array('id' => 65, 'name' => 'Group1 3 Group2 3 Item E', 'group_field_1' => 3, 'group_field_2' => 3, 'ordering' => 5),

			array('id' => 66, 'name' => 'Group1 3 Group2 4 Item A', 'group_field_1' => 3, 'group_field_2' => 4, 'ordering' => 1),
			array('id' => 67, 'name' => 'Group1 3 Group2 4 Item B', 'group_field_1' => 3, 'group_field_2' => 4, 'ordering' => 2),
			array('id' => 68, 'name' => 'Group1 3 Group2 4 Item C', 'group_field_1' => 3, 'group_field_2' => 4, 'ordering' => 3),
			array('id' => 69, 'name' => 'Group1 3 Group2 4 Item D', 'group_field_1' => 3, 'group_field_2' => 4, 'ordering' => 4),
			array('id' => 70, 'name' => 'Group1 3 Group2 4 Item E', 'group_field_1' => 3, 'group_field_2' => 4, 'ordering' => 5),

			array('id' => 71, 'name' => 'Group1 3 Group2 5 Item A', 'group_field_1' => 3, 'group_field_2' => 5, 'ordering' => 1),
			array('id' => 72, 'name' => 'Group1 3 Group2 5 Item B', 'group_field_1' => 3, 'group_field_2' => 5, 'ordering' => 2),
			array('id' => 73, 'name' => 'Group1 3 Group2 5 Item C', 'group_field_1' => 3, 'group_field_2' => 5, 'ordering' => 3),
			array('id' => 74, 'name' => 'Group1 3 Group2 5 Item D', 'group_field_1' => 3, 'group_field_2' => 5, 'ordering' => 4),
			array('id' => 75, 'name' => 'Group1 3 Group2 5 Item E', 'group_field_1' => 3, 'group_field_2' => 5, 'ordering' => 5),

			array('id' => 76, 'name' => 'Group1 4 Group2 1 Item A', 'group_field_1' => 4, 'group_field_2' => 1, 'ordering' => 1),
			array('id' => 77, 'name' => 'Group1 4 Group2 1 Item B', 'group_field_1' => 4, 'group_field_2' => 1, 'ordering' => 2),
			array('id' => 78, 'name' => 'Group1 4 Group2 1 Item C', 'group_field_1' => 4, 'group_field_2' => 1, 'ordering' => 3),
			array('id' => 79, 'name' => 'Group1 4 Group2 1 Item D', 'group_field_1' => 4, 'group_field_2' => 1, 'ordering' => 4),
			array('id' => 80, 'name' => 'Group1 4 Group2 1 Item E', 'group_field_1' => 4, 'group_field_2' => 1, 'ordering' => 5),

			array('id' => 81, 'name' => 'Group1 4 Group2 2 Item A', 'group_field_1' => 4, 'group_field_2' => 2, 'ordering' => 1),
			array('id' => 82, 'name' => 'Group1 4 Group2 2 Item B', 'group_field_1' => 4, 'group_field_2' => 2, 'ordering' => 2),
			array('id' => 83, 'name' => 'Group1 4 Group2 2 Item C', 'group_field_1' => 4, 'group_field_2' => 2, 'ordering' => 3),
			array('id' => 84, 'name' => 'Group1 4 Group2 2 Item D', 'group_field_1' => 4, 'group_field_2' => 2, 'ordering' => 4),
			array('id' => 85, 'name' => 'Group1 4 Group2 2 Item E', 'group_field_1' => 4, 'group_field_2' => 2, 'ordering' => 5),

			array('id' => 86, 'name' => 'Group1 4 Group2 3 Item A', 'group_field_1' => 4, 'group_field_2' => 3, 'ordering' => 1),
			array('id' => 87, 'name' => 'Group1 4 Group2 3 Item B', 'group_field_1' => 4, 'group_field_2' => 3, 'ordering' => 2),
			array('id' => 88, 'name' => 'Group1 4 Group2 3 Item C', 'group_field_1' => 4, 'group_field_2' => 3, 'ordering' => 3),
			array('id' => 89, 'name' => 'Group1 4 Group2 3 Item D', 'group_field_1' => 4, 'group_field_2' => 3, 'ordering' => 4),
			array('id' => 90, 'name' => 'Group1 4 Group2 3 Item E', 'group_field_1' => 4, 'group_field_2' => 3, 'ordering' => 5),

			array('id' => 91, 'name' => 'Group1 4 Group2 4 Item A', 'group_field_1' => 4, 'group_field_2' => 4, 'ordering' => 1),
			array('id' => 92, 'name' => 'Group1 4 Group2 4 Item B', 'group_field_1' => 4, 'group_field_2' => 4, 'ordering' => 2),
			array('id' => 93, 'name' => 'Group1 4 Group2 4 Item C', 'group_field_1' => 4, 'group_field_2' => 4, 'ordering' => 3),
			array('id' => 94, 'name' => 'Group1 4 Group2 4 Item D', 'group_field_1' => 4, 'group_field_2' => 4, 'ordering' => 4),
			array('id' => 95, 'name' => 'Group1 4 Group2 4 Item E', 'group_field_1' => 4, 'group_field_2' => 4, 'ordering' => 5),

			array('id' => 96, 'name' => 'Group1 4 Group2 5 Item A', 'group_field_1' => 4, 'group_field_2' => 5, 'ordering' => 1),
			array('id' => 97, 'name' => 'Group1 4 Group2 5 Item B', 'group_field_1' => 4, 'group_field_2' => 5, 'ordering' => 2),
			array('id' => 98, 'name' => 'Group1 4 Group2 5 Item C', 'group_field_1' => 4, 'group_field_2' => 5, 'ordering' => 3),
			array('id' => 99, 'name' => 'Group1 4 Group2 5 Item D', 'group_field_1' => 4, 'group_field_2' => 5, 'ordering' => 4),
			array('id' => 100, 'name' => 'Group1 4 Group2 5 Item E', 'group_field_1' => 4, 'group_field_2' => 5, 'ordering' => 5),

			array('id' => 101, 'name' => 'Group1 5 Group2 1 Item A', 'group_field_1' => 5, 'group_field_2' => 1, 'ordering' => 1),
			array('id' => 102, 'name' => 'Group1 5 Group2 1 Item B', 'group_field_1' => 5, 'group_field_2' => 1, 'ordering' => 2),
			array('id' => 103, 'name' => 'Group1 5 Group2 1 Item C', 'group_field_1' => 5, 'group_field_2' => 1, 'ordering' => 3),
			array('id' => 104, 'name' => 'Group1 5 Group2 1 Item D', 'group_field_1' => 5, 'group_field_2' => 1, 'ordering' => 4),
			array('id' => 105, 'name' => 'Group1 5 Group2 1 Item E', 'group_field_1' => 5, 'group_field_2' => 1, 'ordering' => 5),

			array('id' => 106, 'name' => 'Group1 5 Group2 2 Item A', 'group_field_1' => 5, 'group_field_2' => 2, 'ordering' => 1),
			array('id' => 107, 'name' => 'Group1 5 Group2 2 Item B', 'group_field_1' => 5, 'group_field_2' => 2, 'ordering' => 2),
			array('id' => 108, 'name' => 'Group1 5 Group2 2 Item C', 'group_field_1' => 5, 'group_field_2' => 2, 'ordering' => 3),
			array('id' => 109, 'name' => 'Group1 5 Group2 2 Item D', 'group_field_1' => 5, 'group_field_2' => 2, 'ordering' => 4),
			array('id' => 110, 'name' => 'Group1 5 Group2 2 Item E', 'group_field_1' => 5, 'group_field_2' => 2, 'ordering' => 5),

			array('id' => 111, 'name' => 'Group1 5 Group2 3 Item A', 'group_field_1' => 5, 'group_field_2' => 3, 'ordering' => 1),
			array('id' => 112, 'name' => 'Group1 5 Group2 3 Item B', 'group_field_1' => 5, 'group_field_2' => 3, 'ordering' => 2),
			array('id' => 113, 'name' => 'Group1 5 Group2 3 Item C', 'group_field_1' => 5, 'group_field_2' => 3, 'ordering' => 3),
			array('id' => 114, 'name' => 'Group1 5 Group2 3 Item D', 'group_field_1' => 5, 'group_field_2' => 3, 'ordering' => 4),
			array('id' => 115, 'name' => 'Group1 5 Group2 3 Item E', 'group_field_1' => 5, 'group_field_2' => 3, 'ordering' => 5),

			array('id' => 116, 'name' => 'Group1 5 Group2 4 Item A', 'group_field_1' => 5, 'group_field_2' => 4, 'ordering' => 1),
			array('id' => 117, 'name' => 'Group1 5 Group2 4 Item B', 'group_field_1' => 5, 'group_field_2' => 4, 'ordering' => 2),
			array('id' => 118, 'name' => 'Group1 5 Group2 4 Item C', 'group_field_1' => 5, 'group_field_2' => 4, 'ordering' => 3),
			array('id' => 119, 'name' => 'Group1 5 Group2 4 Item D', 'group_field_1' => 5, 'group_field_2' => 4, 'ordering' => 4),
			array('id' => 120, 'name' => 'Group1 5 Group2 4 Item E', 'group_field_1' => 5, 'group_field_2' => 4, 'ordering' => 5),

			array('id' => 121, 'name' => 'Group1 5 Group2 5 Item A', 'group_field_1' => 5, 'group_field_2' => 5, 'ordering' => 1),
			array('id' => 122, 'name' => 'Group1 5 Group2 5 Item B', 'group_field_1' => 5, 'group_field_2' => 5, 'ordering' => 2),
			array('id' => 123, 'name' => 'Group1 5 Group2 5 Item C', 'group_field_1' => 5, 'group_field_2' => 5, 'ordering' => 3),
			array('id' => 124, 'name' => 'Group1 5 Group2 5 Item D', 'group_field_1' => 5, 'group_field_2' => 5, 'ordering' => 4),
			array('id' => 125, 'name' => 'Group1 5 Group2 5 Item E', 'group_field_1' => 5, 'group_field_2' => 5, 'ordering' => 5),
		);
	}