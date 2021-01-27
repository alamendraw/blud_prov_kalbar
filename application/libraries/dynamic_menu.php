<?php
class Dynamic_menu {
    private $ci;
    private $id_menu        = 'id="menu"';
    private $class_menu        = 'class="menu"';
    private $class_parent    = 'class="parent"';
    private $class_last        = 'class="last"';
    function __construct(){
        $this->ci =& get_instance();
    }

    function build_menu($table = '', $type = '0',$otori = '0'){
        $menu = array();
        $tampung = array();
		$CI =& get_instance();
		$otori = $CI->session->userdata('pcUser');
		
        $sq1 ="SELECT  a.id, a.title,  a.link_type,  a.page_id,  a.module_name,  a.url,  a.uri,  a.javascript,a.dyn_group_id,  a.position,  a.target,  a.parent_id,  a.is_parent,  
         a.show_menu AS show_menu FROM dyn_menu_blud a 
         JOIN d_user_group_blud b ON a.id=b.id_menu 
         INNER JOIN h_user_group_blud c ON b.id_group=c.id_group
         INNER JOIN [user_blud] d ON c.id_group=d.id_group
         WHERE d.id_user='$otori' ORDER BY a.id";
		$sq = "$sq1";
		$x = 1;
		$query=$CI->db->query($sq);
		if ($query->num_rows() > 0){
			foreach ($query->result() as $row)
			{
				$tampung[$x]					= $row->id;
				$x = $x+1;
				$menu[$row->id]['id']			= $row->id;
				$menu[$row->id]['title']		= $row->title;
				$menu[$row->id]['link']			= $row->link_type;
				$menu[$row->id]['page']			= $row->page_id;
				$menu[$row->id]['module']		= $row->module_name;
				$menu[$row->id]['url']			= $row->url;
				$menu[$row->id]['javascript']	= $row->javascript;
				$menu[$row->id]['uri']			= $row->uri;
				$menu[$row->id]['dyn_group']	= $row->dyn_group_id;
				$menu[$row->id]['position']		= $row->position;
				$menu[$row->id]['target']		= $row->target;
				$menu[$row->id]['parent']		= $row->parent_id;
				$menu[$row->id]['is_parent']	= $row->is_parent;
				$menu[$row->id]['show']			= $row->show_menu;
			}
		}
        $query->free_result();
        $html_out  = "\t".'<div '.$this->id_menu.'>'."\n";
        switch ($type){
            case 0:            // 0 = top menu
                break;

            case 1:            // 1 = horizontal menu
                $html_out .= "\t\t".'<ul '.$this->class_menu.'>'."\n";
                break;

            case 2:            // 2 = sidebar menu
                break;

            case 3:            // 3 = footer menu
                break;

            default:
                $html_out .= "\t\t".'<ul '.$this->class_menu.'>'."\n";

                break;
        }
		$x = 1;
        for ($a = 1; $a <= count($menu); $a++){
		$xid = $tampung[$a];
			if (is_array($menu[$xid])){
                if ($menu[$xid]['show'] && $menu[$xid]['parent'] == 0){
					if ($menu[$xid]['url'] <> ''){
                        $html_out .= "\t\t\t\t".'<li><a href="'.site_url().$menu[$xid]['url'].'" '.$menu[$xid]['javascript'].'><span>'.$menu[$xid]['title'].'</span></a>';
                    }elseif ($menu[$xid]['url'] <> '/welcome/'){
                        $html_out .= "\t\t\t\t".'<li><a href="'.site_url().$menu[$xid]['url'].'" '.$menu[$xid]['javascript'].'><span>'.$menu[$xid]['title'].'</span></a>';

                    }else{
						$html_out .= "\t\t\t\t".'<li><a><span>'.$menu[$xid]['title'].'&#160;<font style="float:right;">&#9662;</font></span></a>';
                    }
                    $html_out .= $this->get_childs($menu, $xid, $tampung);
                    $html_out .= '</li>'."\n";
                }
            }else{
                exit (sprintf('menu nr %s must be an array', $xid));
            }
		}
        $html_out .= "\t\t".'</ul>' . "\n";
        $html_out .= "\t".'</div>' . "\n";
        return $html_out;
    }

    function get_childs($menu, $parent_id, $tampung){
	    $has_subcats = FALSE;
        $html_out  = '';
        $html_out .= "\n\t\t\t\t".'<div>'."\n";
        $html_out .= "\t\t\t\t\t".'<ul>'."\n";
		for ($a = 1; $a <= count($menu); $a++){
		$xid = $tampung[$a];
            if ($menu[$xid ]['show'] && $menu[$xid ]['parent'] == $parent_id){
                $has_subcats = TRUE;
				if ($menu[$xid]['url'] <> ''){
					$html_out .= "\t\t\t\t\t\t".'<li><a href="'.site_url().$menu[$xid]['url'].'"  '.$menu[$xid]['javascript'].'><span>'.$menu[$xid]['title'].'</span></a>';
				}else{
					$html_out .= "\t\t\t\t\t\t".'<li><a><span>'.$menu[$xid]['title'].'&#160;<font style="float:right;">&#9656;</font></span></a>';
				}
                $html_out .= $this->get_childs($menu, $xid , $tampung);
                $html_out .= '</li>' . "\n";
            }
        }
        $html_out .= "\t\t\t\t\t".'</ul>' . "\n";
		$html_out .= "\t\t\t\t".'</div>' . "\n";
        return ($has_subcats) ? $html_out : FALSE;
    }
}