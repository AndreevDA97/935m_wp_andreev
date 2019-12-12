			<div class="header">
				<table width="900px" cellspacing="0" cellpadding="0">
					<tr>
						<td align="left" style="padding: 0 0 0 20px;">
							<img src="images/design/logo.png" alt="logo" />
						</td>
						<td align="right" style="padding: 0 200px 0 0;">
							<h1><a href="index.php">г. Касимов, 867 лет</a></h1>
						</td>
					</tr>
				</table>
				<div class="auth-row">
					<?php if (isset($_SESSION['login'])) 
					{ ?>
						<div class="auth-tab">
							Вы вошли под логином - <?=$_SESSION['login']?> (Ваш IP: <?=$_SESSION['ip']?>) / 
							<form method="GET">
								<input type="hidden" name="logout" value="true">
								<input type="submit" value="Выход" class="linkButton">
							</form>
						</div>
					<?php 
					} ?>
				</div>
			</div> <!-- header -->