<?php


if (!class_exists(my_custom_class)) {
	
	class my_custom_class extends Walker_Nav_menu{
	
	public $isMegamenu;
	public $conut;
	
	public function __construct(){
		$this->isMegamenu = 0;
		$this->conut = 0;
	}
	
	public function start_lvl(&$output, $depth = 0, $args = array()){
		$indent  = str_repeat("\t", $depth);
		$submenu = ($depth > 0) ? ' sub-menu' : '';
//		$drop_submenu = ($depth = 2 ) ? 'dropdown-submenu' : '';
		$output .= "\n$indent<ul class=\"dropdown-menu animated-2s fadeInUpHalf pages links sub-menu $submenu  depth_$depth\">\n";
		
		if($this->isMegamenu != 0 && $depth == 0 ){
			$output .= "<li class=\"megamenu-column\"><ul>\n";
		}
		
		
		
	}
	
	public function end_lvl(&$output, $depth = 0, $args = array()){
		if($this->isMegamenu != 0 && $depth == 0){
			$output .= "</ul></li>";
		}
		$output .= "</ul>";
		
	}
	
	public function start_el(&$output, $item, $depth=0, $args=array(), $id=0  ){
		$hasMegaMenu = get_post_meta( $item->ID, 'menu-item-mm-megamenu', true );
        $hasColumnDivider = get_post_meta( $item->ID, 'menu-item-mm-column-divider', true );
        $hasDivider = get_post_meta( $item->ID, 'menu-item-mm-divider', true );
        $hasFeaturedImage = get_post_meta( $item->ID, 'menu-item-mm-feature-image', true );
        $hasDescription = get_post_meta( $item->ID, 'menu-item-mm-description', true );
		
		
		$indent = ($depth) ? str_repeat("\t", $depth) : '';		
		$li_attributes = '';
		$class_names = $value = '';
		$classes   = empty($item->classes) ? array() : $item->classes;
		if($this->isMegamenu != 0 && $this->isMegamenu != intval($item->menu_item_parent) && $depth == 0 ){
			$this->isMegamenu = 0;	
		}

		 // $column_divider = array_search('column-divider', $classes);
        if ($hasColumnDivider) {
            array_push($classes, 'column-divider');
            $output .= "</ul></li><li class=\"megamenu-column\"><ul>\n";
        }
		
//		$divider_class_postion = array_search('divider', $classes);	
//		if($divider_class_postion !== false){
//			$output .= "<li class=\"divider\"></li>\n";
//			unset($classes[$divider_class_postion]);
//		}
		
		if ($hasMegaMenu) {
            array_push($classes, 'megamenu');
            $this->isMegamenu = $item->ID;
        }
		
		$classes[] = ($args->walker->has_children) ? 'dropdown' : '';
		$classes[] = ($item->current || $item->current_item_anchestor) ? 'active' : '';
		$classes[] = 'menu-item-'.$item->ID;
//		$classes[] = ($depth != 0 && $args->walker->has_children) ? 'dropdown-submenu' : '';
		if($depth == 1 && $args->walker->has_children){
			$classes[] = 'dropdown-submenu';
		}
		 if ($hasFeaturedImage) {
            array_push($classes, 'feature-image');
        }
		 if ($hasDescription) {
            array_push($classes, 'description');
        }

		$class_names = implode(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args ));
		$class_names = 'class="'.esc_attr($class_names).'"';
		$id = apply_filters('nav_menu_item_id', 'menu-item-'.$item->ID, $item, $args);
		$id = strlen($id) ? 'id="'.esc_attr($id).'"' : '';
		
		$output .= $indent.'<li ' . $id . $value . $class_names . $li_attributes . '>';
		
		
		$attributes = !empty($item->attr_title) ? 'title="'.esc_attr($item->attr_title).'"' : '';
		$attributes .= !empty($item->target) ? 'target="'.esc_attr($item->target).'"' : '';
		$attributes .= !empty($item->xfn) ? 'rel="'.esc_attr($item->xfn).'"' : '';
		$attributes .= !empty($item->url) ? 'href="'.esc_attr($item->url).'"' : '';
		$attributes .= ($args->walker->has_children) ? 'class="dropdown-toggle" data-toggle="dropdown"' : '';
		
		$item_output = $args->before;
		$item_output .= '<a '.$attributes.'>';
		
//		$has_image = array_search('feature-image', $classes);	

		 if ($hasFeaturedImage && $this->isMegamenu != 0) {
            $postID = url_to_postid( $item->url );
            $item_output .= "<img alt=\"" . esc_attr($item->attr_title) . "\" src=\"" . get_the_post_thumbnail_url( $postID ) . "\"/>";
        }

		$item_output .= $args->link_before.apply_filters('the_title', $item->title, $item->ID).$args->link_after;
		
		if(strlen($item->attr_title) > 2){
			$item_output .= '<h3 class="tit">'.$item->attr_title.'</h3>';
		}
		
		if(strlen($item->description) > 2){
			$item_output .= '</a><span class="sub">'.$item->description.'</span>';
		}
		
		
		$item_output .= ( ($depth == 0 || 1) && $args->walker->has_children ) ? '</a> ' : '</a>';
		$item_output .= $args->after; 
		
		$output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
	}
	
//	public function display_element( $element, &$children_elements, $max_depth, $args, &$output ){
//		if(!$element){
//			return;
//		}
//		$id_fields = $this->db_fields['id'];
//	}
	
	
}


}










