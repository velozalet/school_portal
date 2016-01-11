<table width="100%">
	<tr>
		<td align="left">
		<p>Сколько будет 3*3?</p>
		<form action='<?php echo $_SERVER['REQUEST_URI']?>' method='POST'>
			<input type='radio' name='answer' value='b1'>6<br>
			<input type='radio' name='answer' value='b2'>8<br>
			<input type='radio' name='answer' value='b3'>9<br>
				<input type='submit' value='Answer #2'>
		<!-- скрытые поля -->	
			<input type='hidden' name='title' value='Ответьте на вопрос №3'>
			<input type='hidden' name='question' value='<?= ++$question ?>'>
		</form>
		</td>
	</tr>
</table>