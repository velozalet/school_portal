<table width="100%">
	<tr>
		<td align="left">
		<form action='<?php echo $_SERVER['REQUEST_URI']?>' method='POST'>
			<input type='submit' value='START TEST'>

		<!-- скрытые поля -->	
			<input type='hidden' name='title' value='Ответьте на вопрос №1'>
			<input type='hidden' name='question' value='<?= ++$question ?>'>
		</form>
		</td>
	</tr>
</table>