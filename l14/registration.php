﻿<?php
	require_once "header.php";
?>
		<div class="content">
			<?php
				require_once ("classes/User.php");
				$user = new User();
				$user->actionRegistration();
			?>
		</div>
<?php
	require_once "footer.php";
?>