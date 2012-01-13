<?php
class Honey_View_Helper_CmsLinkSort extends Zend_View_Helper_Abstract {
	
	public function cmsLinkSort($label, $column, $filter, $action_link, $default_order = 'DESC') {
		
		if ($filter ['col'] != $column) {
			$linkOder = $action_link . '/col/' . $column . '/by/' . $default_order;
			$xhtml = '<a href="' . $linkOder . '" title="Sort Z-A">' . $label . '</a>';
		} else {
			if ($filter ['order'] == 'DESC') {
				$sortOrder = 'ASC';
				$title = "Sort A-Z";
				$linkOder = $action_link . '/col/' . $column . '/by/' . $sortOrder;
				$xhtml = '<a href="' . $linkOder . '" title="' . $title . '" class="asc">' . $label . '</a>';
			} else {
				$sortOrder = 'DESC';
				$title = "Sort Z-A";
				$linkOder = $action_link . '/col/' . $column . '/by/' . $sortOrder;
				$xhtml = '<a href="' . $linkOder . '" title="' . $title . '" class="desc">' . $label . '</a>';
			}
		}
		return $xhtml;
	}
}