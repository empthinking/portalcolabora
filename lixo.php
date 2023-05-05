<?php
					if ($_SERVER['REQUEST_METHOD'] === 'POST') :
						if (isset($_SESSION['login_error'])) :
							echo 'block';
						else :
							echo 'hidden';
							unset($_SESSION['login_error']);
						endif;
					endif;
					?>