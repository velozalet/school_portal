<table width="100%">
	<tr>
		<td align="left">
		<p>Сколько будет 5*5?</p>
		<form action='<?php echo $_SERVER['REQUEST_URI']?>' method='POST'>
			<input type='radio' name='answer' value='c1'>25<br>
			<input type='radio' name='answer' value='c2'>20<br>
			<input type='radio' name='answer' value='c3'>15<br>
				<input type='submit' value='Answer #3'>	
		<!-- скрытые поля -->	
			<input type='hidden' name='title' value='Получите свой результат'>
			<input type='hidden' name='question' value='<?= ++$question ?>' >
		</form>
		</td>
	</tr>
</table>