<?php
 // $Id$
 // $Author$
 // desc: library for default template

define ('IMAGE_TYPE', "png");

class template {

	function patient_box_iconbar ($patient) {
		$buffer .= "<table border=\"0\" cellspacing=\"1\" cellpadding=\"1\">\n".
			"<tr>".
			
			// Icon for patient appointments
			"<td><a href=\"book_appointment.php?patient=".urlencode($patient).
			"\" onMouseOver=\"window.status='"._("Book Appointment")."'; ".
				"return true;\" ".
			"onMouseOut=\"window.status=''; return true;\"".
			"><img src=\"lib/template/".$GLOBALS['template']."/img/".
			"pbox_book_appointment.".IMAGE_TYPE."\" border=\"0\" ".
			"width=\"16\" height=\"16\" ".
			"alt=\""._("Book Appointment")."\"/></a></td>\n".
			
			"</tr></table>\n";
		return $buffer;
	} // end method patient_box_iconbar

	function summary_delete_link($class, $url) {
		$buffer .= html_form::confirm_link_widget($url,
			"<img SRC=\"lib/template/default/img/summary_delete.png\"
			BORDER=\"0\" ALT=\""._("Delete")."\"/>",
			array(
				'confirm_text' =>
				_("Are you sure you want to delete this?"),

				'text' => _("Delete")
			)
		);
		return $buffer;
	} // end function summary_delete_link

	function summary_lock_link($class, $url) {
		$buffer .= html_form::confirm_link_widget($url,
			"<img SRC=\"lib/template/default/img/summary_lock.png\"
			BORDER=\"0\" ALT=\""._("Lock")."\"/>",
			array(
				'confirm_text' =>
				_("Are you sure you want to lock this record?"),

				'text' => _("Lock")
			)
		);
		return $buffer;
	} // end function summary_lock_link

	function summary_locked_link($class, $url) {
		$buffer .= "<a onClick=\"var a=alert('".
			_("This record has been locked, and can no longer be modified.").
			"'); return true;\"
			><img SRC=\"lib/template/default/img/summary_locked.png\"
			BORDER=\"0\" ALT=\""._("Locked")."\"/></a>\n";
		return $buffer;
	} // end function summary_locked_link

	function summary_modify_link($class, $url) {
		$buffer .= "<A HREF=\"".$url."\" ".
			"><IMG SRC=\"lib/template/default/img/summary_modify.png\"
			BORDER=\"0\" ALT=\""._("Modify")."\"></A>";
		return $buffer;
	} // end function summary_modify_link

	function summary_view_link($class, $url, $newwindow = false) {
		$buffer .= "<A HREF=\"".$url."\" ".(
			$newwindow ? "TARGET=\"".$class."_view\"" : ""
			)."><IMG SRC=\"lib/template/default/img/summary_view.png\"
			BORDER=\"0\" ALT=\""._("View")."\"></A>";
		return $buffer;
	} // end function summary_modify_link

} // end class template

?>
