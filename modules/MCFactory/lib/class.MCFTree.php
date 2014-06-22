<?php
	// This class allows to manipulate a tree of items

	class MCFTree
	{
		protected $items; // List of items
		protected $tree_key; // The key to sort the tree => Should be numerical value
		protected $root = array();
		protected $tree;
		protected $branches = array();
		protected $flaten_tree; // A flaten representation of the tree
		protected $lost_leafs; // If we find orfans, we store them here TODO
		
		protected $restrict; // Restrict to certain leaves // should be an array()
		// protected $
		
		public function __construct($items, $tree_key = 'parent_id')	{
			$this->items = $items;
			$this->tree_key = $tree_key;
		}
		
		private function buildTree()	{	
			$tree_key = $this->tree_key;
			
			foreach($this->items as $item)
			{
				if(is_object($item))	$this->branches[(int)$item->$tree_key][] = $item; 
			}
			
			$this->root = $this->branches[0]; // We begin by the basis			
			$this->tree = $this->buildBranche(0);
		}
		
		private function buildBranche($id, $level = 1)	{
			$tree_key = $this->tree_key;
			$branche = array();
			if(isset($this->branches[$id]))
			{
				foreach($this->branches[$id] as &$item)
				{
					$item->setLevel($level);
					// TODO: Don't assume getId		
					// $branche[$item->getId()] = array();

					// $branche[$item->getId()]['level'] = $level;
					if(isset($this->branches[$item->getId()]))
					{
						$item->pushChildrens($this->branches[$item->getId()]);
						$branche[$item->getId()]['childrens'] = $this->buildBranche($item->getId(), $level+1);
					}
					
					$branche[$item->getId()]['item'] = &$item;
				}
			}
			return $branche;
		}
	
		public function getTree()	{
			if(!is_array($this->tree))
			{
				$this->buildTree();
			}
			return $this->tree;
		}
		
		private static function debugTree($tree)	{
			foreach($tree as $branche)
			{
				if(isset($branche['item']))
				{
					echo '<p><strong>'.(string)$branche['item'].'</strong></p>';
				}
				
				if(isset($branche['childrens']))
				{
					self::debugTree($branche['childrens']);
				}
			}
		}
		
		private static function debugFlatenTree($flaten_tree)	{
			foreach($flaten_tree as $id => $item)
			{
				echo '<p><strong>id:</strong> '.$id.' <strong>title:</strong> '.(string)$item.'</p>';
			}
		}
	
		private function buildFlatenTree()	{
			$tree = $this->getTree();
			// self::debugTree($tree);
			$this->flaten_tree = $this->buildFlatenBranche($tree);
			// self::debugFlatenTree($this->flaten_tree);
			// echo '<pre>';
			// var_dump($tree);
		}
		
		private function buildFlatenBranche($childrens)	{
			$branche = array();
			foreach($childrens as $id => $children)
			{
				$branche[$id] = $children['item'];
				if(isset($children['childrens']))
				{
					$branche += $this->buildFlatenBranche($children['childrens']);
				}
			}
			return $branche;
		}
		
		public function getFlatenTree()	{
			if(!is_array($this->flaten_tree))
			{
				$this->buildFlatenTree();
			}
			return $this->flaten_tree;
		}
	}