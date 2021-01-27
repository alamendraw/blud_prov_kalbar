<script type="text/javascript">
	window.print()
</script>

<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Fungsi Model
 */

class wprint extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
	
		function PopUp ($hasil)
		{
			
			 echo "$hasil";
		}
}