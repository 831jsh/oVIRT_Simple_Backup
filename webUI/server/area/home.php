<div style="width: 100%; z-index: 1000; font-size: 1em;  color: #333; ">

	<?php

		$clearitem = varcheck( "clearitem", '' );
		if ( preg_match( $UUIDv4, $clearitem ) ) {
			unlink( '../cache/' . $clearitem );
		}
		if ( ! file_exists( '../cache' ) ) {
			exec( 'mkdir ../cache' );
		}
		if ( ! file_exists( '../cache' ) ) {
			echo 'Error creating cache directory.';
		}

		exec( 'ls ../cache/*', $filelist );

		if ( ! empty( $filelist ) ) {

			sb_pagetitle( 'Status of Running Processes (Simple Backup)' );
			echo '<br/>';

			sb_table_start();

			$rowdata = array(
				array(
					"text"  => "VM",
					"width" => "20%",
				),
				array(
					"text"  => "Process Status",
					"width" => "30%",
				),
				array(
					"text"  => "UUID",
					"width" => "30%",
				),
				array(
					"text"  => "Backup",
					"width" => "20%",
				),
			);
			sb_table_heading( $rowdata );
		} else {
			?>
            <div style="width: 100%; position: absolute; z-index: 0; font-size: 4em; text-align: center; padding: 2em; color: #777; opacity: 0.1;">
                oVirt Simple Backup
            </div>
			<?php
		}

		foreach ( $filelist as $fileitem ) {
			exec( 'cat ' . $fileitem, $filedata );
			$vmuuid       = $filedata[0];
			$snapshotname = $filedata[1];
			$status       = $filedata[2];
			$vmname       = $filedata[3];

			if ( strpos( $status, 'Failure' ) !== false || $vmuuid == $settings['uuid_backup_engine'] ) {
				$status .= ' <a href="?area=0&clearitem=' . $vmuuid . '">Clear</a>';
			}

			$rowdata = array(
				array(
					"text" => $vmname,
				),
				array(
					"text" => $status,
				),
				array(
					"text" => $vmuuid,
				),
				array(
					"text" => $snapshotname,
				),

			);
			sb_table_row( $rowdata );

		}

		if ( ! empty( $filelist ) ) {
			sb_table_end();
			?>
            <script>
                function reloadMe() {
                    window.location.reload(true);
                }

                setTimeout(reloadMe, 5000);

            </script>
			<?php
		}

	?>

</div>