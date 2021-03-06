<!--{* Smarty *}-->
<!--{*
 // $Id$
 //
 // Authors:
 //      Jeff Buchbinder <jeff@freemedsoftware.org>
 //
 // FreeMED Electronic Medical Record and Practice Management System
 // Copyright (C) 1999-2012 FreeMED Software Foundation
 //
 // This program is free software; you can redistribute it and/or modify
 // it under the terms of the GNU General Public License as published by
 // the Free Software Foundation; either version 2 of the License, or
 // (at your option) any later version.
 //
 // This program is distributed in the hope that it will be useful,
 // but WITHOUT ANY WARRANTY; without even the implied warranty of
 // MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 // GNU General Public License for more details.
 //
 // You should have received a copy of the GNU General Public License
 // along with this program; if not, write to the Free Software
 // Foundation, Inc., 675 Mass Ave, Cambridge, MA 02139, USA.
*}-->
<!--{*

	File:	org.freemedsoftware.widget.patienttasks

	Reusable patient tasks widget.

	Parameters:

		$float - If set as right or left, will float the area

*}-->
<script language="javascript">

	var t = {
		dataStore: [],
		clickHandler: function ( evt ) {
			var x = this.id.replace( 'patient_task_', '' );
			var item;
			for (var i=0; i<t.dataStore.length; i++) {
				if ( t.dataStore[i].id == parseInt( x ) ) {
					item = t.dataStore[i];
				}
			}
			freemedPatientContentLoad( 'org.freemedsoftware.module.' + item.module + '.systemtask?patient=<!--{$patient|escape}-->&id=' + item.oid );
		},
		initialLoad: function ( ) {
			dojo.io.bind({
				method: 'GET',
				content: {
					param0: '<!--{$patient}-->'
				},
				url: '<!--{$relay}-->/org.freemedsoftware.module.SystemNotifications.GetSystemTaskPatientInbox',
				load: function(type, data, evt) {
					document.getElementById('patientTaskContainerInnerDiv').innerHTML = '';
					if (data.length > 0) {
						t.dataStore = data;

						var b = document.createElement( 'table' );
						var bH = document.createElement( 'thead' );
						var bHr = document.createElement( 'tr' );
						var bHh = new Array ();

						bHh[0] = document.createElement( 'th' );
						bHh[0].innerHTML = "<!--{t|escape:'javascript'}-->Date<!--{/t}-->";
						bHr.appendChild( bHh[0] );

						bHh[1] = document.createElement( 'th' );
						bHh[1].innerHTML = "<!--{t|escape:'javascript'}-->Type<!--{/t}-->";
						bHr.appendChild( bHh[1] );

						bH.appendChild( bHr );
						b.appendChild( bH );

						var bB = document.createElement( 'tbody' );

						// Loop through items
						for (var i=0; i<data.length; i++) {
							var bBr = document.createElement( 'tr' );
							var bBd = new Array ();

							bBd[0] = document.createElement( 'td' );
							bBd[0].innerHTML = data[i].stamp_mdy;
							bBr.appendChild( bBd[0] );

							bBd[1] = document.createElement( 'td' );
							bBd[1].innerHTML = data[i].module_name;
							bBr.appendChild( bBd[1] );

							bBr.id = 'patient_task_' + data[i].id;
							bBr.onclick = t.clickHandler;
							bBr.className = 'clickable';
							bB.appendChild( bBr );
						}

						b.appendChild( bB );
						document.getElementById('patientTaskContainerInnerDiv').appendChild( b );
					} else {
						var buf = "<center><!--{t|escape:'javascript'}-->No active items.<!--{/t}--></center>";
						document.getElementById('patientTaskContainerInnerDiv').innerHTML = buf;

					}
				},
				mimetype: "text/json"
			});
		} // end initialLoad
	}; // end t

	// Autoloading routine
	_container_.addOnLoad(function(){
		// Show loading
		t.initialLoad();
		document.getElementById('patientTaskContainerInnerDiv').innerHTML = "<!--{$paneLoading|replace:'"':'\\"'}-->";
	});

	_container_.addOnUnload(function(){
	});

</script>
<div id="patientTaskContainerDiv" class="patientEmrWidgetContainer" style="<!--{if $float}-->float:<!--{$float}-->;<!--{/if}-->">
	<div align="center" width="100%" class="patientEmrWidgetHeader" onClick="toggleDiv( 'patientTaskContainerInnerDiv' );"><!--{t|escape:'javascript'}-->Patient Tasks<!--{/t}--></div>
	<div id="patientTaskContainerInnerDiv"></div>
</div>

