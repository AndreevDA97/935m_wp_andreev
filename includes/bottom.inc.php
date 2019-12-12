			<div class="footer">
				<div class="center">Вариант №1 &copy; ст. гр. 935М Андреев Дмитрий. 2019 г.
				<?php if (IS_AUTH) { ?>
				 / предыдущий вход: <?=date('d.m.Y H:i:s', @$_COOKIE['LastLogin']);?></div>
				<?php } ?>
			</div> <!-- footer -->